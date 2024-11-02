<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class StaffController extends Controller
{

    public function GetEmployees()
    {
        try {
            $employees = User::where('isAdmin', false)->get();
            return response()->json([
                'success' => true,
                'message' => 'Employee retrieved successfully.',
                'employees' => $employees
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving the file.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}