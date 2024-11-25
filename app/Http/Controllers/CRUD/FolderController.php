<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\Folder;

class FolderController extends Controller
{
    //
    public function AddFolder(Request $request)
    {
        try {
            $folder = Folder::create(['folder_path' => $request->folder_path, 'folder_type' => $request->folder_type]);
            return response()->json([
                'success' => true,
                'message' => 'Folders Added Successful',
                'folder' => $folder
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function GetFolders(Request $request)
    {
        try {
            $folders = Folder::where('folder_type', $request->query('folderType'))->get();

            return response()->json([
                'success' => true,
                'message' => 'Folders fetch Successful',
                'folders' => $folders
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
