<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Property;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $revenueData = $this->getRevenueData();
        $occupancyData = $this->getOccupancyData();
        $bookingSources = $this->getBookingSources();
        $cleaningStatus = $this->getCleaningStatus();

        return view('pages.staff.reports.index', compact(
            'revenueData',
            'occupancyData',
            'bookingSources',
            'cleaningStatus'
        ));
    }

    private function getRevenueData()
    {
        // Implementation for revenue data
        return Booking::selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getOccupancyData()
    {
        // Implementation for occupancy data
        return Room::selectRaw('DATE(updated_at) as date, COUNT(*) as total, SUM(CASE WHEN status = "occupied" THEN 1 ELSE 0 END) as occupied')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getBookingSources()
    {
        // Implementation for booking sources data
        return Booking::selectRaw('source, COUNT(*) as count')
            ->groupBy('source')
            ->get();
    }

    private function getCleaningStatus()
    {
        // Implementation for cleaning status data
        return Room::selectRaw('cleaning_status, COUNT(*) as count')
            ->groupBy('cleaning_status')
            ->get();
    }
}
