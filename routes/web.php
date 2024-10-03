<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;

use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Admin\MunicipalityController;

use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\StorageController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [AuthController::class, 'ShowRegistrationForm'])->name('register.show');
Route::post('/store-account', [AuthController::class, 'StoreAccount'])->name('user.post');
Route::get('/login', [AuthController::class, 'ShowLogin'])->name('login.show');
Route::post('/login/auth', [AuthController::class, 'Authenticate'])->name('login.post');

Route::middleware(['authentication'])->group(function () {
    Route::get('/admin', [AdminController::class, 'ShowHome'])->name('admin.home.show');
    Route::get('/admin/storage-usage', [StorageController::class, 'GetStorageUsage'])->name('admin.storage.usage');

    Route::get('/admin/municipality/{type}', [MunicipalityController::class, 'ShowMunicipality'])->name('municipality.show');
    Route::get('/admin/file-manager', [AdminController::class, 'ShowFileManager'])->name('file-manager.show');
    Route::get('/admin/{type}/municipality', [AdminController::class, 'ShowMunicipality'])->name('file-manager.municipality.show');
    Route::get('/admin/{type}/categories', [AdminController::class, 'ShowLandTitlesOrPatentedLots'])->name('file-manager.land-title.show');
    Route::get('/admin/{type}/{category}/municipality', [AdminController::class, 'ShowMunicipalityWithCategory'])->name('file-manager.municipality.with-category.show');
    Route::get('/admin/{type}/{municipality}', [AdminController::class, 'ShowTable'])->name('file-manager.table.show');
    Route::get('/admin/{type}/{category}/{municipality}', [AdminController::class, 'ShowTableWithCategory'])->name('file-manager.table.with-category.show');
    Route::post('/file-upload', [FileController::class, 'upload'])->name('file.post');
});

