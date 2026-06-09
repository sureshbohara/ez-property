<?php

namespace App\Http\Controllers\Admin;

use App\Models\AnalyticsData;
use App\Models\Service;
use App\Models\Fleet;
use App\Models\Review;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{


    public function dashboard(Request $request){
        $analyticsData = AnalyticsData::getRecords($request);
        $stats = [
            'services_count' => Service::count(),
            'services_active' => Service::where('status', true)->count(),
            'fleets_count' => Fleet::count(),
            'fleets_active' => Fleet::where('status', true)->count(),
            'reviews_count' => Review::count(), 
            'server' => $this->getServerStats(),
        ];
        return view('admin.dashboard', [
            'viewsCount' => $analyticsData['viewsCount'] ?? 0,
            'workSessions' => $analyticsData['workSessions'] ?? 0,
            'visitors' => $analyticsData['visitors'] ?? 0,
            'pageviews' => $analyticsData['pageviews'] ?? 0,
            'bounceRate' => $analyticsData['bounceRate'] ?? 0,
            'topBrowsers' => $analyticsData['topBrowsers'] ?? [],
            'mostVisitedPages' => $analyticsData['mostVisitedPages'] ?? [],
            'totalSessions' => $analyticsData['totalSessions'] ?? 0,
            'hourlyViews' => $analyticsData['hourlyViews'] ?? [],
            'chartLabels' => $analyticsData['chartLabels'] ?? [],
            'stats' => $stats,
        ]);
    }

    protected function getServerStats(){
        $path = base_path();
        $total = @disk_total_space($path);
        $free = @disk_free_space($path);
        
        if ($total === false || $free === false || $total == 0) {
            return ['used_percent' => 0, 'used_gb' => 0, 'total_gb' => 0];
        }

        $used = $total - $free;
        $totalGb = round($total / (1024 * 1024 * 1024), 2);
        $usedGb = round($used / (1024 * 1024 * 1024), 2);
        $percent = round(($used / $total) * 100, 2);

        return [
            'used_percent' => $percent,
            'used_gb' => $usedGb,
            'total_gb' => $totalGb,
        ];
    }
}