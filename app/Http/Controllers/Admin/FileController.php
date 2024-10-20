<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TreeCuttingPermit;
use setasign\Fpdi\Fpdi;
use App\Models\TreePlantation;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\TreeCutting;
use App\Models\ChainsawRegistration;
use App\Models\TreePlantationRegistration;
use App\Models\TransportPermit;
use App\Models\LandTitle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Writer\PngWriter;
use PhpOffice\PhpWord\TemplateProcessor;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use setasign\Fpdf\Fpdf;
use App\Models\RecentActivity;
class FileController extends Controller
{


    public function StoreFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:2048|mimes:pdf,doc,docx,jpg,jpeg,png,zip',
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
                'file_name' => $originalFileName,
                'file_path' => $relativeFilePath, // The path to the uploaded file
                'office_source' => $request->input('office_source'),
                'category' => $request->input('category'), // Ensure this is present in the request
                'classification' => $request->input('classification'), // Ensure this is present in the request
                'status' => $request->input('status'), // Ensure this is present in the request
                'user_id' => auth()->user()->id, // Assuming you're using auth to get the logged-in user's ID
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


    public function StorePermit(Request $request)
    {

        switch ($request->permit_type) {
            case 'tree-cutting-permits':
                TreeCuttingPermit::create([
                    'file_id' => $request->file_id,
                    'name_of_client' => $request->name_of_client,
                    'number_of_trees' => $request->number_of_trees,
                    'location' => $request->location,
                    'date_applied' => $request->date_applied,
                ]);
                break;

            case 'chainsaw-registration':
                ChainsawRegistration::create([
                    'file_id' => $request->file_id,
                    'name_of_client' => $request->name_of_client,
                    'location' => $request->location,
                    'serial_number' => $request->serial_number,
                    'date_applied' => $request->date_applied,
                ]);
                break;

            case 'tree-plantation':
                TreePlantation::create([
                    'file_id' => $request->file_id,
                    'name_of_client' => $request->name_of_client,
                    'number_of_trees' => $request->number_of_trees,
                    'location' => $request->location,
                    'date_applied' => $request->date_applied,
                ]);
                break;

            case 'tree-transport-permits':
                TransportPermit::create([
                    'file_id' => $request->file_id,
                    'name_of_client' => $request->name_of_client,
                    'number_of_trees' => $request->number_of_trees,
                    'destination' => $request->destination,
                    'date_applied' => $request->date_applied,
                    'date_of_transport' => $request->date_of_transport,
                ]);
                break;

            case 'land-titles':
                LandTitle::create([
                    'file_id' => $request->file_id,
                    'name_of_client' => $request->name_of_client,
                    'location' => $request->location,
                    'lot_number' => $request->lot_number,
                    'property_category' => $request->property_category,
                ]);
                break;

            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid permit type.',
                    'received_permit_type' => $request->permit_type
                ]);
        }

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'scucess permit type.',
            'permit' => $request->permit_type
        ]);
    }

    public function GetFiles($type, $municipality)
    {
        try {
            $files = DB::table('files')
                ->join('users', 'files.user_id', '=', 'users.id') // Join with users table
                ->where('files.permit_type', $type)
                ->where('files.municipality', $municipality)
                ->select('files.*', 'users.name as user_name') // Select all fields from files and the name from users
                ->get();
            return response()->json([
                'success' => true,
                'data' => $files,
                'message' => 'Files retrieved successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving files.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function Download($id)
    {
        // Fetch the file record from the database
        $file = File::find($id);

        // Check if the file exists in the database
        if (!$file) {
            return response()->json([
                'message' => 'File not found.'
            ], 404);
        }

        // Define the path to the file in storage
        $filePath = $file->file_path; // Assuming 'file_path' is a column in your 'files' table

        // Check if the file exists in storage
        if (!Storage::exists($filePath)) {
            return response()->json([
                'message' => 'File not found in storage.'
            ], 404);
        }

        // Retrieve the file's content and mime type
        $fileContents = Storage::get($filePath);
        $mimeType = Storage::mimeType($filePath);
        $fileName = basename($filePath);

        // Return the file as a download response
        return response($fileContents, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    public function GetFileById($id)
    {
        try {
            // First, retrieve the file and its permit type
            $file = DB::table('files')
                ->where('id', $id)
                ->first();

            if (!$file) {
                return response()->json([
                    'success' => false,
                    'message' => 'File not found.'
                ], 404);
            }

            // Get the permit type from the file
            $permit_type = $file->permit_type;

            // Initialize the variable to store permit details
            $permit_details = null;

            // Switch case based on the permit type
            switch ($permit_type) {
                case 'tree-cutting-permits':
                    $permit_details = DB::table('tree_cutting_permits')
                        ->where('file_id', $id)
                        ->first();
                    break;

                case 'chainsaw-registration':
                    $permit_details = DB::table('chainsaw_registration')
                        ->where('file_id', $id)
                        ->first();
                    break;

                case 'tree-plantation':
                    $permit_details = DB::table('tree_plantation')
                        ->where('file_id', $id)
                        ->first();
                    break;

                case 'tree-transport-permits':
                    $permit_details = DB::table('tree_transport_permits')
                        ->where('file_id', $id)
                        ->first();
                    break;

                case 'land-titles':
                    $permit_details = DB::table('land_titles')
                        ->where('file_id', $id)
                        ->first();
                    break;

                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid permit type.',
                        'received_permit_type' => $permit_type
                    ], 400);
            }

            // Check if permit details were found
            if (!$permit_details) {
                return response()->json([
                    'success' => false,
                    'message' => 'Permit details not found for the provided file ID.',
                ], 404);
            }

            // Return a success response with permit details and file data
            return response()->json([
                'success' => true,
                'message' => 'Permit details retrieved successfully.',
                'file' => $file,  // Return file data including office source
                'permit' => $permit_details // Return permit details based on permit type
            ], 200);

        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving the file.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function Upload(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'file' => 'required|mimes:doc,docx,pdf,zip,rar|max:2048',
        ]);

        // Generate a unique ID for the file
        $randomId = uniqid();
        $file = $request->file('file');

        // Sanitize the original file name
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();

        // Sanitize the file name: replace spaces with underscores and remove special characters
        $sanitizedFileName = preg_replace('/[^A-Za-z0-9-_\.]/', '_', $originalFileName);
        $sanitizedFileName = str_replace(' ', '_', $sanitizedFileName); // Optional: replace spaces with underscores
        $sanitizedFileName = "{$randomId}_{$sanitizedFileName}.{$extension}";

        // Store the uploaded file
        $filePath = $file->storeAs('uploads', $sanitizedFileName, 'public');

        // Generate QR code URL
        $url = url("/download/{$randomId}");
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($url)
            ->size(300)
            ->margin(10)
            ->build();

        // Save QR code to storage
        $qrCodeFilePath = "qrcodes/{$randomId}.png";
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
        return response()->json([
            'file_path' => $filePath,
            'qr_code_path' => $qrCodeFilePath,
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
                'posHorizontal' => 'left', // Align to the right side
                'posHorizontalRel' => 'page', // Relative to the entire page width
                'posVertical' => 'bottom', // Align vertically to the bottom
                'posVerticalRel' => 'page', // Relative to the entire page height
                'marginBottom' => 10, // Distance from the bottom of the page
                'marginLeft' => 460, // Large margin to ensure the right alignment\\

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
            $templateId = $pdf->importPage($pageNo);
            $pdf->AddPage();
            $pdf->useTemplate($templateId);


            $pageWidth = $pdf->GetPageWidth();
            $pageHeight = $pdf->GetPageHeight();
            $marginRight = 10; // Margin from the right edge of the page
            $marginBottom = 10; // Margin from the bottom edge of the page

            // Set QR Code size and position (you can adjust these values)
            $qrCodeWidth = 20; // Width in mm
            $qrCodeHeight = 20; // Height in mm
            $marginLeft = 10; // Margin from the left edge of the page
            $marginTop = 10; // Margin from the top edge of the page


            $xPosition = $pageWidth - $qrCodeWidth - $marginRight;
            $yPosition = $pageHeight - $qrCodeHeight - $marginBottom;

            // Add the QR Code image
            $pdf->Image($qrCodeFullPath, $xPosition, $yPosition, $qrCodeWidth, $qrCodeHeight);
        }

        // Save the modified PDF to a new file

        $pdf->Output('F', $fullFilePath);

        return $fullFilePath;
    }

    public function GetFilesWithoutRelationships()
    {
        try {
            // Fetch files without any relationships
            $files = File::whereDoesntHave('treeCuttingPermits')
                ->whereDoesntHave('chainsawRegistrations')
                ->whereDoesntHave('treePlantationRegistrations')
                ->whereDoesntHave('transportPermits')
                ->whereDoesntHave('landTitles')
                ->with('user:id,name')
                ->get();

            $files = $files->map(function ($file) {
                return [
                    'id' => $file->id,
                    'file_name' => $file->file_name,
                    'updated_at' => $file->updated_at->format('Y-m-d H:i:s'),
                    'user_name' => $file->user_name,
                    'category' => $file->category,
                    'classification' => $file->classification,
                    'status' => $file->status,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Files retrieved successfully.',
                'files' => $files
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving files.',
                'error' => $e->getMessage(),
            ]);
        }

    }



}



