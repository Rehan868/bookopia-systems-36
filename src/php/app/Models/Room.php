
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'number',
        'property_id',
        'type',
        'status',
        'max_occupancy',
        'base_rate',
        'description',
        'amenities',
        'last_cleaned',
        'next_maintenance',
    ];
    
    protected $casts = [
        'amenities' => 'array',
        'base_rate' => 'decimal:2',
        'last_cleaned' => 'datetime',
        'next_maintenance' => 'datetime',
    ];
    
    /**
     * Get the property this room belongs to
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
    
    /**
     * Get the bookings for this room
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    
    /**
     * Get the current booking for this room
     */
    public function currentBooking()
    {
        return $this->bookings()
            ->where('check_in', '<=', now())
            ->where('check_out', '>=', now())
            ->where('status', 'checked-in')
            ->first();
    }
    
    /**
     * Check if room is available for a date range
     */
    public function isAvailable($checkIn, $checkOut)
    {
        return $this->bookings()
            ->where(function($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out', [$checkIn, $checkOut])
                    ->orWhere(function($q) use ($checkIn, $checkOut) {
                        $q->where('check_in', '<=', $checkIn)
                          ->where('check_out', '>=', $checkOut);
                    });
            })
            ->where('status', '!=', 'cancelled')
            ->count() === 0;
    }
    
    /**
     * Get status color class
     */
    public function getStatusColorClass()
    {
        switch($this->status) {
            case 'available':
                return 'bg-green-100 text-green-800';
            case 'booked':
                return 'bg-blue-100 text-blue-800';
            case 'occupied':
                return 'bg-blue-100 text-blue-800';
            case 'needs-cleaning':
                return 'bg-yellow-100 text-yellow-800';
            case 'maintenance':
                return 'bg-red-100 text-red-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }
}
