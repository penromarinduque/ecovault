<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ButterflySpecies;
use App\Models\ButterflyDetails;
use App\Models\File;
use Illuminate\Support\Facades\DB;
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
    public function SyncButterflyDetails(Request $request, $fileId)
    {
        DB::transaction(function () use ($request, $fileId) {
            // Check if file exists
            if (!File::where('id', $fileId)->exists()) {
                throw new \Exception("File ID {$fileId} does not exist.");
            }

            $newButterflyIds = [];

            foreach ($request->butterflies as $butterfly) {
                // Split name into common and scientific names
                $nameParts = explode(" / ", $butterfly['name']);

                if (count($nameParts) < 2) {
                    throw new \Exception("Invalid butterfly name format: {$butterfly['name']}");
                }

                $commonName = trim($nameParts[0]);
                $scientificName = trim($nameParts[1]);

                // Find butterfly ID by matching common and scientific names
                $butterflySpecies = ButterflySpecies::where('common_name', $commonName)
                    ->where('scientific_name', $scientificName)
                    ->first();

                if (!$butterflySpecies) {
                    throw new \Exception("Butterfly '{$butterfly['name']}' does not exist in the database.");
                }

                $newButterflyIds[] = $butterflySpecies->id;

                // Insert or update butterfly details
                ButterflyDetails::updateOrCreate(
                    [
                        'file_id' => $fileId,
                        'butterfly_id' => $butterflySpecies->id
                    ],
                    [
                        'quantity' => $butterfly['quantity']
                    ]
                );
            }

            // Delete records that are NOT in the new list
            ButterflyDetails::where('file_id', $fileId)
                ->whereNotIn('butterfly_id', $newButterflyIds)
                ->delete();
        });

        return response()->json(['message' => 'Butterfly details synced successfully']);
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
            ButterflyDetails::updateOrCreate([
                'file_id' => $fileId,
                'butterfly_id' => $butterfly['id'],
                'quantity' => $butterfly['quantity'],
            ]);
        }

        return response()->json(['message' => 'Butterfly details added successfully']);
    }

    public function getButterflyDetails($fileId)
    {
        $butterflies = DB::table('butterfly_details')
            ->join('butterfly_species', 'butterfly_details.butterfly_id', '=', 'butterfly_species.id')
            ->select(
                'butterfly_details.id',
                'butterfly_details.file_id',
                'butterfly_details.butterfly_id',
                'butterfly_details.quantity',
                'butterfly_species.scientific_name',
                'butterfly_species.common_name',
                'butterfly_species.family',
                'butterfly_species.genus',
                'butterfly_species.description',
                'butterfly_species.image_url',
                'butterfly_details.created_at',
                'butterfly_details.updated_at'
            )
            ->where('butterfly_details.file_id', $fileId)
            ->get();

        return response()->json($butterflies);
    }





}



