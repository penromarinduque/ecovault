<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
 
class FileController extends Controller
{

    // public function upload(Request $request)
    // {
    //     // Validate the request
    //     $request->validate([
    //         'file' => 'required|file|max:2048', // Maximum file size of 2MB
    //     ]);

    //     // Specify the target directory on your HDD (D: drive)
    //     $targetDirectory = 'D:/PENRO/uploads';

    //     // Ensure the directory exists or create it if not
    //     if (!file_exists($targetDirectory)) {
    //         mkdir($targetDirectory, 0755, true); // Creates the directory with permissions
    //     }

    //     // Store the file
    //     if ($request->file('file')->isValid()) {

    //         $originalFileName = $request->file('file')->getClientOriginalName();


    //         $request->file('file')->move($targetDirectory, $originalFileName);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'File uploaded successfully: ' . $originalFileName
    //         ]);
    //     }

    //     return response()->json([
    //         'success' => false,
    //         'message' => 'File upload failed.'
    //     ]);
    // }


    // public function upload(Request $request)
    // {

    //     // Validate the request
    //     $request->validate([
    //         'file' => 'required|file|max:2048', 
    //     ]);

    //     // Specify the target directory on your HDD (D: drive)
    //     $targetDirectory = 'C:/PENRO/uploads';

    //     // Ensure the directory exists or create it if not
    //     if (!file_exists($targetDirectory)) {
    //         mkdir($targetDirectory, 0755, true); // Creates the directory with permissions
    //     }

    //     // Store the file
    //     if ($request->file('file')->isValid()) {
    //         $originalFileName = $request->file('file')->getClientOriginalName();

    //         $request->file('file')->move($targetDirectory, $originalFileName);

    //         // Collect additional form data
    //         $formData = [
    //             'office_source' => $request->input('office-source'),
    //             'category' => $request->input('category'),
    //             'classification' => $request->input('classification'),
    //             'status' => $request->input('status'),
    //             'file_name' => $originalFileName,
    //             'upload_path' => $targetDirectory . '/' . $originalFileName, // Include upload path
    //         ];

            
    //         // $file = File::create([
    //         //     ''

    //         // ]);
    //         //make a file db//
    //         //create data

    //         // const fileId = file.id



    //         return response()->json([
    //             'success' => true,
    //             'message' => 'File uploaded successfully: ' . $originalFileName,
    //             'data' => $formData // Include the form data
    //             //  'fileId' = fileId
    //         ]);
    //     }

    //     return response()->json([
    //         'success' => false,
    //         'message' => 'File upload failed.'
    //     ]);
    // }

    public function upload(Request $request)
    {           
        $request->validate([
        'file' => 'required|file|max:2048', // Maximum file size of 2MB
    ]);

    // Check if the file is valid
    if ($request->file('file')->isValid()) {
        // Store the file in 'PENRO/uploads' directory
       $originalFileName = $request->file('file')->getClientOriginalName();
       $fileName = time() . '_' . $originalFileName;
       $path = $request->file('file')->storeAs('PENRO/uploads', $fileName);

       
       return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully: ' . $originalFileName
        ]);

 
    }
    return response()->json([
            'success' => false,
            'message' => 'File upload failed.'
        ]);
    }
}
