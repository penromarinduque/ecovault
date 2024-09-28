<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', [AdminController::class, 'Home']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
