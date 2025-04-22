
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Property;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::query()->with(['room', 'room.property']);
        
        // Apply filters
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('guest_name', 'like', "%{$search}%")
                  ->orWhere('booking_number', 'like', "%{$search}%")
                  ->orWhere('guest_email', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('status') && $request->get('status') !== 'all') {
            $query->where('status', $request->get('status'));
        }
        
        if ($request->has('date_from') && $request->has('date_to')) {
            $query->whereBetween('check_in', [
                Carbon::parse($request->get('date_from')),
                Carbon::parse($request->get('date_to'))
            ]);
        }
        
        $bookings = $query->orderBy('check_in', 'desc')->paginate(10);
        
        return view('pages.bookings.index', [
            'bookings' => $bookings,
            'filters' => $request->all()
        ]);
    }
    
    public function create()
    {
        $properties = Property::all();
        $rooms = Room::where('status', 'available')->get();
        
        return view('pages.bookings.create', [
            'properties' => $properties,
            'rooms' => $rooms,
            'booking' => new Booking()
        ]);
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
        
        // Generate booking number
        $validated['booking_number'] = 'BK-' . date('Y') . '-' . mt_rand(1000, 9999);
        
        // Calculate total amount
        $checkIn = Carbon::parse($validated['check_in']);
        $checkOut = Carbon::parse($validated['check_out']);
        $nights = $checkOut->diffInDays($checkIn);
        $validated['total_amount'] = $validated['base_rate'] * $nights;
        
        $booking = Booking::create($validated);
        
        // Update room status
        Room::find($validated['room_id'])->update(['status' => 'booked']);
        
        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking created successfully.');
    }
    
    public function show(Booking $booking)
    {
        $booking->load(['room', 'room.property']);
        
        return view('pages.bookings.show', [
            'booking' => $booking
        ]);
    }
    
    public function edit(Booking $booking)
    {
        $properties = Property::all();
        $rooms = Room::where('status', 'available')
            ->orWhere('id', $booking->room_id)
            ->get();
            
        return view('pages.bookings.edit', [
            'booking' => $booking,
            'properties' => $properties,
            'rooms' => $rooms
        ]);
    }
    
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            // Same validation as store() method
        ]);
        
        // Handle room changes
        if ($booking->room_id != $validated['room_id']) {
            // Free up the old room
            Room::find($booking->room_id)->update(['status' => 'available']);
            
            // Mark the new room as booked
            Room::find($validated['room_id'])->update(['status' => 'booked']);
        }
        
        // Calculate total amount
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
