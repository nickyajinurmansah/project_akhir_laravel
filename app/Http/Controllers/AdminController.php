<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Notifications\BookingStatusChanged;

class AdminController extends Controller
{
    // 1. Tampilkan Semua Booking
    public function index()
    {
        // Pastikan hanya admin yang bisa akses (Manual check untuk keamanan ganda)
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses Ditolak. Halaman ini khusus Admin.');
        }

        // Ambil semua data, urutkan dari yang terbaru
        $bookings = Booking::with(['user', 'service'])->orderBy('created_at', 'desc')->get();

        return view('admin.bookings', compact('bookings'));
    }

    // 2. Konfirmasi Booking (Terima)
    public function approve($id)
    {
        $booking = Booking::with('user')->findOrFail($id); // Load user biar bisa dikirim email
        $booking->update(['status' => 'confirmed']);

        // KIRIM EMAIL KE PEMESAN
        $booking->user->notify(new BookingStatusChanged($booking));

        return redirect()->back()->with('success', 'Booking disetujui & Email terkirim!');
    }

    // 3. Tolak Booking
    public function reject($id)
    {
        $booking = Booking::with('user')->findOrFail($id);
        $booking->update(['status' => 'cancelled']);

        // KIRIM EMAIL KE PEMESAN
        $booking->user->notify(new BookingStatusChanged($booking));

        return redirect()->back()->with('success', 'Booking ditolak & Email terkirim.');
    }
}