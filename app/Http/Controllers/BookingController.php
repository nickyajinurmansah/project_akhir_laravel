<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Notifications\BookingStatusChanged;

class BookingController extends Controller
{
    // === 1. FITUR KALENDER ===
    // Pastikan nama function ini 'calendar'
    public function calendar()
    {
        $bookings = Booking::with('service', 'user')
            ->where('status', '!=', 'cancelled')
            ->get();

        $events = [];
        foreach ($bookings as $booking) {
            $events[] = [
                'title' => $booking->service->name . ' (' . $booking->user->name . ')',
                'start' => $booking->start_date,
                'end' => $booking->end_date,
                'color' => $booking->status == 'confirmed' ? '#10b981' : '#3788d8',
            ];
        }

        return view('bookings.calendar', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'service_id' => $request->service_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'pending'
        ]);
        
        auth()->user()->notify(new BookingStatusChanged($booking));

        return redirect()->back()->with('success', 'Berhasil Booking!');
    }

    // === 2. FITUR LIST BOOKING SAYA ===
    // GANTI NAMA: Dari 'myBookings' MENJADI 'index'
    // Karena route biasanya mencari 'index' secara default
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with('service')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    // === 3. FITUR UPLOAD ===
    public function uploadProof(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $booking = Booking::findOrFail($id);

        if ($booking->user_id != auth()->id()) {
            abort(403);
        }

        $path = $request->file('payment_proof')->store('payments', 'public');

        $booking->update([
            'payment_proof' => $path,
        ]);

        return redirect()->back()->with('success', 'Upload Berhasil!');
    }
}