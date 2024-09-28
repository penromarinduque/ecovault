<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MunicipalityController extends Controller
{
    //

    function ShowMunicipality($type){
        return view('admin.file-manager.municipality', compact('type'));
    }
}
