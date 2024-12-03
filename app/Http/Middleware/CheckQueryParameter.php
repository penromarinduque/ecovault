<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\FileType;
class CheckQueryParameter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $validTypes = FileType::where('classification_id', 1)->pluck('type_name')->toArray();
        $validRecords = FileType::where('classification_id', 2)->pluck('type_name')->toArray();

        if ($request->has('type')) {
            // Validate the 'type' parameter
            if (!in_array($request->query('type'), $validTypes)) {
                return response()->json([
                    'message' => 'Invalid type parameter value.',
                ], 400); // Return a 400 Bad Request
            }
        }
        if ($request->has('record')) {
            // Validate the 'type' parameter
            if (!in_array($request->query('record'), $validRecords)) {
                return response()->json([
                    'message' => 'Invalid type parameter value.',
                ], 400); // Return a 400 Bad Request
            }
        }

        return $next($request);
    }
}
