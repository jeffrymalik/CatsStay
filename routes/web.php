<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FindSitterController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\MyCatsController;
use App\Http\Controllers\MyRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SelectServiceController;
use App\Http\Controllers\SitterDashboardController;
use App\Http\Controllers\SitterProfileController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Bisa diakses tanpa login)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/catcare', function () {
    return view('pages.catcare');
});

Route::get('/aboutus', function () {
    return view('pages.aboutus');
});

Route::get('/contact', function () {
    return view('pages.contact');
});

/*
|--------------------------------------------------------------------------
| Guest Routes (Hanya bisa diakses jika BELUM login)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Register Routes
    Route::get('/signup', [AuthController::class, 'showRegister'])->name('signup');
    Route::post('/signup', [AuthController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Hanya bisa diakses jika SUDAH login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

        Route::get('/dashboardb', [SitterDashboardController::class, 'index'])
        ->name('dashboard');

    // Booking Requests Actions
    Route::post('/requests/{id}/accept', [SitterDashboardController::class, 'acceptRequest'])
        ->name('requests.accept');
    
    Route::post('/requests/{id}/reject', [SitterDashboardController::class, 'rejectRequest'])
        ->name('requests.reject');

    // Notifications
    Route::post('/notifications/mark-read', [SitterDashboardController::class, 'markNotificationsRead'])
        ->name('notifications.mark-read');

    // Earnings Data (AJAX)
    Route::get('/earnings/data', [SitterDashboardController::class, 'getEarningsData'])
        ->name('earnings.data');
    Route::get('/find-sitter', [FindSitterController::class, 'index'])->name('find-sitter');

    Route::get('/select-service', [SelectServiceController::class, 'index'])
    ->name('select.service');
    
    // Handle service selection
    Route::post('/select-service/{slug}', [SelectServiceController::class, 'select'])
    ->name('service.select');

    Route::get('/sitter/{id}', [SitterProfileController::class, 'show'])->name('sitter.profile');

    // Booking Routes
    Route::get('/booking/create/{sitter_id}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/confirmation', [BookingController::class, 'confirmation'])->name('booking.confirmation'); // <- ADD THIS

    Route::prefix('my-cats')->name('my-cats.')->group(function () {
        Route::get('/', [MyCatsController::class, 'index'])->name('index');
        Route::get('/create', [MyCatsController::class, 'create'])->name('create');
        Route::post('/', [MyCatsController::class, 'store'])->name('store');
        Route::get('/{id}', [MyCatsController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [MyCatsController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MyCatsController::class, 'update'])->name('update');
        Route::delete('/{id}', [MyCatsController::class, 'destroy'])->name('destroy');
    });

    Route::get('/my-request', [MyRequestController::class, 'index'])->name('my-request.index');
    Route::get('/my-request/{id}', [MyRequestController::class, 'show'])->name('my-request.show');

    Route::get('/messages', [MessagesController::class, 'index'])->name('messages.index');
    Route::get('/messages/{id}', [MessagesController::class, 'show'])->name('messages.show');
    Route::post('/messages/{id}/send', [MessagesController::class, 'send'])->name('messages.send');

    Route::prefix('profile')->middleware('auth')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/address', [ProfileController::class, 'address'])->name('profile.address');
        Route::get('/reviews', [ProfileController::class, 'reviews'])->name('profile.reviews');
        Route::get('/notifications', [ProfileController::class, 'notifications'])->name('profile.notifications');
        
        // Update endpoints (for future implementation)
        Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/address/update', [ProfileController::class, 'updateAddress'])->name('profile.address.update');

        // ⭐ NEW: Change Password Route
        Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    
    });

    // Review Routes
    Route::get('/review/create/{booking_id}', [ReviewController::class, 'create'])->name('review.create'); // <- ADD THIS
    Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store'); // <- ADD THIS
    
    // Tambahkan route lain yang perlu login di sini
    // Contoh:
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
});


