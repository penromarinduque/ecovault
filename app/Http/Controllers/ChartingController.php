<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Municipality;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
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

    public function getTreeCuttingStatistics(Request $request)
    {
        // Define the permit type you want to filter by
        $data = File::where('permit_type', 'tree-cutting-permits')
            ->whereNotNull('date_released') // Filter out null date_released (and thus year)
            ->select(DB::raw('count(*) as count'), 'municipality', DB::raw('YEAR(date_released) as year'), DB::raw('MONTH(date_released) as month'))
            ->groupBy('municipality', DB::raw('YEAR(date_released)'), DB::raw('MONTH(date_released)'))
            ->orderBy(DB::raw('YEAR(date_released)'), 'asc') // Order by year first
            ->orderBy(DB::raw('MONTH(date_released)'), 'asc') // Then order by month
            ->get();

        // Calculate total counts per municipality and per year


        // Calculate the global total (sum of all counts)
        $totalCount = $data->sum('count');

        // Return the data and totals as JSON for use in the frontend
        return response()->json([
            'data' => $data,
            'total_count' => $totalCount,
        ]);
    }








}
