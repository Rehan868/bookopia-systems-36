
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use Carbon\Carbon;

class CleaningController extends Controller
{
    public function index()
    {
        $rooms = Room::with('property')
            ->orderBy('status')
            ->get();
            
        return view('pages.cleaning.index', [
            'rooms' => $rooms
        ]);
    }
    
    public function markClean(Room $room)
    {
        $room->update([
            'status' => 'available',
            'last_cleaned' => now()
        ]);
        
        return back()->with('success', 'Room marked as clean.');
    }
    
    public function startCleaning(Room $room)
    {
        $room->update([
            'status' => 'cleaning'
        ]);
        
        return back()->with('success', 'Room cleaning started.');
    }
    
    public function markDirty(Room $room)
    {
        $room->update([
            'status' => 'needs-cleaning'
        ]);
        
        return back()->with('success', 'Room marked as needs cleaning.');
    }
    
    public function ownerIndex()
    {
        $ownerId = auth()->id();
        $rooms = Room::whereHas('property', function($query) use ($ownerId) {
            $query->where('owner_id', $ownerId);
        })->with('property')->orderBy('status')->get();
        
        return view('pages.owner.cleaning', [
            'rooms' => $rooms
        ]);
    }
}
