<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TreeCuttingPermit;
use setasign\Fpdi\Fpdi;
use App\Models\TreePlantation;
use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

use App\Models\RecentActivity;


class FileController extends Controller
{


    public function ViewFileById($id)
    {
        $file = File::findOrFail($id);
        $filePath = storage_path("app/public/{$file->file_path}");

        if (!file_exists($filePath)) {
            abort(404);
        }

        // Get the file extension
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        if ($extension === 'doc' || $extension === 'docx') {
            // Generate the public URL for the doc/docx file
            $publicFilePath = asset('storage/' . $file->file_path);
            \Log::info('Generated Document URL: ' . $publicFilePath);  // Log the URL

            return response()->json([
                'viewUrl' => "https://view.officeapps.live.com/op/embed.aspx?src=" . urlencode($publicFilePath)
            ]);
        } else {
            // Handle non-doc/docx files normally (PDFs, etc.)
            return response()->file($filePath, [
                'Content-Type' => 'application/pdf', // Set content type as needed
                'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"',
            ]);
        }
    }
    public function DownloadFileById($id)
    {
        $file = File::findOrFail($id);
        $filePath = storage_path("app/public/{$file->file_path}");

        if (!file_exists($filePath)) {
            abort(404);
        }

        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $contentType = 'application/octet-stream'; // Default content type

        if ($extension === 'pdf') {
            $contentType = 'application/pdf';
        } elseif ($extension === 'doc') {
            $contentType = 'application/msword'; // Correct MIME type for DOC files
        } elseif ($extension === 'docx') {
            $contentType = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'; // Correct MIME type for DOCX files
        }// add zip

        return response()->file($filePath, [
            'Content-Type' => $contentType,
            'Content-Disposition' => 'attachment; filename="' . basename($filePath) . '"', // Change to 'attachment' for download
        ]);
    }

    public function UpdateFileOnlyById(Request $request, $id)
    {
        try {
            $file = DB::table('files')->where('id', $id)->first();

            if (!$file) {
                return response()->json([
                    'success' => false,
                    'message' => 'File not found.'
                ], 404);
            }

            // Update the file's data
            DB::table('files')
                ->where('id', $id)
                ->update([
                    'office_source' => $request->input('office_source'),
                    'category' => $request->input('category'),
                    'classification' => $request->input('classification'),
                    'status' => $request->input('status'),
                    'updated_at' => now(), // Set the update timestamp
                ]);

            return response()->json([
                'success' => true,
                'message' => 'File updated successfully.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the file.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function EditFile(Request $request, $fileId)
    {
        try {
            $file = File::find($fileId);

            // $file = DB::table('files')
            //     ->where('id', $fileId)
            //     ->first();

            if (!$file) {
                return response()->json([
                    'success' => false,
                    'message' => 'File not found.'
                ], 404); // Return 404 if the file doesn't exist
            }
            $permit_type = $file->permit_type;

            DB::table('files')->where('id', $fileId)->update([
                'office_source' => $request->input('office_source'),
                'category' => $request->input('category'),
                'classification' => $request->input('classification'),
                'status' => $request->input('status'),
                'updated_at' => now(), // Set the update timestamp
            ]);

            switch ($permit_type) {
                case 'tree-cutting-permits':
                    DB::table('tree_cutting_permits')->where('file_id', $fileId)->update([
                        'name_of_client' => $request->input('permit.name_of_client'),
                        'number_of_trees' => $request->input('permit.number_of_trees'),
                        'location' => $request->input('permit.location'),
                        'date_applied' => $request->input('permit.date_applied')
                    ]);

                    break;

                case 'chainsaw-registration':
                    DB::table('chainsaw_registrations')->where('file_id', $fileId)->update([
                        'name_of_client' => $request->input('permit.name_of_client'),
                        'location' => $request->input('permit.location'),
                        'serial_number' => $request->input('permit.serial_number'),
                        'date_applied' => $request->input('permit.date_applied')
                    ]);
                    break;

                case 'tree-plantation':
                    DB::table('tree_plantation_registration')->where('file_id', $fileId)->update([
                        'name_of_client' => $request->input('permit.name_of_client'),
                        'number_of_trees' => $request->input('permit.number_of_trees'),
                        'location' => $request->input('permit.location'),
                        'date_applied' => $request->input('permit.date_applied')
                    ]);
                    break;

                case 'transport-permits':
                    DB::table('transport_permits')->where('file_id', $fileId)->update([
                        'name_of_client' => $request->input('permit.name_of_client'),
                        'number_of_trees' => $request->input('permit.number_of_trees'),
                        'destination' => $request->input('permit.destination'),
                        'date_applied' => $request->input('permit.date_applied'),
                        'date_of_transport' => $request->input('permit.date_of_transport')
                    ]);
                    break;

                case 'land-titles':
                    DB::table('land_titles')->where('file_id', $fileId)->update([
                        'name_of_client' => $request->input('permit.name_of_client'),
                        'location' => $request->input('permit.location'),
                        'lot_number' => $request->input('permit.lot_number'),
                        'property_category' => $request->input('permit.property_category')
                    ]);
                    break;

                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid permit type.'
                    ], 400);
            }

            // Return success response after all updates
            return response()->json([
                'success' => true,
                'message' => 'File and permit details updated successfully!',
            ], 200);

        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the file.',
                'error' => $e->getMessage()
            ], 500);
        }
    }



}



