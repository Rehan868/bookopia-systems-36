
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SettingsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Bookings
    Route::resource('bookings', BookingController::class);
    
    // Rooms
    Route::resource('rooms', RoomController::class);
    Route::get('/availability', [RoomController::class, 'availability'])->name('availability');
    Route::get('/cleaning', [RoomController::class, 'cleaningStatus'])->name('cleaning');
    
    // Owners
    Route::resource('owners', OwnerController::class)->middleware('can:manage-owners');
    
    // Users
    Route::resource('users', UserController::class)->middleware('can:manage-users');
    
    // Reports
    Route::get('/reports', [DashboardController::class, 'reports'])->name('reports');
    
    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::get('/settings/properties/add', [SettingsController::class, 'addProperty'])->name('properties.add');
    Route::get('/settings/properties/{id}/edit', [SettingsController::class, 'editProperty'])->name('properties.edit');
    Route::get('/settings/room-types/add', [SettingsController::class, 'addRoomType'])->name('roomTypes.add');
    Route::get('/settings/room-types/{id}/edit', [SettingsController::class, 'editRoomType'])->name('roomTypes.edit');
    
    // Profile
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
});

// Owner Portal routes
Route::prefix('owner')->name('owner.')->group(function () {
    Route::get('/login', [AuthController::class, 'showOwnerLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'ownerLogin']);
    
    Route::middleware(['auth', 'role:owner'])->group(function () {
        Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('dashboard');
        Route::get('/bookings', [OwnerController::class, 'bookings'])->name('bookings');
        Route::get('/cleaning', [OwnerController::class, 'cleaningStatus'])->name('cleaning');
        Route::get('/availability', [OwnerController::class, 'availability'])->name('availability');
        Route::get('/reports', [OwnerController::class, 'reports'])->name('reports');
    });
});
