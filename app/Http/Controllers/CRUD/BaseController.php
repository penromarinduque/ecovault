<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TreeTransportPermitDetails;
use App\Models\TreeCuttingPermit;
use App\Models\TransportPermit;
use App\Models\TreeCuttingPermitDetail;
abstract class BaseController extends Controller
{
    public function ArchivedById($id)
    {
        try {
            $file = File::findOrFail($id);

            $file->archive();

            return response()->json(data: [
                'success' => true,
                'message' => 'Archived successfully',
                'files' => $file,
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Archiving the file failed',
                'error' => $e->getMessage(),
            ]);

        }
    }
    //Error in Administrative Document
    public function GetFiles(Request $request)
    {
        try {
            $type = $request->query('type');
            $municipality = $request->query('municipality');
            $report = $request->query('report');
            $isArchived = filter_var($request->query('isArchived', false), FILTER_VALIDATE_BOOLEAN);
            $currentUserId = auth()->id(); // Get the currently logged-in user's ID
            $category = $request->query('category');

            // If $report is provided, fetch files without relationships
            if (!empty($report)) {
                $files = File::whereDoesntHave('treeCuttingPermits')
                    ->whereDoesntHave('chainsawRegistrations')
                    ->whereDoesntHave('treePlantationRegistrations')
                    ->whereDoesntHave('transportPermits')
                    ->whereDoesntHave('landTitles')
                    ->where('report_type', $report)
                    ->where('is_archived', $isArchived)
                    ->with(['user:id,name', 'fileShares']) // Load related fileShares
                    ->get();

                $files = $files->map(function ($file) use ($currentUserId) {
                    $sharedUserIds = $file->fileShares->pluck('shared_with_user_id')->toArray();
                    return [
                        'id' => $file->id,
                        'file_name' => $file->file_name,
                        'updated_at' => $file->updated_at->format('Y-m-d H:i:s'),
                        'office_source' => $file->office_source,
                        'user_name' => $file->user->name,
                        'classification' => $file->classification,
                        'is_shared' => !empty($sharedUserIds), // Check if there are any fileShares
                        'shared_users' => $sharedUserIds, // List of user IDs who have access
                    ];
                });

                return response()->json([
                    'success' => true,
                    'message' => 'Files retrieved successfully.',
                    'data' => $files
                ]);
            }

            // If $type and $municipality are provided, fetch files with join
            elseif (!empty($type) && !empty($municipality)) {
                $files = File::where('is_archived', $isArchived)
                    ->where('permit_type', $type)
                    ->where('municipality', $municipality)
                    ->where('land_category', $category)
                    ->with(['user:id,name', 'fileShares']) // Load uploader and shared users
                    ->get()
                    ->map(function ($file) use ($currentUserId) {
                        $sharedUserIds = $file->fileShares->pluck('shared_with_user_id')->toArray();
                        return [
                            'id' => $file->id,
                            'file_name' => $file->file_name,
                            'updated_at' => $file->updated_at->format('Y-m-d H:i:s'),
                            'office_source' => $file->office_source,
                            'user_name' => $file->user->name, // Uploader's name
                            'classification' => $file->classification,
                            'is_shared' => !empty($sharedUserIds), // Check if there are any fileShares
                            'shared_users' => $sharedUserIds, // List of user IDs who have access
                        ];
                    });

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


            //$permit = null;
            // $permit_details = null;

            // If 'includePermit' is true, fetch permit details based on the permit type
            if ($includePermit) {
                $permit_type = $file->permit_type;

                switch ($permit_type) {
                    case 'tree-cutting-permits':
                        $permit = TreeCuttingPermit::with('details')
                            ->where('file_id', $id)
                            ->first();

                        $permit ? $permit->details : [];
                        break;

                    case 'chainsaw-registration':
                        $permit = DB::table('chainsaw_registrations')
                            ->where('file_id', $id)
                            ->first();
                        break;

                    case 'tree-plantation':
                        $permit = DB::table('tree_plantation_registration')
                            ->where('file_id', $id)
                            ->first();
                        break;

                    case 'tree-transport-permits':
                        $permit = TransportPermit::with('details')
                            ->where('file_id', $id)
                            ->first();

                        $permit ? $permit->details : [];
                        break;

                    case 'land-titles':
                        $permit = DB::table('land_titles')
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
                if (!$includePermit && !$permit) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Permit details not found for the provided file ID.',
                    ], 404);
                }
            }

            // Return response based on whether permit details were included
            $response = [
                'success' => true,
                'message' => 'File retrieved successfully.',
                'file' => $file,
            ];
            if (isset($permit)) {
                $response['permit'] = $permit;
            }
            return response()->json($response, 200);
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

            $type = $request->query('type');
            // Retrieve the file by ID
            //$file = DB::table('files')->where('id', $id)->first();
            $file = File::find($id);
            if (!$file) {
                return response()->json([
                    'success' => false,
                    'message' => 'File not found.'
                ], 404);
            }


            $file->update([
                'office_source' => $request->input('office_source'),
                'classification' => $request->input('classification'),
                'updated_at' => now(), // Set the update timestamp
            ]);


            // // Update the file's data
            // DB::table('files')->where('id', $id)->update([
            //     'office_source' => $request->input('office_source'),
            //     'classification' => $request->input('classification'),
            //     'updated_at' => now(), // Set the update timestamp
            // ]);

            // Check if permit data is provided
            if ($type) {
                switch ($type) {
                    case 'tree-cutting-permits':
                        // Step 1: Update the TreeCuttingPermit (main data)
                        $treeCuttingPermit = TreeCuttingPermit::where('file_id', $id)->first();

                        if (!$treeCuttingPermit) {
                            return response()->json(['success' => false, 'message' => 'Tree Cutting Permit not found.'], 404);
                        }

                        // Update the TreeCuttingPermit (main data)
                        $treeCuttingPermit->update([
                            'name_of_client' => $request->input('name_of_client'), // Update the client name
                        ]);
                        // Get the arrays from the request
                        $detailIds = $request->input('id'); // e.g. [1, 2]
                        $species = $request->input('species'); // e.g. ['Oak', 'Pine']
                        $numberOfTrees = $request->input('number_of_trees'); // e.g. [10, 20]
                        $locations = $request->input('location'); // e.g. ['Area 1', 'Area 2']
                        $dateApplied = $request->input('date_applied'); // e.g. ['2024-01-01', '2024-02-01']

                        // Loop through the detail ids to update or create the details
                        foreach ($detailIds as $index => $detailId) {
                            $detailData = [
                                'tree_cutting_permit_id' => $treeCuttingPermit->id,
                                'species' => $species[$index] ?? null,
                                'number_of_trees' => $numberOfTrees[$index] ?? null,
                                'location' => $locations[$index] ?? null,
                                'date_applied' => $dateApplied[$index] ?? null,
                            ];

                            // If the detail_id exists, update the corresponding record
                            if ($detailId) {
                                $detail = TreeCuttingPermitDetail::find($detailId);
                                if ($detail) {
                                    // Update the existing detail record
                                    $detail->update($detailData);
                                }
                            } else {
                                // If no detail_id, create a new detail record
                                $treeCuttingPermit->details()->create($detailData);
                            }
                        }
                        break;

                    case 'tree-plantation':
                        DB::table('tree_plantation_registration')->where('file_id', $id)->update([
                            'name_of_client' => $permit_data['name_of_client'] ?? null,
                            'number_of_trees' => $permit_data['number_of_trees'] ?? null,
                            'location' => $permit_data['location'] ?? null,
                            'date_applied' => $permit_data['date_applied'] ?? null,
                        ]);
                        break;

                    case 'tree-transport-permits':
                        // Step 1: Update the TreeCuttingPermit (main data)
                        $treeTransportPermit = TransportPermit::where('file_id', $id)->first();

                        if (!$treeTransportPermit) {
                            return response()->json(['success' => false, 'message' => 'Tree Cutting Permit not found.'], 404);
                        }

                        // Update the TreeCuttingPermit (main data)
                        $treeTransportPermit->update([
                            'name_of_client' => $request->input('name_of_client'), // Update the client name
                        ]);
                        // Get the arrays from the request
                        $detailIds = $request->input('id'); // e.g. [1, 2]
                        $species = $request->input('species'); // e.g. ['Oak', 'Pine']
                        $numberOfTrees = $request->input('number_of_trees'); // e.g. [10, 20]
                        $destination = $request->input('destination'); // e.g. ['Area 1', 'Area 2']
                        $dateApplied = $request->input('date_applied'); // e.g. ['2024-01-01', '2024-02-01']
                        $dateOfransport = $request->input('date_of_transport');
                        // Loop through the detail ids to update or create the details

                        foreach ($detailIds as $index => $detailId) {
                            $detailData = [
                                'transport_permit_id' => $treeTransportPermit->id,
                                'species' => $species[$index] ?? null,
                                'number_of_trees' => $numberOfTrees[$index] ?? null,
                                'destination' => $destination[$index] ?? null,
                                'date_applied' => $dateApplied[$index] ?? null,
                                'date_of_transport' => $dateOfransport[$index] ?? null,
                            ];

                            // If the detail_id exists, update the corresponding record
                            if ($detailId) {
                                $detail = TreeTransportPermitDetails::find($detailId);
                                if ($detail) {
                                    // Update the existing detail record
                                    $detail->update($detailData);
                                }
                            } else {
                                // If no detail_id, create a new detail record
                                $treeTransportPermit->details()->create($detailData);
                            }
                        }
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


    public function DeletePermitSpecification(Request $request, $id)
    {
        $type = $request->query('type');
        $specification = null;
        if ($type === 'tree-cutting-permits') {
            $specification = TreeCuttingPermitDetail::find($id);
        } elseif ($type === 'tree-transport-permits') {
            $specification = TreeTransportPermitDetails::find($id);
        }


        if ($specification) {
            $specification->delete();
            return response()->json(['message' => 'Detail successfully deleted!']);
        }

        return response()->json(['message' => 'Specification not found.'], 200);
    }
}
