
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StaffAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isStaff()) {
            return redirect()->route('login')->with('error', 'Access denied. Staff only area.');
        }

        return $next($request);
    }
}
