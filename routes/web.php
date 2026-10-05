<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ComplaintController;

/*
|--------------------------------------------------------------------------
| Web Routes - KosHub Fullstack Application
|--------------------------------------------------------------------------
*/

// --- 1. Rute Publik (Marketplace Pencarian Kos) ---
Route::get('/', [PropertyController::class, 'index'])->name('home');
Route::get('/kos/{property:slug}', [PropertyController::class, 'show'])->name('properties.show');

// --- 2. Rute Dashboard Terautentikasi ---
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// --- 3. Rute Pengguna Terautentikasi (Auth Group) ---
Route::middleware(['auth', 'verified'])->group(function () {

    // Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Manajemen Properti Kos (Khusus Landlord)
    Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
    Route::put('/properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');

    // Manajemen Unit Kamar (Khusus Landlord)
    Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

    // Laporan Keuangan & Sewa (Khusus Landlord)
    Route::get('/landlord/reports', [PaymentController::class, 'landlordReports'])->name('landlord.reports');

    // Pemesanan Unit Kamar (Booking - Khusus Tenant)
    Route::get('/rooms/{room}/book', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/rooms/{room}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-rentals', [BookingController::class, 'myRentals'])->name('rentals.index');

    // Tagihan & Pembayaran (Tenant & Landlord)
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{payment}/pay', [PaymentController::class, 'pay'])->name('payments.pay');

    // Pengaduan Fasilitas (Tenant & Landlord)
    Route::get('/complaints', function () {
        return redirect()->route('dashboard');
    });
    Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
    Route::patch('/complaints/{complaint}/status', [ComplaintController::class, 'updateStatus'])->name('complaints.updateStatus');
});

require __DIR__.'/auth.php';
