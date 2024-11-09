<?php

namespace App\Http\Controllers\Backup;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class BackupController extends Controller
{
    public function Backup()
    {
        try {
            // Define database connection settings
            $dbHost = env('DB_HOST', '127.0.0.1');
            $dbName = env('DB_DATABASE', 'penro_archiving_system');
            $dbUser = env('DB_USERNAME', 'root');
            $dbPassword = env('DB_PASSWORD', '');

            $config = Config::First();
            $drive = $config->Drive;

            // Define the backup file path
            $backupDir = $drive . $config->BackDirSQL;
            $backupDirFiles = $drive . $config->BackDirFiles;
            if (!File::exists($backupDir)) {
                File::makeDirectory($backupDir, 0755, true);
            }
            if (!File::exists($backupDirFiles)) {
                File::makeDirectory($backupDirFiles, 0755, true);
            }
            // Create database backup
            $backupFilePath = $backupDir . '/' . $dbName . '_backup_' . date('Y_m_d_H_i_s') . '.sql';
            // Create the mysqldump command
            $command = "$config->MySqlDumpDir -h$dbHost -u$dbUser " . ($dbPassword ? "-p$dbPassword " : "") . "$dbName > \"$backupFilePath\"";
            // Execute the command
            Log::info("Backup commane: SQL => $$config->MySqlDumDir, Files => $backupDirFiles");

            exec($command, $output, $returnVar);


            if ($returnVar !== 0) {
                return response()->json(['error' => 'Database backup failed.'], 500);
            }
            $zipFilePath = $backupDirFiles . '/' . $dbName . '_backup_' . date('Y_m_d_H_i_s') . '.zip';
            Log::info("Backup directories: SQL => $backupDir, Files => $backupDirFiles");
            Log::info("Backup file path: $backupFilePath");
            Log::info("Zip file path: $zipFilePath");

            // Create the ZipArchive and add the SQL backup and PENRO folder files
            $zip = new \ZipArchive();
            if ($zip->open($zipFilePath, \ZipArchive::CREATE) === true) {
                // Add SQL backup file to the zip
                $zip->addFile($backupFilePath, basename($backupFilePath));

                // Add files from PENRO folder to the zip
                $penroDir = storage_path($config->StorePath); // Path to the PENRO folder
                $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($penroDir));
                foreach ($files as $file) {
                    if (!$file->isDir()) {
                        // Get the real path and relative path to add it in the zip
                        $filePath = $file->getRealPath();
                        $relativePath = 'PENRO/' . substr($filePath, strlen($penroDir) + 1);
                        $zip->addFile($filePath, $relativePath);
                    }
                }

                // Close the zip file after adding all files
                $zip->close();

            }


            return response()->json(['success' => 'Database backup was successful. File saved to ' . $backupFilePath]);
        } catch (\Exception $e) {
            Log::error('Database backup failed: ' . $e->getMessage());
            return response()->json(['error' => 'Database backup failed: ' . $e->getMessage()], 500);
        }
    }
    public function Restore(Request $request)
    {
        try {
            $config = Config::find(1);
            $drive = $config->Drive;
            // Validate the zip file parameter
            $zipFileName = $request->input('backup_file');
            Log::info("Requested backup file: $zipFileName"); // Add this line to log the file name

            if (!$zipFileName) {
                return response()->json(['error' => 'No backup file specified.'], 400);
            }



            $backupDir = $drive . $config->BackDirFiles; // Directory where zip backups are stored
            $storageBackupDir = storage_path($config->StorePath); // Target directory for storage files

            // Full path to the selected backup file
            $zipFilePath = $backupDir . '/' . $zipFileName;
            Log::info("Backup file full path: $zipFilePath"); // Add this to verify the full path

            if (!File::exists($zipFilePath)) {
                return response()->json(['error' => 'Specified backup file does not exist.'], 404);
            }

            $tempExtractDir = storage_path('app/temp_restore');
            if (File::exists($tempExtractDir)) {
                File::deleteDirectory($tempExtractDir);
            }
            File::makeDirectory($tempExtractDir, 0755, true);

            $zip = new \ZipArchive();
            if ($zip->open($zipFilePath) === true) {
                Log::info("Successfully opened zip file: $zipFilePath");
                $zip->extractTo($tempExtractDir);
                $zip->close();
            } else {
                Log::error("Failed to open zip file: $zipFilePath");
                return response()->json(['error' => 'Failed to open backup zip file.'], 500);
            }

            // Log the extracted files to ensure there's an .sql file
            $extractedFiles = File::files($tempExtractDir);
            Log::info("Extracted files: " . implode(', ', $extractedFiles));

            // Locate the .sql file inside the extracted directory
            $sqlFile = collect(File::files($tempExtractDir))->firstWhere(fn($file) => $file->getExtension() === 'sql');
            if (!$sqlFile) {
                return response()->json(['error' => 'No SQL file found in the backup.'], 500);
            }

            // Database connection settings
            $dbHost = env('DB_HOST', '127.0.0.1');
            $dbName = env('DB_DATABASE', 'penro_archiving_system');
            $dbUser = env('DB_USERNAME', 'root');
            $dbPassword = env('DB_PASSWORD', '');

            // Restore database from SQL file
            $command = "$config->MySqlDir -h$dbHost -u$dbUser " . ($dbPassword ? "-p$dbPassword " : "") . "$dbName < \"" . $sqlFile->getRealPath() . "\"";
            exec($command, $output, $returnVar);
            Log::info('Restore command executed: ' . $command);
            Log::info('Restore command output: ' . implode("\n", $output));

            if ($returnVar !== 0) {
                return response()->json(['error' => 'Database restore failed.'], 500);
            }

            // Overwrite the PENRO folder with files from the backup
            if (File::exists($storageBackupDir)) {
                File::deleteDirectory($storageBackupDir);
            }

            // Copy files back to public storage
            File::copyDirectory($tempExtractDir . '/PENRO', $storageBackupDir);

            // Clean up temporary extracted files
            File::deleteDirectory($tempExtractDir);
            return response()->json(['success' => 'Database and PENRO folder restored successfully from ' . basename($zipFileName)]);
        } catch (\Exception $e) {
            // Rest of the process...
        } catch (\Exception $e) {
            Log::error('Database and PENRO folder restore failed: ' . $e->getMessage());
            return response()->json(['error' => 'Database and PENRO folder restore failed: ' . $e->getMessage()], 500);
        }
    }



    public function listBackups()
    {
        $config = Config::find(1);
        $drive = $config->Drive;
        $backupDir = $drive . $config->BackDirFiles; // Directory where backups are stored

        // Check if the directory exists
        if (!is_dir($backupDir)) {
            Log::error("Backup directory does not exist: $backupDir");
            return response()->json(['error' => 'Backup directory does not exist.'], 404);
        }

        // Scan the directory for files
        $files = scandir($backupDir); // List all files in the directory

        // Log the files to confirm they're being retrieved
        Log::info("Files in backup directory: " . implode(', ', $files));
        Log::info("Files in backup directory: " . print_r($files, true));
        // Filter out only zip files
        $backupFiles = array_filter($files, function ($file) use ($backupDir) {
            return is_file($backupDir . DIRECTORY_SEPARATOR . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'zip';
        });

        // If no zip files found, return an error message
        if (empty($backupFiles)) {
            Log::error("No zip backup files found in directory: $backupDir");
            return response()->json(['error' => 'No backup files found.'], 200);
        }

        // Return the list of zip files in the backup directory
        return response()->json(['files' => array_values($backupFiles)]);
    }




}
