<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Booking::count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'todayCheckIns' => Booking::whereDate('check_in', Carbon::today())->count()
        ];

        $bookings = Booking::with(['room', 'room.property'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.staff.bookings.index', compact('stats', 'bookings'));
    }

    public function create()
    {
        $rooms = Room::with('property')->where('status', 'available')->get();
        return view('pages.staff.bookings.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:20',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'adults' => 'required|integer|min:1',
            'children' => 'required|integer|min:0',
            'base_rate' => 'required|numeric|min:0',
            'status' => 'required|string|in:confirmed,pending,checked-in,checked-out,cancelled',
            'payment_status' => 'required|string|in:paid,pending,partial,refunded',
            'notes' => 'nullable|string',
        ]);

        $validated['booking_number'] = 'BK-' . date('Y') . '-' . mt_rand(1000, 9999);

        $checkIn = Carbon::parse($validated['check_in']);
        $checkOut = Carbon::parse($validated['check_out']);
        $nights = $checkOut->diffInDays($checkIn);
        $validated['total_amount'] = $validated['base_rate'] * $nights;

        $booking = Booking::create($validated);

        Room::find($validated['room_id'])->update(['status' => 'booked']);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking created successfully.');
    }

    public function show(Booking $booking)
    {
        $booking->load(['room', 'room.property']);
        return view('pages.staff.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $rooms = Room::with('property')
            ->where('status', 'available')
            ->orWhere('id', $booking->room_id)
            ->get();

        return view('pages.staff.bookings.edit', compact('booking', 'rooms'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:20',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'adults' => 'required|integer|min:1',
            'children' => 'required|integer|min:0',
            'base_rate' => 'required|numeric|min:0',
            'status' => 'required|string|in:confirmed,pending,checked-in,checked-out,cancelled',
            'payment_status' => 'required|string|in:paid,pending,partial,refunded',
            'notes' => 'nullable|string',
        ]);

        if ($booking->room_id != $validated['room_id']) {
            Room::find($booking->room_id)->update(['status' => 'available']);
            Room::find($validated['room_id'])->update(['status' => 'booked']);
        }

        $checkIn = Carbon::parse($validated['check_in']);
        $checkOut = Carbon::parse($validated['check_out']);
        $nights = $checkOut->diffInDays($checkIn);
        $validated['total_amount'] = $validated['base_rate'] * $nights;

        $booking->update($validated);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking updated successfully.');
    }

    public function checkIn(Booking $booking)
    {
        if ($booking->status !== 'confirmed') {
            return back()->with('error', 'Only confirmed bookings can be checked in.');
        }

        $booking->update(['status' => 'checked-in']);
        $booking->room->update(['status' => 'occupied']);

        return back()->with('success', 'Guest checked in successfully.');
    }

    public function checkOut(Booking $booking)
    {
        if ($booking->status !== 'checked-in') {
            return back()->with('error', 'Only checked-in bookings can be checked out.');
        }

        $booking->update(['status' => 'checked-out']);
        $booking->room->update(['status' => 'needs-cleaning']);

        return back()->with('success', 'Guest checked out successfully.');
    }

    public function cancel(Booking $booking)
    {
        if (!in_array($booking->status, ['confirmed', 'pending'])) {
            return back()->with('error', 'Only confirmed or pending bookings can be cancelled.');
        }

        $booking->update(['status' => 'cancelled']);
        $booking->room->update(['status' => 'available']);

        return back()->with('success', 'Booking cancelled successfully.');
    }
}
