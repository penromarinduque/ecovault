<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MunicipalityController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', [AdminController::class, 'ShowHome']);
Route::get('/admin/file-manager', [AdminController::class, 'ShowFileManager']);

Route::get('/admin/municipality/{type}', [MunicipalityController::class, 'ShowMunicipality'])->name('municipality.show');
