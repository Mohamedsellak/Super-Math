<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');

Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');





Route::middleware([AuthMiddleware::class])->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit-email', [ProfileController::class, 'editEmail'])->name('profile.edit-email');
    Route::get('/profile/edit-password', [ProfileController::class, 'editPassword'])->name('profile.edit-password');
    Route::get('/profile/edit-info', [ProfileController::class, 'editProfile'])->name('profile.edit-info');

    // Profile Update Routes (you'll need to implement these methods)
    Route::put('/profile/update-email', [ProfileController::class, 'updateEmail'])->name('profile.update-email');
    Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::put('/profile/update-info', [ProfileController::class, 'updateInfo'])->name('profile.update-info');

    // Dashboard Routes
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

});

// Admin Routes
Route::middleware([AuthMiddleware::class, AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    // Add more admin routes here
});



// // Temporary route to create admin user (remove in production)
// Route::get('/create-admin', [AuthController::class, 'createAdmin']);
