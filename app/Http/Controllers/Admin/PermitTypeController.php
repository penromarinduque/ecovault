<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FileType;

class PermitTypeController extends Controller
{
    function GetPermitTypes()
    {
        $permitTypes = FileType::where('classification_id', 1)->get();

        return response()->json([
            'success' => true,
            'permitTypes' => $permitTypes,
        ]);
    }
}
