
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Models\User;
use App\Models\Property;
use Carbon\Carbon;

class StaffController extends Controller
{
    public function dashboard()
    {
        // Get dashboard statistics
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        
        $todayCheckIns = Booking::where('check_in', Carbon::today())
            ->where('status', 'confirmed')
            ->count();
            
        $todayCheckOuts = Booking::where('check_out', Carbon::today())
            ->where('status', 'checked-in')
            ->count();
            
        $occupancyRate = $totalRooms > 0 
            ? round(($occupiedRooms / $totalRooms) * 100) 
            : 0;
            
        $recentBookings = Booking::with(['room', 'room.property'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        $todayActivities = Booking::whereDate('check_in', Carbon::today())
            ->orWhereDate('check_out', Carbon::today())
            ->with(['room', 'room.property'])
            ->orderBy('check_in')
            ->get();
        
        return view('pages.staff.dashboard', compact(
            'totalRooms',
            'availableRooms',
            'occupiedRooms',
            'todayCheckIns',
            'todayCheckOuts',
            'occupancyRate',
            'recentBookings',
            'todayActivities'
        ));
    }
}
