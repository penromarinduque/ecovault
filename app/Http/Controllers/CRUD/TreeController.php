<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TreeSpecies;
use Illuminate\Support\Facades\DB;

class TreeController extends Controller
{
    public function AddTreeSpecies(Request $request)
    {
        // Validate the request
        $request->validate([
            'common_name' => 'required|string|max:255|unique:tree_species,common_name', // Add unique rule
        ]);


        // Insert the new tree species into the database
        TreeSpecies::create([
            'common_name' => $request->input('common_name'),
        ]);

        // Return a success response
        return response()->json(['success' => true, 'message' => 'Tree species added successfully!']);
    }

    public function deleteTreeSpecies($id)
    {
        // Find the tree species by ID
        $treeSpecies = TreeSpecies::find($id);

        // Check if the species exists
        if (!$treeSpecies) {
            return response()->json(['success' => false, 'message' => 'Tree species not found!'], 404);
        }

        // Delete the species
        $treeSpecies->delete();

        // Return a success response
        return response()->json(['success' => true, 'message' => 'Tree species deleted successfully!']);
    }

    public function getAllTreeSpecies()
    {
        $species = TreeSpecies::all()->unique('common_name');

        return response()->json($species);
    }

    public function getTreeSpeciesById($id)
    {
        $species = TreeSpecies::find($id);

        if ($species) {
            return response()->json($species);
        } else {
            return response()->json(['error' => 'Species not found'], 404);
        }
    }
    public function updateTreeSpecies(Request $request, $id)
    {
        // Find the tree species by ID
        $species = TreeSpecies::find($id);

        if (!$species) {
            return response()->json(['error' => 'Species not found'], 404);
        }

        // Validate incoming data if needed
        $data = $request->validate([
            'common_name' => 'required|string|max:255',
        ]);

        // Update the species with the validated data
        $species->update($data);

        // Return the updated species
        return response()->json($species);
    }


}
