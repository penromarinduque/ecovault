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

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->name('password.email');

Route::get('/reset-password/{token}', function (Request $request, string $token) {
    return view('auth.forgot-password.reset-password', [
        'token' => $token,
        'email' => $request->email
    ]);
})->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    // Ensure the user exists
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'No user found with this email address.']);
    }

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login.show')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->name('password.update');

Route::get('/register', [AuthController::class, 'ShowRegistrationForm'])->name('register.show');
Route::post('/store-account', [AuthController::class, 'StoreAccount'])->name('user.post');
Route::get('/login', [AuthController::class, 'ShowLogin'])->name('login.show');
Route::post('/login/auth', [AuthController::class, 'Authenticate'])->name('login.post');
Route::get('/verify', [AuthController::class, 'ShowVerification'])->name('verification.show');
Route::post('/verify/account', [AuthController::class, 'VerifyEmail'])->name('verify.email.post');
Route::post('/logout', [AuthController::class, 'Logout'])->name('logout.post');

Route::middleware(['authentication'])->group(function () {
    Route::get('/staff', [AdminController::class, 'ShowHome'])->name('admin.home.show');
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

