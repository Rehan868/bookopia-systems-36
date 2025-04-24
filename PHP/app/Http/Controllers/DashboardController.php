
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mock data for dashboard
        $stats = [
            'occupancyRate' => 85,
            'totalBookings' => 142,
            'revenue' => 28500,
            'availableRooms' => 12
        ];
        
        $recentBookings = [
            [
                'id' => 1,
                'guest_name' => 'John Smith',
                'check_in' => '2025-04-25',
                'check_out' => '2025-04-28',
                'status' => 'confirmed',
                'room' => '101'
            ],
            [
                'id' => 2,
                'guest_name' => 'Sarah Johnson',
                'check_in' => '2025-04-26',
                'check_out' => '2025-04-29',
                'status' => 'pending',
                'room' => '203'
            ]
        ];
        
        return view('dashboard.index', compact('stats', 'recentBookings'));
    }
    
    public function reports()
    {
        return view('dashboard.reports');
    }
}
