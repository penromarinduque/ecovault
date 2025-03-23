<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Municipality;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use App\Models\TreeCuttingPermit;
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


    // public function GetTreeCuttingStatistics(Request $request)
    // {
    //     $data = TreeCuttingPermit::select(
    //         DB::raw('YEAR(tree_cutting_permits.created_at) as year'),
    //         'files.municipality',
    //         DB::raw('COUNT(tree_cutting_permits.id) as permit_count')
    //     )
    //         ->join('files', 'tree_cutting_permits.file_id', '=', 'files.id')
    //         ->groupBy('year', 'files.municipality')
    //         ->orderBy('year')
    //         ->orderBy('files.municipality')
    //         ->get();

    //     return response()->json([
    //         'data' => $data
    //     ]);
    // }








}
