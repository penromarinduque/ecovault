<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;

use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Admin\MunicipalityController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');

Route::get('/admin', [AdminController::class, 'ShowHome']);
Route::get('/admin/file-manager', [AdminController::class, 'ShowFileManager'])->name('file-manager.show');

Route::get('/admin/{type}/municipality', [AdminController::class, 'ShowMunicipality'])->name('file-manager.municipality.show');

Route::get('/admin/{type}/categories', [AdminController::class, 'ShowLandTitlesOrPatentedLots'])->name('file-manager.land-title.show');
Route::get('/admin/{type}/{category}/municipality', [AdminController::class, 'ShowMunicipalityWithCategory'])->name('file-manager.municipality.with-category.show');
Route::get('/admin/{type}/{municipality}', [AdminController::class, 'ShowTable'])->name('file-manager.table.show');
Route::get('/admin/{type}/{category}/{municipality}', [AdminController::class, 'ShowTableWithCategory'])->name('file-manager.table.with-category.show');


