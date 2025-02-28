<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ButterflySpecies;
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

    // Delete a species by ID
    public function DeleteSpeciesById($id)
    {
        $species = ButterflySpecies::find($id);

        if (!$species) {
            return false; // Return false if not found
        }

        return $species->delete();
    }

    // Add a new species
    public function AddSpecies($request)
    {
        return ButterflySpecies::create([
            'scientific_name' => $request['scientific_name'],
            'common_name' => $request['common_name'] ?? null,
            'family' => $request['family'] ?? null,
            'genus' => $request['genus'] ?? null
        ]);
    }

}
