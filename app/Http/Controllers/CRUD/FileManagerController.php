<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TreeCuttingPermit;
use App\Models\TreePlantation;
use App\Models\ChainsawRegistration;
use App\Models\TransportPermit;
use App\Models\LandTitle;

class FileManagerController extends BaseController
{

    public function StorePermit(Request $request)
    {
        switch ($request->permit_type) {
            case 'tree-cutting-permits':
                $treeCuttingPermit = TreeCuttingPermit::create([
                    'file_id' => $request->file_id,
                    'name_of_client' => $request->name_of_client,
                    // 'number_of_trees' => $request->number_of_trees,
                    // 'location' => $request->location,
                    // 'date_applied' => $request->date_applied,
                    // 'species' => $request->species,
                ]);

                $treeCuttingPermit->id;
                //json 

                // Step 2: Add multiple details using createMany
                $detailsData = $request->details;

                // Validate and insert details if provided
                if (!empty($detailsData)) {
                    $treeCuttingPermit->details()->createMany($detailsData);
                }

                return response()->json([
                    'message' => 'Tree Cutting Permit created successfully!',
                    'tree_cutting_permit' => $treeCuttingPermit,
                    'details' => $treeCuttingPermit->details,
                ]);

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

            case 'tree-transport-permits':
                TransportPermit::create([
                    'file_id' => $request->file_id,
                    'name_of_client' => $request->name_of_client,
                    'number_of_trees' => $request->number_of_trees,
                    'destination' => $request->destination,
                    'date_applied' => $request->date_applied,
                    'date_of_transport' => $request->date_of_transport,
                    'species' => $request->species,
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
