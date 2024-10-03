<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    public function GetStorageUsage()
    {
        // Total and available space on the D: drive
        $totalSpace = disk_total_space('D:') / (1024 * 1024 * 1024); // Convert to GB
        $freeSpace = disk_free_space('D:') / (1024 * 1024 * 1024);   // Convert to GB
        $usedSpace = $totalSpace - $freeSpace;

        // Calculate the size of the D:\PENRO directory
        $penroDirectory = 'D:/PENRO';
        $penroSize = $this->getDirectorySize($penroDirectory) / (1024 * 1024 * 1024); // Convert to GB

        // Remaining space used by "Others" (files not in D:\PENRO)
        $otherSpace = $usedSpace - $penroSize;

        // Return the data as JSON
        return response()->json([
            'total_space' => $totalSpace,
            'free_space' => $freeSpace,
            'used_space' => $usedSpace,
            'penro_space' => $penroSize,
            'other_space' => $otherSpace
        ]);
    }

    // Function to calculate directory size recursively
    private function getDirectorySize($directory)
    {
        $size = 0;
        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory)) as $file) {
            $size += $file->getSize();
        }
        return $size;
    }
}
