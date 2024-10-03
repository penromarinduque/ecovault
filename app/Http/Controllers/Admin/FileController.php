<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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


    public function upload(Request $request)
    {

        // Validate the request
        $request->validate([
            'file' => 'required|file|max:2048', // Maximum file size of 2MB
            // 'office-source' => 'required|string|max:255', // Validate office source
            // 'category' => 'required|string|in:incoming,outgoing', // Validate category
            // 'classification' => 'required|string|in:highly-technical,simple', // Validate classification
            // 'status' => 'required|string|in:received,outgoing', // Validate status
        ]);

        // Specify the target directory on your HDD (D: drive)
        $targetDirectory = 'C:/PENRO/uploads';

        // Ensure the directory exists or create it if not
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true); // Creates the directory with permissions
        }

        // Store the file
        if ($request->file('file')->isValid()) {
            $originalFileName = $request->file('file')->getClientOriginalName();

            $request->file('file')->move($targetDirectory, $originalFileName);

            // Collect additional form data
            $formData = [
                'office_source' => $request->input('office-source'),
                'category' => $request->input('category'),
                'classification' => $request->input('classification'),
                'status' => $request->input('status'),
                'file_name' => $originalFileName,
                'upload_path' => $targetDirectory . '/' . $originalFileName, // Include upload path
            ];

            //make a file db//
            //create data

            // const fileId = file.id



            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully: ' . $originalFileName,
                'data' => $formData // Include the form data
                //  'fileId' = fileId
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'File upload failed.'
        ]);
    }
}
