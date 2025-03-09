<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\FileHistory;
use Illuminate\Http\Request;

use App\Models\TreeCuttingPermit;
use App\Models\TreePlantation;
use App\Models\ChainsawRegistration;
use App\Models\TransportPermit;
use App\Models\LandTitle;
use App\Models\TreeCuttingPermitDetail;
use App\Models\TreeTransportPermitDetails;
use App\Models\FileType;
use App\Models\LocalTransportPermit;
class FileManagerController extends BaseController
{

    public function StorePermit(Request $request)
    {
        try {
            $type = $request->query('type');
            $municipality = $request->query('municipality');
            $report = $request->query('report');
            $category = $request->query('category');
            $isArchived = filter_var($request->query('isArchived', false), FILTER_VALIDATE_BOOLEAN);
            $currentUserId = auth()->id(); // Get the currently logged-in user's ID

            $detailsData = [];
            switch ($type) {
                case 'tree-cutting-permits':
                    $treeCuttingPermit = TreeCuttingPermit::create([
                        'file_id' => $request->file_id,
                        'name_of_client' => $request->name_of_client,
                        'permit_type' => $request->input('tcp-type'),
                    ]);

                    $speciesArray = $request->input('species');
                    $numberOfTreesArray = $request->input('number_of_trees');
                    $locationArray = $request->input('location');
                    $dateAppliedArray = $request->input('date_applied');

                    foreach ($speciesArray as $index => $species) {
                        $detailsData[] = [
                            'tree_cutting_permit_id' => $treeCuttingPermit->id,
                            'species' => $species,
                            'number_of_trees' => $numberOfTreesArray[$index] ?? null,
                            'location' => $locationArray[$index] ?? null,
                            'date_applied' => $dateAppliedArray[$index] ?? null,
                        ];
                    }

                    $treeCuttingPermit->details()->createMany($detailsData);
                    break;

                case 'transport-permit':
                    $treeTransportPermit = TransportPermit::create([
                        'file_id' => $request->file_id,
                        'name_of_client' => $request->name_of_client,
                    ]);

                    $speciesArray = $request->input('species');
                    $numberOfTreesArray = $request->input('number_of_trees');
                    $destinationArray = $request->input('destination');
                    $dateOfTransportArray = $request->input('date_of_transport');
                    $dateAppliedArray = $request->input('date_applied');

                    foreach ($speciesArray as $index => $species) {
                        $detailsData[] = [
                            'transport_permit_id' => $treeTransportPermit->id,
                            'species' => $species,
                            'number_of_trees' => $numberOfTreesArray[$index] ?? null,
                            'destination' => $destinationArray[$index] ?? null,
                            'date_applied' => $dateAppliedArray[$index] ?? null,
                            'date_of_transport' => $dateOfTransportArray[$index] ?? null,
                        ];
                    }
                    $treeTransportPermit->details()->createMany($detailsData);
                    break;

                case 'chainsaw-registration':
                    ChainsawRegistration::create([
                        'file_id' => $request->file_id,
                        'name_of_client' => $request->name_of_client,
                        'location' => $request->location,
                        'serial_number' => $request->serial_number,
                        'date_applied' => $request->date_applied,
                        'category' => $category,
                    ]);
                    break;

                case 'tree-plantation-registration':
                    TreePlantation::create([
                        'file_id' => $request->file_id,
                        'name_of_client' => $request->name_of_client,
                        'number_of_trees' => $request->number_of_trees,
                        'location' => $request->location,
                        'date_applied' => $request->date_applied,
                    ]);
                    break;

                case 'land-title':
                    LandTitle::create([
                        'file_id' => $request->file_id,
                        'name_of_client' => $request->name_of_client,
                        'location' => $request->location,
                        'lot_number' => $request->lot_number,
                        'property_category' => $category,
                    ]);
                    break;

                case 'local-transport-permit':
                    LocalTransportPermit::create([
                        'file_id' => $request->file_id,
                        'name_of_client' => $request->name_of_client,
                        'business_farm_name' => $request->business_farm_name,
                        'butterfly_permit_number' => $request->butterfly_permit_number,
                        'destination' => $request->destination,
                        'date_applied' => $request->date_applied,
                        'date_released' => $request->date_released,
                        'classification' => $request->classification,
                    ]);
                    break;



                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid permit type.',
                        'received_permit_type' => $request->permit_type
                    ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Permit type successfully processed.',
                'permit' => $type,
                'municipality' => $municipality
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function GetFileTypeByClassification(Request $request)
    {
        $classification = (int) $request->query('classification');

        if (!$classification) {
            return response()->json([
                'success' => false,
                'message' => 'Classification parameter is required.'
            ], 400);
        }


        $fileTypes = FileType::where('classification_id', $classification)->get();

        if ($fileTypes->count() < 1) {
            return response()->json([
                'success' => true,
                'message' => "No File Types Found",
            ], 200);
        }
        // Return the file types as a JSON response
        return response()->json([
            'success' => true,
            'file_types' => $fileTypes,
        ], 200);
    }

    public function GetFileHistoryById(Request $request)
    {
        $file_id = $request->query('file_id');

        if (!$file_id) {
            return response()->json([
                'success' => false,
                'message' => 'file_id parameter is required.'
            ], 400);
        }

        $history = FileHistory::where('file_id', $file_id)->get();


        // Return the file types as a JSON response
        return response()->json([
            'success' => true,
            'history' => $history,
        ], 200);
    }

}
