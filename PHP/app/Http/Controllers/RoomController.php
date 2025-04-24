
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        // Mock data for rooms
        $rooms = [
            [
                'id' => 1,
                'number' => '101',
                'type' => 'Deluxe King',
                'status' => 'available',
                'price' => 180,
                'occupancy' => 2,
                'maintenance_status' => 'clean',
                'description' => 'Spacious room with ocean view',
                'last_cleaned' => '2025-04-23'
            ],
            [
                'id' => 2,
                'number' => '102',
                'type' => 'Double Queen',
                'status' => 'occupied',
                'price' => 220,
                'occupancy' => 4,
                'maintenance_status' => 'clean',
                'description' => 'Perfect for families',
                'last_cleaned' => '2025-04-23'
            ],
            [
                'id' => 3,
                'number' => '201',
                'type' => 'Suite',
                'status' => 'maintenance',
                'price' => 350,
                'occupancy' => 3,
                'maintenance_status' => 'maintenance',
                'description' => 'Luxury suite with separate living area',
                'last_cleaned' => '2025-04-22'
            ]
        ];
        
        return view('rooms.index', compact('rooms'));
    }

    public function availability()
    {
        $rooms = [
            [
                'number' => '101',
                'type' => 'Deluxe King',
                'status' => 'available',
                'upcoming_bookings' => [
                    ['check_in' => '2025-05-01', 'check_out' => '2025-05-03'],
                    ['check_in' => '2025-05-10', 'check_out' => '2025-05-15']
                ]
            ],
            [
                'number' => '102',
                'type' => 'Double Queen',
                'status' => 'occupied',
                'upcoming_bookings' => [
                    ['check_in' => '2025-04-20', 'check_out' => '2025-04-25'],
                    ['check_in' => '2025-05-01', 'check_out' => '2025-05-05']
                ]
            ]
        ];
        
        return view('rooms.availability', compact('rooms'));
    }

    public function cleaningStatus()
    {
        $rooms = [
            [
                'number' => '101',
                'type' => 'Deluxe King',
                'status' => 'clean',
                'last_cleaned' => '2025-04-23',
                'next_checkout' => '2025-04-25',
                'assigned_to' => 'Maria Garcia'
            ],
            [
                'number' => '102',
                'type' => 'Double Queen',
                'status' => 'needs_cleaning',
                'last_cleaned' => '2025-04-21',
                'next_checkout' => '2025-04-24',
                'assigned_to' => 'John Smith'
            ]
        ];
        
        return view('rooms.cleaning', compact('rooms'));
    }
}
