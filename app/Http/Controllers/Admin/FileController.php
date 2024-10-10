<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TreeCuttingPermit;
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

class FileController extends Controller
{


    public function StoreFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:2048|mimes:pdf,doc,docx,jpg,jpeg,png,zip',
            'permit_type' => 'required|string',
            'municipality' => 'required|string',
            'category' => 'required|string',
            'classification' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($request->file('file')->isValid()) {
            // Get the original file name and sanitize it to prevent issues with spaces or special characters
            $originalFileName = $request->file('file')->getClientOriginalName();
            $sanitizedFileName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $originalFileName);

            // Define the directory structure based on the current date and file type    
            $uploadDir = "PENRO/uploads/{$request->input('permit_type')}/{$request->input('municipality')}";

            $filePath = $request->file('file')->storeAs("public/{$uploadDir}", $sanitizedFileName, 'public');

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

            $file = File::create($formData);

            return response()->json([
                'success' => true,
                'message' => "File Upload Success",
                'form' => $formData,
                'fileId' => $file->id,
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
    public function download($id)
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
            $file = File::find($id);
            return response()->json(["success" => true, "file" => $file]);


            //condition 

            //switch ($type)
            //case : 
            // $files = DB::table('files')
            //     ->join('users', 'files.user_id', '=', 'users.id') // Join with users table
            //     ->where('files.permit_type', $type)
            //     ->where('files.municipality', $municipality)
            //     ->select('files.*', 'users.name as user_name') // Select all fields from files and the name from users
            //     ->get();
            //break


        } catch (\Exception $e) {
            return response()->json(["succress" => false]);
        }

    }

}



