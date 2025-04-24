
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        // Mock data for bookings
        $bookings = [
            [
                'id' => 1,
                'reference' => 'BK-2023-0001',
                'guest_name' => 'John Smith',
                'guest_email' => 'john.smith@example.com',
                'check_in' => '2023-04-25',
                'check_out' => '2023-04-28',
                'status' => 'confirmed',
                'room' => '101',
                'total_amount' => 450,
            ],
            [
                'id' => 2,
                'reference' => 'BK-2023-0002',
                'guest_name' => 'Sarah Johnson',
                'guest_email' => 'sarah.johnson@example.com',
                'check_in' => '2023-04-26',
                'check_out' => '2023-04-29',
                'status' => 'pending',
                'room' => '203',
                'total_amount' => 560,
            ],
            [
                'id' => 3,
                'reference' => 'BK-2023-0003',
                'guest_name' => 'Michael Brown',
                'guest_email' => 'michael.brown@example.com',
                'check_in' => '2023-04-27',
                'check_out' => '2023-04-30',
                'status' => 'confirmed',
                'room' => '305',
                'total_amount' => 620,
            ],
            [
                'id' => 4,
                'reference' => 'BK-2023-0004',
                'guest_name' => 'Emily Davis',
                'guest_email' => 'emily.davis@example.com',
                'check_in' => '2023-04-28',
                'check_out' => '2023-05-01',
                'status' => 'cancelled',
                'room' => '102',
                'total_amount' => 380,
            ]
        ];
        
        return view('bookings.index', compact('bookings'));
    }
    
    public function create()
    {
        return view('bookings.create');
    }
    
    public function store(Request $request)
    {
        // Validate and store the booking
        
        return redirect()->route('bookings.index')->with('success', 'Booking created successfully');
    }
    
    public function show($id)
    {
        // Mock data for a booking
        $booking = [
            'id' => $id,
            'reference' => 'BK-2023-' . str_pad($id, 4, '0', STR_PAD_LEFT),
            'guest_name' => 'John Smith',
            'guest_email' => 'john.smith@example.com',
            'guest_phone' => '+1 (555) 123-4567',
            'check_in' => '2023-04-25',
            'check_out' => '2023-04-28',
            'adults' => 2,
            'children' => 1,
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'room' => '101',
            'room_type' => 'Deluxe King',
            'total_amount' => 450,
            'notes' => 'Guest requested extra pillows and a late checkout.',
            'created_at' => '2023-04-20 14:30:00',
            'updated_at' => '2023-04-20 16:45:00',
        ];
        
        return view('bookings.show', compact('booking'));
    }
    
    public function edit($id)
    {
        // Mock data for a booking
        $booking = [
            'id' => $id,
            'reference' => 'BK-2023-' . str_pad($id, 4, '0', STR_PAD_LEFT),
            'guest_name' => 'John Smith',
            'guest_email' => 'john.smith@example.com',
            'guest_phone' => '+1 (555) 123-4567',
            'check_in' => '2023-04-25',
            'check_out' => '2023-04-28',
            'adults' => 2,
            'children' => 1,
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'room' => '101',
            'room_type' => 'Deluxe King',
            'total_amount' => 450,
            'notes' => 'Guest requested extra pillows and a late checkout.',
        ];
        
        return view('bookings.edit', compact('booking'));
    }
    
    public function update(Request $request, $id)
    {
        // Validate and update the booking
        
        return redirect()->route('bookings.show', $id)->with('success', 'Booking updated successfully');
    }
    
    public function destroy($id)
    {
        // Delete the booking
        
        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully');
    }
}
