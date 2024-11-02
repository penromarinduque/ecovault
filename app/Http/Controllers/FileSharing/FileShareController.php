<?php

namespace App\Http\Controllers\FileSharing;

use App\Models\FileShares;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileShareController extends Controller
{
    public function ShareFile(Request $request)
    {


        $validated = $request->validate([
            'file_id' => 'required|exists:files,id',
            'shared_with_user_id' => 'required|exists:users,id',
            'permission' => 'required|in:viewer,editor,admin',
        ]);

        // Create the file share record

        try {

            $adminId = auth()->id();



            FileShares::create([
                'file_id' => $validated['file_id'],
                'shared_with_user_id' => $validated['shared_with_user_id'],
                'shared_by_admin_id' => auth()->id(), // Assuming the logged-in admin is sharing the file
                'permission' => $validated['permission'],
            ]);



            return response()->json([
                'success' => true,
                'message' => 'File shared successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error sharing file: ' . $e->getMessage(),
            ], 500);
        }
    }



}
