<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Models\Booking;
use App\Models\User;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    $userId = auth()->id();

    if ($role === 'admin') {
        // === DATA UNTUK ADMIN ===
        // Hitung semua data di database
        $data = [
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
            // Hitung estimasi pendapatan dari booking yang sudah confirmed
            'income' => Booking::where('status', 'confirmed')
                ->with('service')
                ->get()
                ->sum(function ($booking) {
                    return $booking->service->price;
                }),
            'total_users' => User::where('role', 'user')->count(),
        ];
    } else {
        // === DATA UNTUK USER BIASA ===
        // Hitung data milik user itu sendiri saja
        $data = [
            'my_total' => Booking::where('user_id', $userId)->count(),
            'my_pending' => Booking::where('user_id', $userId)->where('status', 'pending')->count(),
            'my_confirmed' => Booking::where('user_id', $userId)->where('status', 'confirmed')->count(),
        ];
    }

    // Kirim variabel $data ke view dashboard
    return view('dashboard', compact('data'));

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route Kalender & Simpan (Yang sudah ada)
    Route::get('/calendar', [BookingController::class, 'calendar'])->name('calendar.index'); // Saya ganti method jadi 'calendar' sesuai yang lama
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

    // --- TAMBAHAN BARU ---
    // Halaman List Booking Saya
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('booking.index');
    // Proses Upload
    Route::patch('/booking/{id}/upload', [BookingController::class, 'uploadProof'])->name('booking.upload');
});
Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::get('/bookings', [AdminController::class, 'index'])->name('admin.bookings');
    Route::patch('/booking/{id}/approve', [AdminController::class, 'approve'])->name('admin.approve');
    Route::patch('/booking/{id}/reject', [AdminController::class, 'reject'])->name('admin.reject');

});

require __DIR__ . '/auth.php';
