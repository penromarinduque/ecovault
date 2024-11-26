<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RecentActivity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Config;
use Illuminate\Database\QueryException;
class StorageController extends Controller
{
    public function GetStorageUsage()
    {
        try {

            $drive = Config::first();

            // Total and available space on the C: drive
            $totalSpace = disk_total_space($drive->Drive) / (1024 * 1024 * 1024); // Convert to GB
            $freeSpace = disk_free_space($drive->Drive) / (1024 * 1024 * 1024);   // Convert to GB
            $usedSpace = $totalSpace - $freeSpace;

            // Calculate the size of the C:\PENRO directory
            $penroDirectory = storage_path('app/public/PENRO');

            if (!is_dir($penroDirectory)) {
                return response()->json([
                    'error' => 'Directory does not exist.',
                    'message' => "The directory {$penroDirectory} does not exist."
                ], 404);
            }

            $penroSize = $this->getDirectorySize($penroDirectory) / (1024 * 1024 * 1024); // Convert to GB

            // Ensure penroSize is a valid number
            if (!is_numeric($penroSize)) {
                return response()->json([
                    'error' => 'Error calculating PENRO directory size.',
                    'message' => 'The directory size could not be calculated.'
                ], 500);
            }

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
            // Log the error
            Log::error('Error calculating storage usage: ' . $e->getMessage());

            // Return an error response with the exception message
            return response()->json([
                'error' => 'An error occurred while retrieving storage usage.',
                'message' => $e->getMessage()
            ], 500);
        }
    }



    private function getDirectorySize($directory)
    {
        $size = 0;
        try {
            $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory));
            foreach ($iterator as $file) {
                if ($file->isFile()) {
                    $size += $file->getSize();
                }
            }
        } catch (\Exception $e) {
            // Log the error or handle it appropriately
            Log::error('Error calculating directory size: ' . $e->getMessage());
            return 0;  // Return 0 if there's an error
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

            // Get the current date and previous date (to separate current from previous uploads)
            $currentDate = now()->format('Y-m-d');
            $previousDate = now()->subDays(1)->format('Y-m-d'); // Adjust if needed

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

            // Separate the current uploads and previous uploads
            $currentUploads = isset($uploadsByDate[$currentDate]) ? $uploadsByDate[$currentDate] : 0;
            $previousUploads = isset($uploadsByDate[$previousDate]) ? $uploadsByDate[$previousDate] : 0;

            // Calculate percentage change
            $percentageChange = 0;
            if ($previousUploads > 0) {
                $percentageChange = (($currentUploads - $previousUploads) / $previousUploads) * 100;
            }

            // Calculate total uploads
            $totalUploads = array_sum($uploadsByDate);

            // Prepare the final data
            $data['totalUploads'] = $totalUploads;
            $data['percentageChange'] = $percentageChange;
            $data['categories'] = array_keys($uploadsByDate);
            $data['series'][0]['data'] = array_map(function ($date) use ($uploadsByDate) {
                return ['x' => $date, 'y' => $uploadsByDate[$date]];
            }, array_keys($uploadsByDate));

            return response()->json($data);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'No files found.'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching data: ' . $e->getMessage()], 500);
        }
    }






}

