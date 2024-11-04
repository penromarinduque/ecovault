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

class UploadController extends Controller
{
    public function StoreFile(Request $request)
    {
        $isArchived = filter_var($request->query('isArchived', false), FILTER_VALIDATE_BOOLEAN);

        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip',
            'permit_type' => 'nullable|string', // Make this field nullable
            'municipality' => 'nullable|string', // Make this field nullable
            'category' => 'nullable|string', // Make this field nullable
            'classification' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($request->file('file')->isValid()) {

            $file = $request->file('file');
            $originalFileName = $file->getClientOriginalName();
            $sanitizedFileName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $originalFileName);
            $extension = $file->getClientOriginalExtension();

            $uploadDir = "PENRO/uploads/{$request->input('permit_type')}/{$request->input('municipality')}";

            $filePath = $request->file('file')->storeAs("{$uploadDir}", $sanitizedFileName, 'public');
            // Get the relative path to store in the database
            $relativeFilePath = str_replace('public/', '', $filePath); // Remove 'public/' to get the path you want to store


            // Create the form data to store in your database
            $formData = [
                'permit_type' => $request->input('permit_type'),  // Ensure this is present in the request
                'land_category' => $request->input('land_category'), // This can be null
                'municipality' => $request->input('municipality'), // Ensure this is present in the request
                'report_type' => $request->input('report_type'),
                'file_name' => $originalFileName,
                'file_path' => $relativeFilePath, // The path to the uploaded file
                'office_source' => $request->input('office_source'),
                'category' => $request->input('category'), // Ensure this is present in the request
                'classification' => $request->input('classification'), // Ensure this is present in the request
                'status' => $request->input('status'), // Ensure this is present in the request
                'user_id' => auth()->user()->id, // Assuming you're using auth to get the logged-in user's ID
                'is_archived' => $isArchived
            ];

            $fileEntry = File::create($formData);
            $url = url("/download/{$fileEntry->id}");
            $result = Builder::create()
                ->writer(new PngWriter())
                ->data($url)
                ->size(300)
                ->margin(10)
                ->build();

            // Save QR code to storage
            $qrCodeFilePath = "qrcodes/qrcode_{$fileEntry->id}.png";
            Storage::disk('public')->put($qrCodeFilePath, $result->getString());
            // Log file and QR code paths

            if ($extension === 'docx') {
                $filePath = $this->embedQrCodeInDocx($filePath, $qrCodeFilePath);
            } elseif ($extension === 'pdf') {
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
            throw new \Exception("ZIP file not found at: {$fullFilePath}");
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
                if (pathinfo($file, PATHINFO_EXTENSION) === 'docx') {
                    $this->embedQrCodeInDocx("uploads/temp/{$file}", $qrCodePath);
                } elseif (pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {
                    $this->embedQrCodeInPdf("uploads/temp/{$file}", $qrCodePath);
                }
            }

            // Overwrite the original ZIP file without changing its name
            $newZip = new \ZipArchive();
            if ($newZip->open($fullFilePath, \ZipArchive::OVERWRITE) !== TRUE) {
                throw new \Exception("Could not overwrite the ZIP file");
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
            throw new \Exception("Could not open ZIP file at: {$fullFilePath}");
        }
    }
    private function deleteDir($dir)
    {
        if (!is_dir($dir)) {
            return;
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? deleteDir("$dir/$file") : unlink("$dir/$file");
        }
        rmdir($dir);
    }
    private function embedQrCodeInDocx($filePath, $qrCodePath)
    {
        // Load the existing DOCX file
        $fullFilePath = storage_path("app/public/{$filePath}");

        // Check if the DOCX file exists
        if (!file_exists($fullFilePath)) {
            throw new \Exception("DOCX file not found at: {$fullFilePath}");
        }

        // Create a new PHPWord object
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($fullFilePath);


        // Add a new section to the document
        $section = $phpWord->addSection();

        // Add existing content to the new section if needed
        // You may want to read the original sections and add them here
        $qrCodeFullPath = storage_path("app/public/{$qrCodePath}");
        if (!file_exists($qrCodeFullPath)) {
            throw new \Exception("QR Code not found at: {$qrCodeFullPath}");
        }

        // // Add the QR Code Image


        $section = $phpWord->getSections()[0];

        // Add the QR Code image to the footer at the bottom right corner
        foreach ($phpWord->getSections() as $section) {
            $footer = $section->addFooter();
            $footer->addImage($qrCodeFullPath, [
                'width' => 40, // Image width in points
                'height' => 40, // Image height in points
                'wrappingStyle' => 'infront', // Image in front of the text
                'positioning' => 'absolute', // Absolute positioning for precise placement
                'posHorizontal' => 'right', // Align to the right side
                'posHorizontalRel' => 'page', // Relative to the entire page width
                'posVertical' => 'bottom', // Align vertically to the bottom
                'posVerticalRel' => 'page', // Relative to the entire page height
                'marginBottom' => 40, // Distance from the bottom of the page
                'marginRight' => 40, // Distance from the right of the page
            ]);
        }

        // Save the modified document
        // $newFilePath = storage_path("app/public/uploads/") . uniqid() . '_modified.docx';
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($fullFilePath);

        return $fullFilePath; // Return the path of the modified document
    }
    public function embedQrCodeInPdf($filePath, $qrCodePath)
    {
        // Load the existing PDF file
        $fullFilePath = storage_path("app/public/{$filePath}");

        // Check if the PDF file exists
        if (!file_exists($fullFilePath)) {
            throw new \Exception("PDF file not found at: {$fullFilePath}");
        }

        // Load the QR Code image
        $qrCodeFullPath = storage_path("app/public/{$qrCodePath}");
        if (!file_exists($qrCodeFullPath)) {
            throw new \Exception("QR Code not found at: {$qrCodeFullPath}");
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
            $marginTop = 10;   // Margin from the top edge of the page

            // Set QR Code size and position (adjust as needed)
            $qrCodeWidth = 20; // Width in mm
            $qrCodeHeight = 20; // Height in mm

            // Calculate the QR code position at the top-right corner
            $xPosition = $pageWidth - $qrCodeWidth - $marginRight;
            $yPosition = $marginTop;

            // Add the QR Code image, which will appear on top of any existing content
            $pdf->Image($qrCodeFullPath, $xPosition, $yPosition, $qrCodeWidth, $qrCodeHeight);
        }

        // Save the modified PDF to the same file path
        $pdf->Output('F', $fullFilePath);

        return $fullFilePath;
    }

}
