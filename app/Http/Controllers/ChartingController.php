<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Municipality;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use App\Models\TreeCuttingPermit;
use App\Models\TreeCuttingPermitDetail;
class ChartingController extends Controller
{
    //

    public function permitStatistics(Request $request)
    {
        $timeRange = $request->query('time_range', 'monthly');

        $query = DB::table('files')
            ->selectRaw("
            DATE_FORMAT(created_at, ?) as period, 
            municipality, 
            COUNT(id) as total
        ")
            ->groupBy('period', 'municipality')
            ->orderBy('period');

        // Adjust query format for Monthly or Yearly
        if ($timeRange === 'yearly') {
            $query->setBindings(['%Y']);
        } else {
            $query->setBindings(['%Y-%m']);
        }

        $data = $query->get();

        return response()->json($data);
    }
    public function GetTreeCuttingStatistics(Request $request)
    {
        $municipality = $request->query('municipality'); // Example: "Gasan"
        $timeframe = $request->query('timeframe', 'monthly'); // Default to 'monthly' if not provided

        // Base Query: Filter by permit type
        $query = File::where('permit_type', 'tree-cutting-permits')
            ->whereNotNull('date_released');

        // Apply municipality filter if provided
        if ($municipality) {
            $query->where('municipality', $municipality);
        }

        // Adjust grouping based on timeframe
        if ($timeframe === 'yearly') {
            $query->select(
                DB::raw('count(*) as count'),
                'municipality',
                DB::raw('YEAR(date_released) as year')
            )
                ->groupBy('municipality', DB::raw('YEAR(date_released)'))
                ->orderBy(DB::raw('YEAR(date_released)'), 'asc');
        } else { // Default to monthly grouping
            $query->select(
                DB::raw('count(*) as count'),
                'municipality',
                DB::raw('YEAR(date_released) as year'),
                DB::raw("DATE_FORMAT(date_released, '%b') as month") // Format month as "Jan", "Feb"
            )
                ->groupBy('municipality', DB::raw('YEAR(date_released)'), DB::raw("DATE_FORMAT(date_released, '%b')"))
                ->orderBy(DB::raw('YEAR(date_released)'), 'asc')
                ->orderBy(DB::raw("STR_TO_DATE(DATE_FORMAT(date_released, '%b'), '%b')"), 'asc'); // Correct order
        }

        // Get results
        $data = $query->get();
        $totalCount = $data->sum('count'); // Calculate total count

        // Return JSON response
        return response()->json([
            'data' => $data,
            'total_count' => $totalCount,
        ]);
    }


    // public function GetTreeSpeciesStatistic(Request $request)
    // {
    //     $timeframe = $request->query('timeframe', 'monthly');
    //     $species = $request->query('species');
    //     $municipality = $request->query('municipality');

    //     // Base Query: Normalize species names
    //     $query = DB::table('tree_cutting_permit_details as details')
    //         ->join('tree_cutting_permits as permits', 'details.tree_cutting_permit_id', '=', 'permits.id')
    //         ->join('files', 'permits.file_id', '=', 'files.id')
    //         ->whereNotNull('files.date_released')
    //         ->select(
    //             DB::raw('SUM(details.number_of_trees) as total_trees'),
    //             DB::raw("LOWER(TRIM(details.species)) as species"), // Normalize species
    //             'files.municipality',
    //             DB::raw('YEAR(files.date_released) as year'),
    //             DB::raw("DATE_FORMAT(files.date_released, '%b') as month")
    //         );

    //     // Apply filters
    //     if ($species) {
    //         $query->whereRaw("LOWER(TRIM(details.species)) = ?", [strtolower(trim($species))]);
    //     }
    //     if ($municipality) {
    //         $query->where('files.municipality', $municipality);
    //     }

    //     // Adjust grouping based on timeframe
    //     if ($timeframe === 'yearly') {
    //         $query->groupBy(DB::raw("LOWER(TRIM(details.species))"), 'files.municipality', DB::raw('YEAR(files.date_released)'))
    //             ->orderBy(DB::raw('YEAR(files.date_released)'), 'asc');
    //     } else { // Default to monthly
    //         $query->groupBy(DB::raw("LOWER(TRIM(details.species))"), 'files.municipality', DB::raw('YEAR(files.date_released)'), DB::raw("DATE_FORMAT(files.date_released, '%b')"))
    //             ->orderBy(DB::raw('YEAR(files.date_released)'), 'asc')
    //             ->orderBy(DB::raw("STR_TO_DATE(DATE_FORMAT(files.date_released, '%b'), '%b')"), 'asc');
    //     }

    //     // Fetch results
    //     $data = $query->get();
    //     $totalTrees = $data->sum('total_trees');

    //     return response()->json([
    //         'data' => $data,
    //         'total_trees' => $totalTrees,
    //     ]);
    // }


    public function GetTreeCuttingSpeciesChartData(Request $request)
    {
        $timeframe = $request->query('timeframe', 'monthly');
        $municipality = $request->query('municipality'); // Optional filter
        $species = $request->query('species'); // Optional filter

        // Base Query: Normalize species names
        $query = DB::table('tree_cutting_permit_details as details')
            ->join('tree_cutting_permits as permits', 'details.tree_cutting_permit_id', '=', 'permits.id')
            ->join('files', 'permits.file_id', '=', 'files.id')
            ->whereNotNull('details.date_applied') // Correct date field
            ->select(
                DB::raw('SUM(details.number_of_trees) as total_trees'),
                DB::raw("LOWER(TRIM(details.species)) as species"),
                'files.municipality',
                DB::raw('YEAR(details.date_applied) as year'), // Correct date field
                DB::raw("DATE_FORMAT(details.date_applied, '%b %Y') as month"), // Correct date field
                'details.date_applied' // Ensure this is in GROUP BY
            );

        // Apply filters
        if ($municipality) {
            $query->where('files.municipality', $municipality);
        }
        if ($species) {
            $query->whereRaw("LOWER(TRIM(details.species)) = ?", [strtolower(trim($species))]);
        }

        // Adjust grouping based on timeframe
        if ($timeframe === 'yearly') {
            $query->groupBy(
                DB::raw("LOWER(TRIM(details.species))"),
                'files.municipality',
                DB::raw('YEAR(details.date_applied)'),
                DB::raw("DATE_FORMAT(details.date_applied, '%b %Y')"), // ✅ Add this
                'details.date_applied' // ✅ Add this
            );
        } else { // Default to monthly
            $query->groupBy(
                DB::raw("LOWER(TRIM(details.species))"),
                'files.municipality',
                DB::raw('YEAR(details.date_applied)'),
                DB::raw("DATE_FORMAT(details.date_applied, '%b')"),
                'details.date_applied' // 🔥 Added this line
            )
                ->orderBy(DB::raw('YEAR(details.date_applied)'), 'asc')
                ->orderBy(DB::raw("STR_TO_DATE(DATE_FORMAT(details.date_applied, '%b'), '%b')"), 'asc');
        }

        // Fetch results
        $data = $query->get();

        return response()->json($data);
    }


    public function GetTreeCuttingByCategory(Request $request)
    {
        $timeframe = $request->query('timeframe', 'monthly'); // 'monthly' or 'yearly'
        $municipality = $request->query('municipality'); // Optional filter

        // Base Query
        $query = DB::table('tree_cutting_permit_details as details')
            ->join('tree_cutting_permits as permits', 'details.tree_cutting_permit_id', '=', 'permits.id')
            ->join('files', 'permits.file_id', '=', 'files.id') // Join to get municipality
            ->whereNotNull('details.date_applied')
            ->select(
                'permits.permit_type',
                DB::raw('SUM(details.number_of_trees) as total_trees'),
                DB::raw('YEAR(details.date_applied) as year'),
                DB::raw("DATE_FORMAT(details.date_applied, '%b') as month") // Ensure it's included in GROUP BY
            );

        // Apply Municipality Filter
        if ($municipality) {
            $query->where('files.municipality', $municipality);
        }

        // Adjust Grouping Based on Timeframe
        if ($timeframe === 'yearly') {
            $query->groupBy(
                'permits.permit_type',
                DB::raw('YEAR(details.date_applied)'),
                DB::raw("DATE_FORMAT(details.date_applied, '%b')")
            );

        } else { // Default to Monthly
            $query->groupBy(
                'permits.permit_type',
                DB::raw('YEAR(details.date_applied)'),
                DB::raw("DATE_FORMAT(details.date_applied, '%b')")
            ) // Added missing group by field
                ->orderBy(DB::raw('YEAR(details.date_applied)'), 'asc')
                ->orderBy(DB::raw("STR_TO_DATE(DATE_FORMAT(details.date_applied, '%b'), '%b')"), 'asc');
        }

        // Fetch Data
        $data = $query->get();

        return response()->json($data);
    }







}
