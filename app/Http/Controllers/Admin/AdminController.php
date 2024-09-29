<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    function ShowHome()
    {

        return view('admin.home');
    }

    function ShowFileManager()
    {
        return view('admin.file-manager.file-manager');
    }

    function ShowMunicipality($type){
        return view('admin.file-manager.municipality', compact('type'));
    }

    function ShowMunicipalityWithCategory($type, $category)
    {
        return view('admin.file-manager.municipality', compact('type', 'category'));
    }

    function ShowLandTitlesOrPatentedLots($type){
        
        return view('admin.file-manager.land-title-categories', compact('type'));
    }

    function ShowTable($type, $municipality){
        return view('admin.file-manager.table', compact('type',  'municipality'));
    }
    function ShowTableWithCategory($type, $category, $municipality){
        return view('admin.file-manager.table', compact('type', 'category',  'municipality'));
    }
    

}
