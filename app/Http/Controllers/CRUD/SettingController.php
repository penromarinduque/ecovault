<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
class SettingController extends Controller
{
    //
    public function GetConfig()
    {
        try {
            // Get the first configuration record (assuming there's only one)
            $config = Config::first();

            // If the config doesn't exist, return a 404 response
            if (!$config) {
                return response()->json(['message' => 'Config not found'], 404);
            }

            // Return the config record as a JSON response
            return response()->json($config, 200);

        } catch (\Exception $e) {
            // Catch any exception and return an error message
            return response()->json([
                'message' => 'An error occurred while fetching the config.',
                'error' => $e->getMessage(),
            ], 500); // Internal Server Error
        }
    }

    public function UpdateConfig(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'Drive' => 'required|string|max:255',
                'BackDirSQL' => 'required|string|max:255',
                'BackDirFiles' => 'required|string|max:255',
                'StorePath' => 'required|string|max:255',
                'MySqlDir' => 'required|string|max:255',       // Add MySQL Directory validation
                'MySqlDumpDir' => 'required|string|max:255',   // Add MySQL Dump Directory validation
            ]);

            // Find the config record by ID
            $config = Config::find(1);

            // If the config doesn't exist, return a 404 response
            if (!$config) {
                return response()->json(['message' => 'Config not found'], 404);
            }

            // Update the config record with validated data
            $config->update($validatedData);

            // Return the updated config record as a JSON response
            return response()->json($config, 200);

        } catch (\Exception $e) {
            // Catch any exception and return an error message
            return response()->json([
                'message' => 'An error occurred while updating the config.',
                'error' => $e->getMessage(),
            ], 500); // Internal Server Error
        }
    }

}
