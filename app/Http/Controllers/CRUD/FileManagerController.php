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

        $detailsData = [];
        switch ($request->permit_type) {
            case 'tree-cutting-permits':
                $treeCuttingPermit = TreeCuttingPermit::create([
                    'file_id' => $request->file_id,
                    'name_of_client' => $request->name_of_client,
                ]);

                // Retrieve arrays of details
                $speciesArray = $request->input('species');
                $numberOfTreesArray = $request->input('number_of_trees');
                $locationArray = $request->input('location');
                $dateAppliedArray = $request->input('date_applied');

                // Prepare an array to hold multiple detail entries


                // Loop over each entry and create a new TreeCuttingPermitDetail entry
                foreach ($speciesArray as $index => $species) {
                    $detailsData[] = [
                        'tree_cutting_permit_id' => $treeCuttingPermit->id,
                        'species' => $species,
                        'number_of_trees' => $numberOfTreesArray[$index] ?? null,
                        'location' => $locationArray[$index] ?? null,
                        'date_applied' => $dateAppliedArray[$index] ?? null,
                    ];
                }

                // Use createMany to insert all details at once
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
                        'date_of_transport' => $dateOfTransportArray[$index] ?? null, // Use indexed value
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
                    'property_category' => $request->property_category,
                ]);
                break;

            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid permit type.',
                    'received_permit_type' => $request->permit_type
                ]);
        }

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'scucess permit type.',
            'permit' => $request->permit_type
        ]);
    }


}
