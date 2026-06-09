<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AnalyticsData;
use Illuminate\Support\Facades\Session;

class TrackAnalytics
{
    public function handle(Request $request, Closure $next)
    {
    
        if ($request->is('admin/*') || $request->is('api/*') || $request->ajax() || $request->wantsJson()) {
            return $next($request);
        }

        $sessionId = Session::getId();
        $userAgent = $request->header('User-Agent');
        $pageUrl = $request->fullUrl(); 
        $ipAddress = $request->ip() ?? '127.0.0.1';

    
        if ($request->isMethod('GET') && $sessionId) {
            AnalyticsData::create([
                'page_url' => $pageUrl,
                'browser'  => $userAgent,
                'session_id' => $sessionId,
                'ip_address' => $ipAddress
            ]);
        }

        return $next($request);
    }
}