
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        // Get filters from request
        $search = $request->input('search');
        $type = $request->input('type');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        
        // Query audit logs with filters
        $auditLogs = DB::table('audit_logs')
            ->when($search, function($query) use ($search) {
                return $query->where('action', 'like', "%{$search}%")
                    ->orWhere('user_email', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%");
            })
            ->when($type, function($query) use ($type) {
                return $query->where('type', $type);
            })
            ->when($dateFrom, function($query) use ($dateFrom) {
                return $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function($query) use ($dateTo) {
                return $query->whereDate('created_at', '<=', $dateTo);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        // Get distinct log types for filter dropdown
        $logTypes = DB::table('audit_logs')
            ->select('type')
            ->distinct()
            ->pluck('type');
            
        return view('pages.staff.audit.index', compact('auditLogs', 'logTypes'));
    }
    
    public function export(Request $request)
    {
        // Get filters from request
        $search = $request->input('search');
        $type = $request->input('type');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        
        // Query audit logs with filters
        $auditLogs = DB::table('audit_logs')
            ->when($search, function($query) use ($search) {
                return $query->where('action', 'like', "%{$search}%")
                    ->orWhere('user_email', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%");
            })
            ->when($type, function($query) use ($type) {
                return $query->where('type', $type);
            })
            ->when($dateFrom, function($query) use ($dateFrom) {
                return $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function($query) use ($dateTo) {
                return $query->whereDate('created_at', '<=', $dateTo);
            })
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Generate CSV file
        $filename = 'audit_logs_' . Carbon::now()->format('Y-m-d') . '.csv';
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($auditLogs) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, ['ID', 'Type', 'User', 'Action', 'IP Address', 'Details', 'Timestamp']);
            
            // Add rows
            foreach ($auditLogs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->type,
                    $log->user_email,
                    $log->action,
                    $log->ip_address,
                    $log->details,
                    $log->created_at
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
