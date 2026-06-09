<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AnalyticsData extends Model
{
    use HasFactory;

    protected $table = 'analytics_data';
    protected $fillable = ['session_id', 'browser', 'page_url', 'ip_address', 'created_at'];

    public static function getRecords(Request $request){
        $filter = $request->input('filter', 'All');
        [$startDate, $endDate] = self::getDateRange($filter);
        $query = self::query();
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        $viewsCount = (clone $query)->count();
        $workSessions = (clone $query)->distinct('session_id')->count('session_id');
        $visitors = $workSessions;
        $pageviews = $viewsCount;
        $bounceRate = self::calculateBounceRate($startDate, $endDate);
        
        // Top Browsers and Pages within the date range
        $topBrowsersQuery = self::select('browser', DB::raw('count(*) as count'));
        $mostVisitedPagesQuery = self::select('page_url', DB::raw('count(*) as pageviews'));
        
        if ($startDate && $endDate) {
            $topBrowsersQuery->whereBetween('created_at', [$startDate, $endDate]);
            $mostVisitedPagesQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        $topBrowsers = $topBrowsersQuery->groupBy('browser')->orderByDesc('count')->take(5)->get();
        $mostVisitedPages = $mostVisitedPagesQuery->groupBy('page_url')->orderByDesc('pageviews')->take(5)->get();

        $totalSessionsQuery = self::distinct('session_id');
        if ($startDate && $endDate) {
            $totalSessionsQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
        $totalSessions = $totalSessionsQuery->count('session_id');

    
        $timeSeries = self::getTimeSeriesData($startDate, $endDate, $filter);

        return [
            'viewsCount' => $viewsCount,
            'workSessions' => $workSessions,
            'visitors' => $visitors,
            'pageviews' => $pageviews,
            'bounceRate' => $bounceRate,
            'topBrowsers' => $topBrowsers,
            'mostVisitedPages' => $mostVisitedPages,
            'totalSessions' => $totalSessions,
            'hourlyViews' => $timeSeries['data'],
            'chartLabels' => $timeSeries['labels'],
        ];
    }

    protected static function getDateRange($filter){
        $now = Carbon::now();
        switch ($filter) {
            case 'Today': return [$now->copy()->startOfDay(), $now->copy()->endOfDay()];
            case 'Yesterday': return [$now->copy()->subDay()->startOfDay(), $now->copy()->subDay()->endOfDay()];
            case 'This Week': return [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()];
            case 'Last 7 Days': return [$now->copy()->subDays(7)->startOfDay(), $now->copy()->endOfDay()];
            case 'This Month': return [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()];
            case 'Last 30 Days': return [$now->copy()->subDays(30)->startOfDay(), $now->copy()->endOfDay()];
            case 'This Year': return [$now->copy()->startOfYear(), $now->copy()->endOfYear()];
            default: return [null, null]; // 'All'
        }
    }

    // OPTIMIZED: Replaces 24 separate queries with a single grouped query
    public static function getTimeSeriesData($startDate, $endDate, $filter){
        $labels = [];
        $data = [];
        $isHourly = in_array($filter, ['Today', 'Yesterday']);
        $format = $isHourly ? '%H:00' : '%Y-%m-%d';
        
        $query = self::select(
                DB::raw("DATE_FORMAT(created_at, '{$format}') as date_label"),
                DB::raw('count(*) as count')
            );

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $results = $query->groupBy('date_label')->orderBy('date_label')->pluck('count', 'date_label')->toArray();

        if ($isHourly) {
            for ($i = 0; $i < 24; $i++) {
                $label = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
                $labels[] = $label;
                $data[] = $results[$label] ?? 0;
            }
        } else {
            $start = $startDate ? $startDate->copy() : Carbon::now()->subDays(30);
            $end = $endDate ? $endDate->copy() : Carbon::now();
            
       
            if (!$startDate) {
                $start = Carbon::now()->subDays(30);
            }

            while ($start->lte($end)) {
                $label = $start->format('Y-m-d');
                $labels[] = $start->format('M d'); 
                $data[] = $results[$label] ?? 0;
                $start->addDay();
            }
        }

        return ['labels' => $labels, 'data' => $data];
    }

    public static function calculateBounceRate($startDate = null, $endDate = null){
        $query = self::select('session_id')->groupBy('session_id')->havingRaw('count(*) = 1'); 
            
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        
        $bounceSessions = $query->count();
        
        $totalQuery = self::distinct('session_id');
        if ($startDate && $endDate) {
            $totalQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
        $totalSessions = $totalQuery->count('session_id');
        
        return ($totalSessions > 0) ? round(($bounceSessions / $totalSessions) * 100, 2) : 0;
    }
}