<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    function ShowHome(){
        return view('admin.home');
    }

    function ShowFileManager(){
        return view('admin.file-manager.file-manager');
    }

}
