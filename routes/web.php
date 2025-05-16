<?php

use App\Http\Controllers\Admin\CustomerManageController;
use App\Http\Controllers\Admin\RentalManageController;
use App\Http\Controllers\Admin\VehicleManageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\ShowdetailsController;
use App\Http\Controllers\VehicleController;
use App\Models\Customer;
use App\Models\Rental;
use Illuminate\Support\Facades\Route;

Route::get('/', [VehicleController::class, 'homepagecar'])->name('home');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth', 'App\Http\Middleware\CustomerMiddleware')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'App\Http\Middleware\AdminMiddleware'])->group(function () {
    //rafi
    Route::get('/car', [ShowController::class, 'index'])->name('show');
    Route::get('/car/show/{id}', [ShowdetailsController::class, 'index'])->name('showcar');

    Route::get('/admin', [AdminController::class, 'index'])->name('admin');

    //Vehicles Manage
    Route::get('/admin/vehicles', [VehicleManageController::class, 'index'])->name('vehicles.manage.index');
    Route::get('/admin/vehicles/create', [VehicleManageController::class, 'create'])->name('vehicles.manage.create');
    Route::post('/admin/vehicles/store', [VehicleManageController::class, 'store'])->name('vehicles.manage.store');
    Route::get('/admin/{id}/edit', [VehicleManageController::class, 'edit'])->name('vehicles.manage.edit');
    Route::put('/admin/vehicles/{id}/update', [VehicleManageController::class, 'update'])->name('vehicles.manage.update');
    Route::delete('/admin/destroy/{vehicle}', [VehicleManageController::class, 'destroy'])->name('vehicles.manage.destroy');

    //Customer Manage
    Route::get('/admin/customers/', [CustomerManageController::class, 'index'])->name('customers.manage.index');
    Route::get('/admin/customers/create', [CustomerManageController::class, 'create'])->name('customers.manage.create');
    Route::get('/admin/customers/{id}', [CustomerManageController::class, 'show'])->name('customers.manage.show');
    Route::post('/admin/customers/store', [CustomerManageController::class, 'store'])->name('customers.manage.store');
    Route::get('/admin/customers/{id}/edit', [CustomerManageController::class, 'edit'])->name('customers.manage.edit');
    Route::put('/admin/customers/{id}', [CustomerManageController::class, 'update'])->name('customers.manage.update');
    Route::delete('/admin/customers/{id}', [CustomerManageController::class, 'destroy'])->name('customers.manage.destroy');

    //Booking Manage
    Route::get('/admin/bookings/', [RentalManageController::class, 'index'])->name('bookings.manage.index');
    // Route::get('/admin/bookings/create', [RentalManageController::class, 'create'])->name('bookings.manage.create');
    Route::get('/admin/bookings/user-selection', [RentalManageController::class, 'userSelection'])->name('bookings.manage.create.user-selection');
    Route::get('/admin/bookings/create/date-selection', [RentalManageController::class, 'dateSelection'])->name('bookings.manage.create.date-selection');
    Route::get('/admin/bookings/create/vehicle-selection', [RentalManageController::class, 'vehicleSelection'])->name('bookings.manage.create.vehicle-selection');
    Route::get('/admin/bookings/create/complete-booking', [RentalManageController::class, 'completeBooking'])->name('bookings.manage.create.complete-booking');
    Route::post('/admin/bookings/store', [RentalManageController::class, 'store'])->name('bookings.manage.store');
    Route::get('/admin/bookings/{rental}', [RentalManageController::class, 'show'])->name('bookings.manage.show');
    Route::get('/admin/bookings/{rental}/edit', [RentalManageController::class, 'edit'])->name('bookings.manage.edit');
    Route::put('/admin/bookings/{rental}', [RentalManageController::class, 'update'])->name('bookings.manage.update');
    Route::delete('/admin/bookings/{rental}', [RentalManageController::class, 'destroy'])->name('bookings.manage.destroy');

    // Additional route for updating rental status
    Route::patch('/admin/bookings/{rental}/update-status', [RentalManageController::class, 'updateStatus'])->name('bookings.update-status');
});



// Route untuk menampilkan daftar kendaraan
Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles');

Route::get('/vehicles/{vehicle}', [VehicleController::class, 'detail'])->name('vehicles.details');

// Booking routes
Route::middleware(['auth', 'App\Http\Middleware\CustomerMiddleware'])->prefix('booking')->name('booking.')->group(function () {
    Route::get('/', [RentalController::class, 'index'])->name('index'); // /booking
    Route::get('/check-availability', [RentalController::class, 'checkAvailability'])->name('check-availability');
    Route::get('/vehicle/{vehicle}', [RentalController::class, 'rentVehicle'])->name('book-vehicle');
    Route::post('/store', [RentalController::class, 'store'])->name('store');
    Route::get('/confirmation/{rental}', [RentalController::class, 'confirmation'])->name('confirmation');
    Route::patch('/{rental}/cancel', [RentalController::class, 'cancel'])->name('cancel');

    // Payment routes
    Route::get('/payment/{rental}', [RentalController::class, 'showPayment'])->name('payment');
    Route::post('/payment/{rental}/process', [RentalController::class, 'processPayment'])->name('process-payment');

    // Receipt
    Route::get('/{rental}/receipt', [CustomerController::class, 'downloadReceipt'])->name('receipt');
});

// Notification Routes
Route::middleware(['auth', 'App\Http\Middleware\AdminMiddleware'])->prefix('admin/notifications')->name('notifications.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::get('/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('mark-as-read');
    Route::patch('/{notification}/mark-as-read', [NotificationController::class, 'markAsRead']);
    Route::get('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
});

// Customer routes
Route::middleware(['auth', 'verified'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/history', [CustomerController::class, 'history'])->name('history');
    Route::get('/history/{rental}', [CustomerController::class, 'historyDetail'])->name('history-detail');
    Route::patch('/booking/{rental}/cancel', [CustomerController::class, 'cancelBooking'])->name('cancel-booking');
});

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

require __DIR__.'/auth.php';