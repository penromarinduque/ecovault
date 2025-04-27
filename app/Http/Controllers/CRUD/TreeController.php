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

    public function getAllTreeSpecies()
    {
        $species = TreeSpecies::all()->unique('common_name');

        return response()->json($species);
    }
}
