<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TreeTransportPermitDetails;
use App\Models\TreeCuttingPermit;
use App\Models\TransportPermit;
use App\Models\LocalTransportPermit;
use App\Models\TreeCuttingPermitDetail;
use App\Models\FileHistory;
use App\Models\ButterflyDetails;
use Carbon\Carbon;
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
                        'is_shared' => !empty($sharedUserIds) , // Check if there are any fileShares
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
                    ->where('category', $category)
                    ->with(['user:id,name', 'fileShares']) // Load uploader and shared users
                    ->get()
                    ->map(function ($file) use ($currentUserId) {
                        $sharedUserIds = $file->fileShares->pluck('shared_with_user_id')->toArray();
                        // Extract relevant permit details
                        return [
                            'id' => $file->id,
                            'file_name' => $file->file_name,
                            'updated_at' => $file->updated_at->format('Y-m-d H:i:s'),
                            'office_source' => $file->office_source,
                            'user_name' => $file->user->name, // Uploader's name
                            'classification' => $file->classification,
                            'is_shared' => !empty($sharedUserIds), // Check if there are any fileShares
                            'shared_users' => $sharedUserIds, // Only include specific permit details
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

    function GetFileAndPermits(Request $request)
    {
        try {
            $classification = $request->input('classification');
            $clientSearch = $request->input('client-search'); // e.g., string or null
            $permitType = $request->input('permit_type'); // e.g., string or null
            $archived = filter_var($request->input('archived'), FILTER_VALIDATE_BOOLEAN); // Converts 'true'/'false' string to boolean
            $municipality = $request->input('municipality');
            // Start building the query on the 'files' table
            $query = File::query();

            // Determine which table to join based on permit_type
            switch ($permitType) {
                case 'tree-cutting-permits':
                    $query = TreeCuttingPermit::with('details') // Load related details
                        ->join('files', 'files.id', '=', 'tree_cutting_permits.file_id')
                        ->where('tree_cutting_permits.name_of_client', 'like', "%{$clientSearch}%")
                        ->select('files.*', 'tree_cutting_permits.*'); // Select required columns
                    break;

                case 'transport-permit':
                    $query = TransportPermit::with('details')
                        ->join('files', 'files.id', '=', 'transport_permits.file_id')
                        ->where('transport_permits.name_of_client', 'like', "%{$clientSearch}%")
                        ->select('files.*', 'transport_permits.*');
                    break;

                case 'chainsaw-registration':
                    $query->join('chainsaw_registrations', 'files.id', '=', 'chainsaw_registrations.file_id')
                        ->where('chainsaw_registrations.name_of_client', 'like', "%{$clientSearch}%");
                    break;

                case 'tree-plantation-registration':
                    $query->join('tree_plantation_registration', 'files.id', '=', 'tree_plantation_registration.file_id')
                        ->where('tree_plantation_registration.name_of_client', 'like', "%{$clientSearch}%");
                    break;

                case 'land-title':
                    $query->join('land_titles', 'files.id', '=', 'land_titles.file_id')
                        ->where('land_titles.name_of_client', 'like', "%{$clientSearch}%");
                    break;

                case 'local-trasport-permit':
                    $query->join('local-transport-permit', 'files.id', '=', 'local-transport-permit.file_id')
                        ->where('local-transport-permit.name_of_client', 'like', "%{$clientSearch}%");
                    break;

                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid permit type.',
                        'received_permit_type' => $permitType
                    ], 400);
            }


            $query->where('files.classification', $classification);
            $query->where('files.is_archived', $archived); // Filter by archived (0 or 1)
            $query->where('files.municipality', $municipality);

            // Execute the query to get the filtered files
            $files = $query->get();

            $files->transform(function ($file) {
                // Assuming the file has a 'created_at' field or any other date field you want to format
                $file->created_at = Carbon::parse($file->created_at)->format('Y-m-d H:i:s'); // You can adjust the format as needed

                // If you have other date fields to format, you can add them here
                // For example, if there's an 'updated_at' field:
                // $file->updated_at = Carbon::parse($file->updated_at)->format('Y-m-d H:i:s');

                return $file;
            });

            return response()->json([
                'success' => true,
                'message' => 'you retrieve client files',
                'data' => $files,
                'permit-type' => $permitType,

            ]);
        } catch (\Exception $e) {
            // Handle any exception and return an error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching files.',
                'error' => $e->getMessage(), // Optionally include the exception message for debugging
            ], 500); // HTTP 500 Internal Server Error
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

                    case 'tree-plantation-registration':
                        $permit = DB::table('tree_plantation_registration')
                            ->where('file_id', $id)
                            ->first();
                        break;

                    case 'transport-permit':
                        $permit = TransportPermit::with('details')
                            ->where('file_id', $id)
                            ->first();

                        $permit ? $permit->details : [];
                        break;

                    case 'land-title':
                        $permit = DB::table('land_titles')
                            ->where('file_id', $id)
                            ->first();
                        break;

                    case 'local-transport-permit':
                        $permit = DB::table('local_transport_permits')
                            ->where('file_id', $id)
                            ->first();

                        $butterflyDetails = ButterflyDetails::with(['butterfly'])
                            ->where('file_id', $id)
                            ->get()
                            ->map(function ($detail) {
                                return [
                                    'id' => $detail->id,
                                    'butterfly_id' => $detail->butterfly_id,
                                    'common_name' => $detail->butterfly->common_name ?? null,
                                    'scientific_name' => $detail->butterfly->scientific_name ?? null,
                                    'family' => $detail->butterfly->family ?? null,
                                    'genus' => $detail->butterfly->genus ?? null,
                                    'description' => $detail->butterfly->description ?? null,
                                    'quantity' => $detail->quantity,
                                ];
                            })
                            ->toArray();
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

            // Fix: Use $butterflyDetails instead of $details
            if (!empty($butterflyDetails)) {
                $response['details'] = $butterflyDetails;
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

            FileHistory::create([
                'file_id' => $file->id,
                'action' => 'updated',
                'changes' => json_encode($file->getChanges()),
                'user_id' => auth()->id() ?: 0, // Fallback to a default user ID (0 or system user)
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

                    case 'tree-plantation-registration':
                        DB::table('tree_plantation_registration')->where('file_id', $id)->update([
                            'name_of_client' => $request->input('name_of_client') ?? null,
                            'number_of_trees' => $request->input('number_of_trees') ?? null,
                            'location' => $request->input('location') ?? null,
                            'date_applied' => $request->input('date_applied') ?? null,
                        ]);
                        break;

                    case 'transport-permit':
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
                            'name_of_client' => $request->input('name_of_client') ?? null,
                            'location' => $request->input('location') ?? null,
                            'lot_number' => $request->input('lot_number') ?? null,
                            // 'property_category' => $request->input('property_category') ?? null,
                        ]);
                        break;
                    case 'chainsaw-registration':
                        DB::table('chainsaw_registrations')->where('file_id', $id)->update([
                            'name_of_client' => $request->input('name_of_client') ?? null,
                            'location' => $request->input('location') ?? null,
                            'serial_number' => $request->input('serial_number') ?? null,
                            // 'property_category' => $request->input('property_category') ?? null,
                        ]);
                        break;
                    case 'local-transport-permit':
                        DB::table('local_transport_permits')->where('file_id', $id)->update([
                            'name_of_client' => $request->input('name_of_client') ?? null,
                            'business_farm_name' => $request->input('business_farm_name') ?? null,
                            'butterfly_permit_number' => $request->input('butterfly_permit_number') ?? null,
                            'destination' => $request->input('destination') ?? null,
                            'date_applied' => $request->input('date_applied') ?? null,
                            'date_released' => $request->input('date_released') ?? null,
                            'classification' => $request->input('classification') ?? null,
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
        } elseif ($type === 'transport-permit') {
            $specification = TreeTransportPermitDetails::find($id);
        }


        if ($specification) {
            $specification->delete();
            return response()->json(['message' => 'Detail successfully deleted!']);
        }

        return response()->json(['message' => 'Specification not found.'], 200);
    }

}
