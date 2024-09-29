<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;

use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Admin\MunicipalityController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', [AdminController::class, 'Home']);

Route::get('/register', [AuthController::class, 'ShowRegistrationForm'])->name('register.show');
Route::post('store-account', [AuthController::class, 'StoreAccount'])->name('user.post');
Route::get('/login', [AuthController::class, 'ShowLogin'])->name('login.show');
Route::post('login', [AuthController::class, 'Login'])->name('login.post');

Route::get('/admin', [AdminController::class, 'ShowHome'])->name('admin.home.show');
Route::get('/admin/file-manager', [AdminController::class, 'ShowFileManager']);


Route::get('/admin/municipality/{type}', [MunicipalityController::class, 'ShowMunicipality'])->name('municipality.show');

