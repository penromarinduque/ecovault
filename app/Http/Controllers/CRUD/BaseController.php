<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
abstract class BaseController extends Controller
{
    public function ArchivedById($id)
    {
        try {
            $file = File::findOrFail($id);

            $file->archive();

            return response()->json([
                'success' => true,
                'message' => 'File archived successfully',
                'files' => $file,
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'archive file fail',
                'error' => $e->getMessage(),
            ]);

        }
    }
    //Error in Administrative Document
    public function GetFiles(Request $request, $type = null, $municipality = null, $report = null)
    {
        try {
            $type = $request->query('type');
            $municipality = $request->query('municipality');
            $report = $request->query('report');
            // Default value for isArchived is false
            $isArchived = filter_var($request->query('isArchived', false), FILTER_VALIDATE_BOOLEAN);

            // If $report is provided, fetch files without relationships
            if (!empty($report)) {
                $files = File::whereDoesntHave('treeCuttingPermits')
                    ->whereDoesntHave('chainsawRegistrations')
                    ->whereDoesntHave('treePlantationRegistrations')
                    ->whereDoesntHave('transportPermits')
                    ->whereDoesntHave('landTitles')
                    ->where('report_type', $report)
                    ->where('is_archived', $isArchived)
                    ->with('user:id,name')
                    ->get();

                $files = $files->map(function ($file) {
                    return [
                        'id' => $file->id,
                        'file_name' => $file->file_name,
                        'updated_at' => $file->updated_at->format('Y-m-d H:i:s'),
                        'office_source' => $file->office_source,
                        'user_name' => $file->user_name,
                        'category' => $file->category,
                        'classification' => $file->classification,
                        'status' => $file->status,
                    ];
                });
                return response()->json([
                    'success' => true,
                    'message' => 'Files retrieved successfully.',
                    'files' => $files
                ]);
            }
            // If $type and $municipality are provided, fetch files with join
            elseif (!empty($type) && !empty($municipality)) {
                $files = DB::table('files')
                    ->where('is_archived', $isArchived)
                    ->join('users', 'files.user_id', '=', 'users.id') // Join with users table
                    ->where('files.permit_type', $type)
                    ->where('files.municipality', $municipality)
                    ->select('files.*', 'users.name as user_name') // Select all fields from files and the name from users
                    ->get();
                return response()->json([
                    'success' => true,
                    'data' => $files,
                    'message' => 'Files retrieved successfully',
                ], 200);
            }
            return response()->json([
                'success' => false,
                'message' => 'No valid parameters provided.',
            ], 400);



        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving files.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function GetFileById(Request $request, $id)
    {
        try {
            // Retrieve the 'includePermit' query parameter (default to true if not provided)
            $includePermit = filter_var($request->query('includePermit', false), FILTER_VALIDATE_BOOLEAN);

            // Retrieve the file by ID
            $file = DB::table('files')
                ->where('id', $id)
                ->first();

            if (!$file) {
                return response()->json([
                    'success' => false,
                    'message' => 'File not found.'
                ], 404);
            }

            // Initialize permit details as null
            $permit_details = null;

            // If 'includePermit' is true, fetch permit details based on the permit type
            if ($includePermit) {
                $permit_type = $file->permit_type;

                switch ($permit_type) {
                    case 'tree-cutting-permits':
                        $permit_details = DB::table('tree_cutting_permits')
                            ->where('file_id', $id)
                            ->first();
                        break;

                    case 'chainsaw-registration':
                        $permit_details = DB::table('chainsaw_registrations')
                            ->where('file_id', $id)
                            ->first();
                        break;

                    case 'tree-plantation':
                        $permit_details = DB::table('tree_plantation_registration')
                            ->where('file_id', $id)
                            ->first();
                        break;

                    case 'tree-transport-permits':
                        $permit_details = DB::table('transport_permits')
                            ->where('file_id', $id)
                            ->first();
                        break;

                    case 'land-titles':
                        $permit_details = DB::table('land_titles')
                            ->where('file_id', $id)
                            ->first();
                        break;

                    default:
                        return response()->json([
                            'success' => false,
                            'message' => 'Invalid permit type.',
                            'received_permit_type' => $permit_type
                        ], 400);
                }

                // Check if permit details were found
                if (!$permit_details) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Permit details not found for the provided file ID.',
                    ], 404);
                }
            }

            // Return response based on whether permit details were included
            return response()->json([
                'success' => true,
                'message' => 'File retrieved successfully.',
                'file' => $file,
                'permit' => $includePermit ? $permit_details : null
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving the file.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function UpdateFileById(Request $request, $id)
    {
        try {
            // Retrieve the file by ID
            $file = DB::table('files')->where('id', $id)->first();

            if (!$file) {
                return response()->json([
                    'success' => false,
                    'message' => 'File not found.'
                ], 404);
            }

            // Update the file's data
            DB::table('files')->where('id', $id)->update([
                'office_source' => $request->input('office_source'),
                'category' => $request->input('category'),
                'classification' => $request->input('classification'),
                'status' => $request->input('status'),
                'updated_at' => now(), // Set the update timestamp
            ]);

            // Check if permit data is provided
            if ($request->has('permit')) {
                $permit_type = $file->permit_type;
                $permit_data = $request->input('permit');

                // Update the related permit details based on permit type
                switch ($permit_type) {
                    case 'tree-cutting-permits':
                        DB::table('tree_cutting_permits')->where('file_id', $id)->update([
                            'name_of_client' => $permit_data['name_of_client'] ?? null,
                            'number_of_trees' => $permit_data['number_of_trees'] ?? null,
                            'location' => $permit_data['location'] ?? null,
                            'date_applied' => $permit_data['date_applied'] ?? null,
                        ]);
                        break;

                    case 'chainsaw-registration':
                        DB::table('chainsaw_registrations')->where('file_id', $id)->update([
                            'name_of_client' => $permit_data['name_of_client'] ?? null,
                            'location' => $permit_data['location'] ?? null,
                            'serial_number' => $permit_data['serial_number'] ?? null,
                            'date_applied' => $permit_data['date_applied'] ?? null,
                        ]);
                        break;

                    case 'tree-plantation':
                        DB::table('tree_plantation_registration')->where('file_id', $id)->update([
                            'name_of_client' => $permit_data['name_of_client'] ?? null,
                            'number_of_trees' => $permit_data['number_of_trees'] ?? null,
                            'location' => $permit_data['location'] ?? null,
                            'date_applied' => $permit_data['date_applied'] ?? null,
                        ]);
                        break;

                    case 'transport-permits':
                        DB::table('transport_permits')->where('file_id', $id)->update([
                            'name_of_client' => $permit_data['name_of_client'] ?? null,
                            'number_of_trees' => $permit_data['number_of_trees'] ?? null,
                            'destination' => $permit_data['destination'] ?? null,
                            'date_applied' => $permit_data['date_applied'] ?? null,
                            'date_of_transport' => $permit_data['date_of_transport'] ?? null,
                        ]);
                        break;

                    case 'land-titles':
                        DB::table('land_titles')->where('file_id', $id)->update([
                            'name_of_client' => $permit_data['name_of_client'] ?? null,
                            'location' => $permit_data['location'] ?? null,
                            'lot_number' => $permit_data['lot_number'] ?? null,
                            'property_category' => $permit_data['property_category'] ?? null,
                        ]);
                        break;

                    default:
                        return response()->json([
                            'success' => false,
                            'message' => 'Invalid permit type.'
                        ], 400);
                }
            }

            // Return success response after all updates
            return response()->json([
                'success' => true,
                'message' => 'File and permit details updated successfully!',
            ], 200);

        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the file.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


}
