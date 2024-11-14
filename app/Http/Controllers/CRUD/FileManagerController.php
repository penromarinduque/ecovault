<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TreeCuttingPermit;
use App\Models\TreePlantation;
use App\Models\ChainsawRegistration;
use App\Models\TransportPermit;
use App\Models\LandTitle;
use App\Models\TreeCuttingPermitDetail;
use App\Models\TreeTransportPermitDetails;

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

                case 'tree-transport-permits':
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
                    ]);
                    break;

                case 'tree-plantation':
                    TreePlantation::create([
                        'file_id' => $request->file_id,
                        'name_of_client' => $request->name_of_client,
                        'number_of_trees' => $request->number_of_trees,
                        'location' => $request->location,
                        'date_applied' => $request->date_applied,
                    ]);
                    break;

                case 'land-titles':
                    LandTitle::create([
                        'file_id' => $request->file_id,
                        'name_of_client' => $request->name_of_client,
                        'location' => $request->location,
                        'lot_number' => $request->lot_number,
                        'property_category' => $category,
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


}
