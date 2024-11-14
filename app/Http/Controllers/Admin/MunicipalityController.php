<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Municipality;
use Illuminate\Http\Request;

class MunicipalityController extends Controller
{
    //
    public function GetMunicipalities()
    {

        $locations = Municipality::orderBy('location', 'asc')->get();

        try {
            return response()->json([
                'locations' => $locations
            ]);
        } catch (\Exception $e) {
            // Return an error response with the exception message
            return response()->json([
                'error' => 'An error occurred while retrieving municipalities.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function GetVillage()
    {

    }

}
