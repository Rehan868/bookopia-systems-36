<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Property;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Calculate statistics for dashboard
        $today = Carbon::today();
        
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        
        $todayCheckIns = Booking::where('check_in', $today->format('Y-m-d'))
            ->where('status', 'confirmed')
            ->count();
            
        $todayCheckOuts = Booking::where('check_out', $today->format('Y-m-d'))
            ->where('status', 'checked-in')
            ->count();
            
        $occupancyRate = $totalRooms > 0 
            ? round((($totalRooms - $availableRooms) / $totalRooms) * 100) 
            : 0;
            
        // Mock data for charts - would be real data in production
        $occupancyData = [
            ['name' => 'Jan', 'occupancy' => 65, 'revenue' => 4000],
            ['name' => 'Feb', 'occupancy' => 72, 'revenue' => 4500],
            ['name' => 'Mar', 'occupancy' => 80, 'revenue' => 5000],
            ['name' => 'Apr', 'occupancy' => 75, 'revenue' => 4800],
            ['name' => 'May', 'occupancy' => 85, 'revenue' => 5500],
            ['name' => 'Jun', 'occupancy' => 90, 'revenue' => 6000],
            ['name' => 'Jul', 'occupancy' => 95, 'revenue' => 6500],
            ['name' => 'Aug', 'occupancy' => 88, 'revenue' => 6200],
            ['name' => 'Sep', 'occupancy' => 82, 'revenue' => 5800],
            ['name' => 'Oct', 'occupancy' => 78, 'revenue' => 5200],
            ['name' => 'Nov', 'occupancy' => 70, 'revenue' => 4800],
            ['name' => 'Dec', 'occupancy' => 75, 'revenue' => 5000],
        ];
        
        $recentBookings = Booking::with('room')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
            
        $todayActivities = Booking::whereDate('check_in', $today)
            ->orWhereDate('check_out', $today)
            ->with('room')
            ->orderBy('check_in')
            ->get();
        
        return view('pages.dashboard', [
            'availableRooms' => $availableRooms,
            'totalRooms' => $totalRooms,
            'todayCheckIns' => $todayCheckIns,
            'todayCheckOuts' => $todayCheckOuts,
            'occupancyRate' => $occupancyRate,
            'occupancyData' => json_encode($occupancyData),
            'recentBookings' => $recentBookings,
            'todayActivities' => $todayActivities,
        ]);
    }
    
    public function ownerDashboard()
    {
        // Similar to the staff dashboard but filtered for the owner's properties
        $ownerId = auth()->id();
        
        $properties = Property::where('owner_id', $ownerId)->pluck('id');
        $rooms = Room::whereIn('property_id', $properties);
        
        $totalRooms = $rooms->count();
        $availableRooms = $rooms->where('status', 'available')->count();
        
        // Rest of the code similar to above but filtered by owner's properties
        
        return view('pages.owner.dashboard', [
            // Pass data to view
        ]);
    }
}
