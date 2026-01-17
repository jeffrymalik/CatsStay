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
| PUBLIC ROUTES - Accessible without login
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/catcare', function () {
    return view('pages.catcare');
})->name('catcare');

Route::get('/aboutus', function () {
    return view('pages.aboutus');
})->name('aboutus');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

/*
|--------------------------------------------------------------------------
| GUEST ROUTES - Only accessible when NOT logged in
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/signup', [AuthController::class, 'showRegister'])->name('signup');
    Route::post('/signup', [AuthController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES - Requires login (all roles)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Logout (available for all authenticated users)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/address', [ProfileController::class, 'address'])->name('address');
        Route::get('/reviews', [ProfileController::class, 'reviews'])->name('reviews');
        Route::get('/notifications', [ProfileController::class, 'notifications'])->name('notifications');
        
        // Update Actions
        Route::post('/update', [ProfileController::class, 'update'])->name('update');
        // Address management
        Route::get('/address', [ProfileController::class, 'address'])->name('address');
        Route::post('/address/store', [ProfileController::class, 'storeAddress'])->name('address.store');
        Route::post('/address/update/{id}', [ProfileController::class, 'updateAddress'])->name('address.update');
        Route::post('/address/set-primary/{id}', [ProfileController::class, 'setPrimaryAddress'])->name('address.set-primary');
        Route::delete('/address/delete/{id}', [ProfileController::class, 'destroyAddress'])->name('address.destroy');
        Route::get('/address/get/{id}', [ProfileController::class, 'getAddress'])->name('address.get');

        Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('change-password');
    });
});

/*
|--------------------------------------------------------------------------
| NORMAL USER ROUTES - Cat Owners (role: normal)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'normal.user'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    
    // Service Selection
    Route::get('/select-service', [SelectServiceController::class, 'index'])->name('select.service');
    Route::post('/select-service/{slug}', [SelectServiceController::class, 'select'])->name('service.select');
    
    // Find Sitter
    Route::get('/find-sitter', [FindSitterController::class, 'index'])->name('find-sitter');
    Route::get('/sitter/{id}', [SitterProfileController::class, 'show'])->name('sitter.profile');
    
    // Booking Management
    Route::prefix('booking')->name('booking.')->group(function () {
        Route::get('/create/{sitter_id}', [BookingController::class, 'create'])->name('create');
        Route::post('/store', [BookingController::class, 'store'])->name('store');
        Route::get('/confirmation/{id}', [BookingController::class, 'confirmation'])->name('confirmation');
    });
    
    // My Cats Management
    Route::prefix('my-cats')->name('my-cats.')->group(function () {
        Route::get('/', [MyCatsController::class, 'index'])->name('index');
        Route::get('/create', [MyCatsController::class, 'create'])->name('create');
        Route::post('/', [MyCatsController::class, 'store'])->name('store');
        Route::get('/{id}', [MyCatsController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [MyCatsController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MyCatsController::class, 'update'])->name('update');
        Route::delete('/{id}', [MyCatsController::class, 'destroy'])->name('destroy');
    });
    
    // My Requests (Booking History)
    Route::prefix('my-request')->name('my-request.')->group(function () {
        Route::get('/', [MyRequestController::class, 'index'])->name('index');
        Route::get('/{id}', [MyRequestController::class, 'show'])->name('show');

         // Payment Routes
        Route::get('/{id}/payment', [BookingController::class, 'payment'])->name('payment');
        Route::post('/{id}/process-payment', [BookingController::class, 'processPayment'])->name('process-payment');
        Route::get('/{id}/payment-success', [BookingController::class, 'paymentSuccess'])->name('payment.success');
        
        // Cancel Booking
        Route::post('/{id}/cancel', [BookingController::class, 'cancel'])->name('cancel');
    });
    
    // Messages
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessagesController::class, 'index'])->name('index');
        Route::get('/{id}', [MessagesController::class, 'show'])->name('show');
        Route::post('/{id}/send', [MessagesController::class, 'send'])->name('send');
    });
    
    // Reviews
    Route::prefix('review')->name('review.')->group(function () {
        Route::get('/create/{booking_id}', [ReviewController::class, 'create'])->name('create');
        Route::post('/store', [ReviewController::class, 'store'])->name('store');
    });
    
    // Profile Management
    // Route::prefix('profile')->name('profile.')->group(function () {
    //     Route::get('/', [ProfileController::class, 'index'])->name('index');
    //     Route::get('/address', [ProfileController::class, 'address'])->name('address');
    //     Route::get('/reviews', [ProfileController::class, 'reviews'])->name('reviews');
    //     Route::get('/notifications', [ProfileController::class, 'notifications'])->name('notifications');
        
    //     // Update Actions
    //     Route::post('/update', [ProfileController::class, 'update'])->name('update');
    //     // Address management
    //     Route::get('/address', [ProfileController::class, 'address'])->name('address');
    //     Route::post('/address/store', [ProfileController::class, 'storeAddress'])->name('address.store');
    //     Route::post('/address/update/{id}', [ProfileController::class, 'updateAddress'])->name('address.update');
    //     Route::post('/address/set-primary/{id}', [ProfileController::class, 'setPrimaryAddress'])->name('address.set-primary');
    //     Route::delete('/address/delete/{id}', [ProfileController::class, 'destroyAddress'])->name('address.destroy');
    //     Route::get('/address/get/{id}', [ProfileController::class, 'getAddress'])->name('address.get');

    //     Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('change-password');
    // });
});

/*
|--------------------------------------------------------------------------
| PET SITTER ROUTES (role: sitter)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'pet.sitter'])->prefix('pet-sitter')->name('pet-sitter.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [SitterDashboardController::class, 'index'])->name('dashboard');
    
    // Booking Requests Management
    Route::get('/requests', [SitterDashboardController::class, 'requests'])->name('requests.index');
    Route::post('/requests/{id}/accept', [SitterDashboardController::class, 'acceptRequest'])->name('requests.accept');
    Route::post('/requests/{id}/reject', [SitterDashboardController::class, 'rejectRequest'])->name('requests.reject');
    Route::get('/requests/{id}', [SitterDashboardController::class, 'show'])
    ->name('requests.show');

     // Service Management
    Route::get('/services', [SitterDashboardController::class, 'services'])->name('services.index');
    Route::post('/services/update', [SitterDashboardController::class, 'updateServices'])->name('services.update');

    // Profile Setup
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    // Route::get('/profileindex', [ProfileController::class, 'index'])->name('profiles');
    Route::post('/profile/updates', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/upload-avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.upload-avatar');
    Route::post('/profile/upload-gallery', [ProfileController::class, 'uploadGallery'])->name('profile.upload-gallery');
    Route::delete('/profile/delete-gallery/{id}', [ProfileController::class, 'deleteGallery'])->name('profile.delete-gallery');
    
    // Route::get('/profile/address', [ProfileController::class, 'address'])->name('address');
    // Route::get('/profile/reviews', [ProfileController::class, 'reviews'])->name('reviews');
    // Route::get('/notifications', [ProfileController::class, 'notifications'])->name('notifications');
    // // Update Actions
    // Route::post('/profile/update', [ProfileController::class, 'update'])->name('update');
    // // Address management
    // Route::post('/profile/address/store', [ProfileController::class, 'storeAddress'])->name('address.store');
    // Route::post('/profile/address/update/{id}', [ProfileController::class, 'updateAddress'])->name('address.update');
    // Route::post('/profile/address/set-primary/{id}', [ProfileController::class, 'setPrimaryAddress'])->name('address.set-primary');
    // Route::delete('/profile/address/delete/{id}', [ProfileController::class, 'destroyAddress'])->name('address.destroy');
    // Route::get('/profile/address/get/{id}', [ProfileController::class, 'getAddress'])->name('address.get');
    // Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('change-password');
    
    
    // Notifications
    Route::post('/notifications/mark-read', [SitterDashboardController::class, 'markNotificationsRead'])
        ->name('notifications.mark-read');
    
    // Earnings Data (AJAX endpoint)
    Route::get('/earnings/data', [SitterDashboardController::class, 'getEarningsData'])
        ->name('earnings.data');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (role: admin) - For future Phase 3
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin routes will be added in Phase 3
    // Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});