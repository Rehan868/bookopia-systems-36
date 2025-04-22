
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'booking_number',
        'guest_name',
        'guest_email',
        'guest_phone',
        'room_id',
        'check_in',
        'check_out',
        'adults',
        'children',
        'base_rate',
        'total_amount',
        'status',
        'payment_status',
        'notes',
    ];
    
    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'adults' => 'integer',
        'children' => 'integer',
        'base_rate' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];
    
    /**
     * Get the room associated with this booking
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    
    /**
     * Get the number of nights for this booking
     */
    public function getNightsAttribute()
    {
        return $this->check_in->diffInDays($this->check_out);
    }
    
    /**
     * Get formatted total amount
     */
    public function getFormattedTotalAttribute()
    {
        return '$' . number_format($this->total_amount, 2);
    }
    
    /**
     * Get today's check-ins
     */
    public static function getTodayCheckIns()
    {
        return self::where('check_in', Carbon::today()->format('Y-m-d'))
            ->where('status', 'confirmed')
            ->with('room')
            ->get();
    }
    
    /**
     * Get today's check-outs
     */
    public static function getTodayCheckOuts()
    {
        return self::where('check_out', Carbon::today()->format('Y-m-d'))
            ->where('status', 'checked-in')
            ->with('room')
            ->get();
    }
    
    /**
     * Get status badge class
     */
    public function getStatusBadgeClass()
    {
        switch($this->status) {
            case 'confirmed':
                return 'bg-green-100 text-green-800';
            case 'checked-in':
                return 'bg-blue-100 text-blue-800';
            case 'checked-out':
                return 'bg-purple-100 text-purple-800';
            case 'cancelled':
                return 'bg-red-100 text-red-800';
            case 'pending':
                return 'bg-yellow-100 text-yellow-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }
}
