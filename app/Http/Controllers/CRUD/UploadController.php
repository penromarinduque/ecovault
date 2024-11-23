<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\TreeCuttingPermit;
use setasign\Fpdi\Fpdi;
use App\Models\TreePlantation;
use App\Models\TreeCutting;
use App\Models\ChainsawRegistration;
use App\Models\TreePlantationRegistration;
use App\Models\TransportPermit;
use App\Models\LandTitle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use App\Models\RecentActivity;
use App\Models\File;
use Exception;

class UploadController extends Controller
{
    public function StoreFile(Request $request)
    {
        $type = $request->query('type');
        $municipality = $request->query('municipality');
        $report = $request->query('report');
        $category = $request->query('category');
        $currentUserId = auth()->id();
        $isArchived = filter_var($request->query('isArchived', false), FILTER_VALIDATE_BOOLEAN);

        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png,zip',
            'permit_type' => 'nullable|string', // Make this field nullable
            'municipality' => 'nullable|string', // Make this field nullable
            'classification' => 'required|string',
        ]);

        if ($request->file('file')->isValid()) {

            $file = $request->file('file');
            $originalFileName = $file->getClientOriginalName();
            $sanitizedFileName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $originalFileName);
            $extension = $file->getClientOriginalExtension();

            //file manager na folder
            if ($type) {
                $uploadDir = "PENRO/uploads/{$request->input('type')}/{$request->input('municipality')}";
            } else {
                $uploadDir = "PENRO/uploads/{$report}";
            }


            //PENRO/uploads/{$request->input('report_type')}

            $filePath = $request->file('file')->storeAs("{$uploadDir}", $sanitizedFileName, 'public');
            // Get the relative path to store in the database
            $relativeFilePath = str_replace('public/', '', $filePath); // Remove 'public/' to get the path you want to store


            // Create the form data to store in your database
            $formData = [
                'permit_type' => $type,  // Ensure this is present in the request
                'land_category' => $category, // This can be null
                'municipality' => $municipality, // Ensure this is present in the request
                'report_type' => $report,
                'file_name' => $originalFileName,
                'file_path' => $relativeFilePath, // The path to the uploaded file
                'office_source' => $request->input('office_source'),
                'classification' => $request->input('classification'), // Ensure this is present in the request
                'user_id' => auth()->user()->id, // Assuming you're using auth to get the logged-in user's ID
                'is_archived' => $isArchived,
            ];

            if ($isArchived) {
                $formData['archived_at'] = now();
            }

            $fileEntry = File::create($formData);
            $url = url("/download/{$fileEntry->id}"); //previw page
            $result = Builder::create()
                ->writer(new PngWriter())
                ->data($url)
                ->size(300)
                ->margin(10)
                ->build();

            // Save QR code to storage
            $qrCodeFilePath = "PENRO/qrcodes/qrcode_{$fileEntry->id}.png";
            Storage::disk('public')->put($qrCodeFilePath, $result->getString());
            // Log file and QR code paths

            if ($extension === 'pdf') {
                $filePath = $this->embedQrCodeInPdf($filePath, $qrCodeFilePath);
            } elseif ($extension === 'zip') {
                // Process the ZIP file
                $filePath = $this->processZipFile($filePath, $qrCodeFilePath);
            }

            activity()
                ->causedBy(auth()->user())
                ->performedOn($fileEntry)
                ->log('File uploaded successfully.');

            RecentActivity::create([
                'user_id' => auth()->user()->id,
                'action' => 'File uploaded successfully.',
                'subject_type' => get_class($fileEntry),
                'subject_id' => $fileEntry->id,
            ]);
            return response()->json([
                'success' => true,
                'message' => "File Upload Success",
                'form' => $formData,
                'fileId' => $fileEntry->id,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'File upload failed.',
            'debug' => $request->all(),
        ]);
    }
    private function processZipFile($filePath, $qrCodePath)
    {
        // Full path to the original ZIP file
        $fullFilePath = storage_path("app/public/{$filePath}");
        // Check if the ZIP file exists
        if (!file_exists($fullFilePath)) {
            throw new Exception("ZIP file not found at: {$fullFilePath}");
        }
        $zip = new \ZipArchive();
        if ($zip->open($fullFilePath) === TRUE) {
            // Create temporary directory for extraction
            $tempDir = storage_path("app/public/uploads/temp/");
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }

            // Extract the ZIP contents
            $zip->extractTo($tempDir);
            $zip->close();

            // Loop through extracted files and process them
            $files = scandir($tempDir);
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {
                    $this->embedQrCodeInPdf("uploads/temp/{$file}", $qrCodePath);
                }
            }

            // Overwrite the original ZIP file without changing its name
            $newZip = new \ZipArchive();
            if ($newZip->open($fullFilePath, \ZipArchive::OVERWRITE) !== TRUE) {
                throw new Exception("Could not overwrite the ZIP file");
            }

            // Add the modified files back into the original ZIP file
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $newZip->addFile("{$tempDir}/{$file}", $file);
                }
            }

            $newZip->close();

            // Clean up temporary files and directory
            $this->deleteDir($tempDir); // Custom function to delete the directory

            return $filePath; // Return the original file path
        } else {
            throw new Exception("Could not open ZIP file at: {$fullFilePath}");
        }
    }
    private function deleteDir($dir)
    {
        if (!is_dir($dir)) {
            return;
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->deleteDir("$dir/$file") : unlink("$dir/$file");
        }
        rmdir($dir);
    }
    public function embedQrCodeInPdf($filePath, $qrCodePath)
    {
        // Load the existing PDF file
        $fullFilePath = storage_path("app/public/{$filePath}");

        // Check if the PDF file exists
        if (!file_exists($fullFilePath)) {
            throw new Exception("PDF file not found at: {$fullFilePath}");
        }

        // Load the QR Code image
        $qrCodeFullPath = storage_path("app/public/{$qrCodePath}");
        if (!file_exists($qrCodeFullPath)) {
            throw new Exception("QR Code not found at: {$qrCodeFullPath}");
        }

        // Create a new FPDI object
        $pdf = new Fpdi();

        // Set the source file
        $pageCount = $pdf->setSourceFile($fullFilePath);

        // Import each page
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            // Import the current page as a template
            $templateId = $pdf->importPage($pageNo);

            // Add a new page and use the imported template
            $pdf->AddPage();
            $pdf->useTemplate($templateId);

            // Get the page dimensions
            $pageWidth = $pdf->GetPageWidth();
            $pageHeight = $pdf->GetPageHeight();
            $marginRight = 10; // Margin from the right edge of the page
            $marginBottom = 10; // Margin from the bottom edge of the page

            // Set QR Code size and position (adjust as needed)
            $qrCodeWidth = 20; // Width in mm
            $qrCodeHeight = 20; // Height in mm

            // Calculate the QR code position at the bottom-right corner
            $xPosition = $pageWidth - $qrCodeWidth - $marginRight;
            $yPosition = $pageHeight - $qrCodeHeight - $marginBottom;

            // Add the QR Code image, which will appear on top of any existing content
            $pdf->Image($qrCodeFullPath, $xPosition, $yPosition, $qrCodeWidth, $qrCodeHeight);
        }


        // Save the modified PDF to the same file path
        $pdf->Output('F', $fullFilePath);

        return $fullFilePath;
    }

    public function MoveFileById(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $file = File::findOrFail($id);
            $type = $file->permit_type;

            if (!$file) {
                return response()->json([
                    'success' => true,
                    'message' => "File  doesn't exist",
                ], 200);
            }

            $currentFilePath = $file->file_path; // Assuming file_path is stored without 'public/' prefix
            if (!Storage::disk('public')->exists($currentFilePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File does not exist on the server.',

                ], 404);
            }

            if ($file->permit_type) {
                $destinationMunicipality = $request->input('move_to_municipality');
                $newFilePath = "PENRO/uploads/{$file->permit_type}/{$destinationMunicipality}";

                Storage::disk('public')->move($currentFilePath, $newFilePath);

                $file->update(['municipality' => $destinationMunicipality]);
            } else {
                $destinationReportType = $request->input('move_to_report_type');
                $file->update(['report_type' => $destinationReportType]);
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'test',
                'file' => $file,
                'file-path' => $currentFilePath

            ], 200);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'test',
                404
            ]);
        }
    }


}
