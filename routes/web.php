<?php

use App\Http\Controllers\BaseController;
use App\Http\Controllers\CRUD\ArchiveController;
use App\Http\Controllers\CRUD\FileManagerController;
use App\Http\Controllers\CRUD\UploadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MunicipalityController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FileSharing\FileShareController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\StorageController;
use App\Http\Controllers\API\StaffController;

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
Route::get('/logout', [AuthController::class, 'Logout'])->name('logout.post');

Route::middleware(['authentication'])->group(function () {
    Route::get('/staff', [AdminController::class, 'ShowHome'])->name('admin.home.show');
    Route::get('/staff/storage-usage', [StorageController::class, 'GetStorageUsage'])->name('admin.storage.usage');
    Route::get('/api/getAreaChart', [StorageController::class, 'GetAreaChartData']);


    Route::get('/file-manager/{type}/{category}/municipality', [AdminController::class, 'ShowMunicipalityWithCategory'])->name('file-manager.municipality.with-category.show');
    Route::get('/file-manager/{type}/{category}/{municipality}', [AdminController::class, 'ShowTableWithCategory'])->name('file-manager.table.with-category.show');
    Route::get('/file-manager', [AdminController::class, 'ShowFileManager'])->name('file-manager.show');
    Route::get('/file-manager/{type}/municipality', [AdminController::class, 'ShowMunicipality'])->name('file-manager.municipality.show');
    Route::get('/file-manager/{type}/categories', [AdminController::class, 'ShowLandTitlesOrPatentedLots'])->name('file-manager.land-title.show');

    Route::get('/file-manager/{type}/{municipality}', [AdminController::class, 'ShowTable'])->name('file-manager.table.show');

    Route::get("/administrative-document", [AdminController::class, "ShowAdministrativeDocuments"])->name('administrative.show');
    Route::get('/administrative-document/{record}', [AdminController::class, 'ShowRecord'])->name('administrative.record.show');

    //ARCHIVED FILE MANAGER 
    Route::get('/archived-file', [AdminController::class, 'ShowArchivedFiles'])->name('archived-file.show');
    Route::get('/archived-file/file-manager', [AdminController::class, 'ShowArchivedFileManager'])->name('archived-file.file-manager.show');
    Route::get('/archived-file/file-manager/{type}/municipality', [AdminController::class, 'ShowArchivedMunicipality'])->name('archived.file-manager.municipality.show');
    Route::get('/archived-file/file-manager/{type}/categories', [AdminController::class, 'ShowArchivedandTitlesOrPatentedLots'])->name('archived.file-manager.land-title.show');
    Route::get('/archived-file/file-manager/{type}/{category}/municipality', [AdminController::class, 'ShowArchivedMunicipalityWithCategory'])->name('file-manager.municipality.with-category.show');
    Route::get('/archived-file/file-manager/{type}/{category}/{municipality}', [AdminController::class, 'ShowTableWithCategory'])->name('archived.file-manager.table.with-category.show');
    Route::get('/archived-file/file-manager/{type}/{municipality}', [AdminController::class, 'ShowArchivedFileManagerTable'])->name('archived.file-manager.table.show');

    Route::get('/archived-file/administrative-document', [AdminController::class, 'ShowArchivedAdministrativeDocument'])->name('archived.administrative.show');
    Route::get("/archived-file/administrative-document/{record}", [AdminController::class, 'ShowArchivedAdministrativeDocumentRecord'])->name('archived.administrative.record.show');

    //API HANDLER 
    Route::post('/file-upload', [UploadController::class, 'StoreFile'])->name('file.post');
    Route::post('/permit-upload', [FileManagerController::class, 'StorePermit'])->name('permit.post');
    // Route::post('/api/file-upload', [FileController::class, 'StoreFileNoRelation']);

    //Store File
    Route::get("/api/files", [FileManagerController::class, 'GetFiles'])->name('file.getAll');
    Route::post('/api/files/update/{id}', [FileManagerController::class, 'UpdateFileById'])->name('file.update');
    Route::get("/api/files/{id}", [FileManagerController::class, "GetFileById"])->name("file.get");
    Route::get('/api/files/download/{id}', [FileController::class, 'DownloadFileById'])->name('file.download');
    Route::get('/api/files/view/{id}', [FileController::class, 'ViewFileById']);
    Route::post('/api/files/archived/{id}', [ArchiveController::class, 'ArchivedById'])->name('file.archived');

    Route::get('/api/municipalities', [MunicipalityController::class, 'GetMunicipalities']);

    Route::get('/superuser/test', function () {
        return view("superuser.test");
    });

    //Home Page
    Route::get('/recent-uploads', [StorageController::class, 'getRecentUploads']);
    Route::get('/files/count', [StorageController::class, 'countFilesByExtension']);

    //
    Route::post('/api/files/share', [FileShareController::class, 'ShareFile']);

    Route::post('/api/files/request/{id}', [FileShareController::class, 'StoreRequest']);
    Route::get('/api/files/GET/request-access', [FileShareController::class, 'GetFileAccessRequests']);

    //Left behind
    Route::patch('/api/files/request-access/{id}', [FileShareController::class, 'UpdateRequestStatus']);


    Route::get('/api/users/', [StaffController::class, 'GetEmployees']);

    Route::get('/file-request', function () {
        return view('admin.file-request.table');
    });
});

