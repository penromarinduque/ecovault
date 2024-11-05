<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class StaffController extends Controller
{

    public function GetEmployees(Request $request)
    {
        try {

            $search = $request->input('search');

            $query = User::where('isAdmin', false);

            if ($search) {
                $query->where('name', 'like', "%{$search}%");
            }
            $employees = $query->get();
            return response()->json([
                'success' => true,
                'message' => 'Employees retrieved successfully.',
                'employees' => $employees
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'fail retrieve of employees',
                'error' => $e->getMessage()
            ], 500);


        }
    }


}