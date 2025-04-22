
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'amount',
        'date',
        'property_id',
        'category',
        'payment_method',
        'vendor',
        'notes',
        'receipt_path',
        'user_id',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getMonthlyTotal($year = null, $month = null)
    {
        if (!$year) {
            $year = now()->year;
        }
        
        if (!$month) {
            $month = now()->month;
        }
        
        return self::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->sum('amount');
    }
    
    public static function getYearlyTotal($year = null)
    {
        if (!$year) {
            $year = now()->year;
        }
        
        return self::whereYear('date', $year)
            ->sum('amount');
    }
    
    public static function getCategoryTotals($year = null)
    {
        if (!$year) {
            $year = now()->year;
        }
        
        return self::selectRaw('category, sum(amount) as total')
            ->whereYear('date', $year)
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();
    }
    
    public static function getRecentExpenses($limit = 5)
    {
        return self::with('property')
            ->orderByDesc('date')
            ->limit($limit)
            ->get();
    }
}
