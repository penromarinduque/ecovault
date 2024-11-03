<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RecentActivity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Database\QueryException;
class StorageController extends Controller
{
    public function GetStorageUsage()
    {
        try {
            // Total and available space on the C: drive
            $totalSpace = disk_total_space('C:') / (1024 * 1024 * 1024); // Convert to GB
            $freeSpace = disk_free_space('C:') / (1024 * 1024 * 1024);   // Convert to GB
            $usedSpace = $totalSpace - $freeSpace;

            // Calculate the size of the C:\PENRO directory
            $penroDirectory = 'C:/PENRO';
            $penroSize = $this->getDirectorySize($penroDirectory) / (1024 * 1024 * 1024); // Convert to GB

            // Remaining space used by "Others" (files not in C:\PENRO)
            $otherSpace = $usedSpace - $penroSize;

            // Return the data as JSON
            return response()->json([
                'total_space' => $totalSpace,
                'free_space' => $freeSpace,
                'used_space' => $usedSpace,
                'penro_space' => $penroSize,
                'other_space' => $otherSpace
            ]);
        } catch (\Exception $e) {
            // Return an error response with the exception message
            return response()->json([
                'error' => 'An error occurred while retrieving storage usage.',
                'message' => $e->getMessage()
            ], 500);
        }
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

    public function getRecentUploads()
    {
        $recentUploads = RecentActivity::with('user')
            ->where('action', 'File uploaded successfully.')
            ->latest()
            ->take(10) // Fetch the latest 10 uploads
            ->get();

        // Check the count of uploads and prepare the response
        $data = $recentUploads->map(function ($upload) {
            return [
                'user' => $upload->user->name,
                'action' => $upload->action,
                'subject_type' => $upload->subject_type,
                'subject_id' => $upload->subject_id,
                'timestamp' => $upload->created_at->format('Y-m-d H:i:s'),
            ];
        });
        // file name

        // Return a JSON response
        return response()->json([
            'data' => $data,
            'count' => $data->count(),
            'message' => $data->isEmpty() ? 'No recent uploads found.' : 'Recent uploads retrieved successfully.',
        ]);
    }
    public function countFilesByExtension()
    {
        try {
            // Count files by their extensions based on the file_path
            $zipCount = File::where('file_path', 'like', '%.zip')->count();
            $pdfCount = File::where('file_path', 'like', '%.pdf')->count();
            $wordCount = File::where(function ($query) {
                $query->where('file_path', 'like', '%.doc')
                    ->orWhere('file_path', 'like', '%.docx');
            })->count();
            $imageCount = File::where(function ($query) {
                $query->where('file_path', 'like', '%.jpg')
                    ->orWhere('file_path', 'like', '%.jpeg')
                    ->orWhere('file_path', 'like', '%.png')
                    ->orWhere('file_path', 'like', '%.gif');
            })->count();

            // Prepare the response
            $data = [
                'zip_files' => $zipCount,
                'pdf_files' => $pdfCount,
                'word_files' => $wordCount,
                'image_files' => $imageCount,
            ];

            // Return a JSON response
            return response()->json($data, 200); // 200 OK status code
        } catch (QueryException $e) {
            // Handle any query-related exceptions
            return response()->json([
                'error' => 'Database query error',
                'message' => $e->getMessage(),
            ], 500); // 500 Internal Server Error
        } catch (\Exception $e) {
            // Handle general exceptions
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500); // 500 Internal Server Error
        }
    }

    public function GetAreaChartData()
    {
        try {
            // Fetch all files
            $files = File::all();

            // Prepare data structure
            $data = [
                'categories' => [],
                'series' => [
                    [
                        'name' => 'Uploads',
                        'data' => []
                    ]
                ]
            ];

            // Count uploads per date
            $uploadsByDate = [];

            foreach ($files as $file) {
                // Format date as needed (e.g., "2024-11-03")
                $date = $file->created_at->format('Y-m-d');

                // Count occurrences per date
                if (!isset($uploadsByDate[$date])) {
                    $uploadsByDate[$date] = 0;
                }
                $uploadsByDate[$date]++;
            }

            // Sort dates in ascending order
            ksort($uploadsByDate);

            // Populate categories and series data from the uploadsByDate array
            foreach ($uploadsByDate as $date => $count) {
                $data['categories'][] = $date;
                $data['series'][0]['data'][] = [
                    'x' => $date,
                    'y' => $count
                ];
            }

            return response()->json($data);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'No files found.'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching data: ' . $e->getMessage()], 500);
        }
    }


}

