<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileController extends Controller
{

    public function upload(Request $request)
    {
        // Validate the request
        $request->validate([
            'file' => 'required|file|max:2048', // Maximum file size of 2MB
        ]);

        // Specify the target directory on your HDD (D: drive)
        $targetDirectory = 'D:/PENRO/uploads';

        // Ensure the directory exists or create it if not
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true); // Creates the directory with permissions
        }

        // Store the file
        if ($request->file('file')->isValid()) {
            // Get the original file name
            $originalFileName = $request->file('file')->getClientOriginalName();

            // Move the uploaded file to the specified path
            $request->file('file')->move($targetDirectory, $originalFileName);

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
