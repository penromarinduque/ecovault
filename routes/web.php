<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;

use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Admin\MunicipalityController;
use App\Models\User;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\StorageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/forgot-password', function () {
    return view('auth.forgot-password.forgot-password');
})->name('password.request');

Route::post('/forgot-password', [AuthController::class, 'SendPassResetLink'])->name('password.email');

Route::get('/reset-password/{token}', [AuthController::class, 'ShowResetForm'])->name('password.reset');

Route::post('/reset-password', [AuthController::class, 'Reset'])->name('password.update');

Route::get('/register', [AuthController::class, 'ShowRegistrationForm'])->name('register.show');
Route::post('/store-account', [AuthController::class, 'StoreAccount'])->name('user.post');
Route::get('/login', [AuthController::class, 'ShowLogin'])->name('login.show');
Route::post('/login/auth', [AuthController::class, 'Authenticate'])->name('login.post');
Route::get('/verify', [AuthController::class, 'ShowVerification'])->name('verification.show');
Route::post('/verify/account', [AuthController::class, 'VerifyEmail'])->name('verify.email.post');
Route::post('/logout', [AuthController::class, 'Logout'])->name('logout.post');

Route::middleware(['authentication'])->group(function () {
    Route::get('/staff', [AdminController::class, 'ShowHome'])->name('admin.home.show');
    Route::get('/staff/storage-usage', [StorageController::class, 'GetStorageUsage'])->name('admin.storage.usage');

    Route::get('/file-manager/{type}/{category}/municipality', [AdminController::class, 'ShowMunicipalityWithCategory'])->name('file-manager.municipality.with-category.show');
    Route::get('/file-manager/{type}/{category}/{municipality}', [AdminController::class, 'ShowTableWithCategory'])->name('file-manager.table.with-category.show');
    Route::get('/file-manager', [AdminController::class, 'ShowFileManager'])->name('file-manager.show');
    Route::get('/file-manager/{type}/municipality', [AdminController::class, 'ShowMunicipality'])->name('file-manager.municipality.show');
    Route::get('/file-manager/{type}/categories', [AdminController::class, 'ShowLandTitlesOrPatentedLots'])->name('file-manager.land-title.show');
    Route::get('/file-manager/municipality/{type}', [MunicipalityController::class, 'ShowMunicipality'])->name('municipality.show');
    Route::get('/file-manager/{type}/{municipality}', [AdminController::class, 'ShowTable'])->name('file-manager.table.show');

    Route::get("/administrative-document", [AdminController::class, "ShowAdministrativeDocuments"])->name('administrative.show');
    Route::get('/administrative-document/{record}', [AdminController::class, 'ShowRecord'])->name('administrative.record.show');

    Route::post('/file-upload', [FileController::class, 'StoreFile'])->name('file.post');
    Route::post('/permit-upload', [FileController::class, 'StorePermit'])->name('permit.post');
    Route::post('/api/file-upload', [FileController::class, 'StoreFileNoRelation']);

    Route::get("/api/files/{type}/{municipality}", [FileController::class, 'GetFiles'])->name('file.getAll');

    Route::get("/api/file/{id}", [FileController::class, "GetFileById"])->name("file.get");
    Route::get("/api/file-only/{id}", [FileController::class, "GetOnlyFileById"]);
    Route::POST('/api/file-only/update/{id}', [FileController::class, "UpdateFileOnlyById"]);
    Route::get('/api/download/{id}', [FileController::class, 'Download'])->name('file.download');



    Route::post('/file-upload/test', [FileController::class, 'Upload'])->name('file.upload');
    Route::get('/api/files-without-relationships', [FileController::class, 'GetFilesWithoutRelationships']);

    Route::get("/superuser/test", function () {
        return view("superuser.test");
    });

    Route::get('/recent-uploads', [StorageController::class, 'getRecentUploads']);
    Route::POST('/api/files/update/{fileId}', [FileController::class, 'EditFile'])->name('file.edit');

});

