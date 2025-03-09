<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ButterflySpecies;
use App\Models\ButterflyDetails;
class ButterflyController extends Controller
{
    // Get a single species by ID
    public function GetSpeciesById($id)
    {
        return ButterflySpecies::find($id);
    }

    // Get all species
    public function GetAllSpecies()
    {
        return ButterflySpecies::all();
    }

    // Update a species by ID
    public function UpdateSpeciesById($id, $data)
    {
        $species = ButterflySpecies::find($id);

        if (!$species) {
            return null; // Return null if species not found
        }

        $species->update($data);
        return $species;
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Search by scientific name or common name
        $butterflies = ButterflySpecies::where('scientific_name', 'LIKE', "%{$query}%")
            ->orWhere('common_name', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($butterflies);
    }

    // Delete a species by ID
    public function DeleteSpeciesById($id)
    {
        $species = ButterflySpecies::find($id);

        if (!$species) {
            return false; // Return false if not found
        }

        return $species->delete();
    }




    public function AddSpecies(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'scientific_name' => 'required|string|max:255',
            'common_name' => 'nullable|string|max:255',
            'family' => 'nullable|string|max:255',
            'genus' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
        ]);

        // Create and return the new butterfly record
        $butterfly = ButterflySpecies::create($validated);

        return response()->json([
            'message' => 'Butterfly added successfully!',
            'butterfly' => $butterfly
        ], 201);
    }

    public function AddButterflyDetails(Request $request, $fileId)
    {


        foreach ($request->butterflies as $butterfly) {
            ButterflyDetails::create([
                'file_id' => $fileId,
                'butterfly_id' => $butterfly['id'],
                'quantity' => $butterfly['quantity'],
            ]);
        }

        return response()->json(['message' => 'Butterfly details added successfully']);
    }


}



