<?php

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\QuestionsController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TopicController;

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserQuestionsController;
use App\Http\Controllers\User\CreditController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\AdminMiddleware;



// Home Route
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




// 
Route::middleware([AuthMiddleware::class])->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit-email', [ProfileController::class, 'editEmail'])->name('profile.edit-email');
    Route::get('/profile/edit-password', [ProfileController::class, 'editPassword'])->name('profile.edit-password');
    Route::get('/profile/edit-info', [ProfileController::class, 'editInfo'])->name('profile.edit-info');

    // Profile Update Routes (you'll need to implement these methods)
    Route::put('/profile/update-email', [ProfileController::class, 'updateEmail'])->name('profile.update-email');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::put('/profile/update-info', [ProfileController::class, 'updateInfo'])->name('profile.update-info');


    // User Dashboard Routes
    Route::prefix('dashboard')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('dashboard');

        Route::get('/questions', [UserQuestionsController::class, 'index'])->name('questions.index');
        Route::post('/questions/download', [UserQuestionsController::class, 'download'])->name('questions.download');

        // API endpoint for getting topics by subject (for user filtering)
        Route::get('/subjects/{subject}/topics', [UserQuestionsController::class, 'getTopics'])->name('subjects.topics');

        // Credit Routes
        Route::get('/credits', [CreditController::class, 'index'])->name('credits.index');
        Route::get('/credits/purchase', [CreditController::class, 'purchase'])->name('credit.purchase');
        Route::post('/credits/create-payment', [CreditController::class, 'createPayment'])->name('credit.create-payment');
        Route::get('/credits/payment/success', [CreditController::class, 'paymentSuccess'])->name('credit.payment.success');
        Route::get('/credits/payment/failure', [CreditController::class, 'paymentFailure'])->name('credit.payment.failure');
        Route::get('/credits/payment/pending', [CreditController::class, 'paymentPending'])->name('credit.payment.pending');

    });

});

// MercadoPago Webhook (outside authentication)
Route::post('/mercadopago/webhook', [CreditController::class, 'webhook'])->name('credit.payment.webhook');

// Admin Routes
Route::prefix('Dashboard')->name('admin.')->middleware([AuthMiddleware::class, AdminMiddleware::class])->group(function () {
    Route::get('/',[AdminController::class, 'index'])->name('dashboard');

    // User Management Routes
    Route::resource('users', UsersController::class);

    // Questions Management Routes
    Route::get('/questions/{question}/download-document', [QuestionsController::class, 'downloadDocument'])->name('questions.download-document');
    Route::resource('questions', QuestionsController::class);

    
    // Subject Management Routes
    Route::resource('subjects', SubjectController::class);
    
    // Topic Management Routes
    Route::resource('topics', TopicController::class);
});

// Subject Management Routes - API endpoint for getting topics
Route::get('/subjects/{subject}/topics', [SubjectController::class, 'getTopics'])->name('subjects.topics');
