<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\SiteHealthService;
use Illuminate\View\View;

class SiteHealthController extends BaseController
{
    public function __construct(private readonly SiteHealthService $siteHealthService) {}

    public function index(): View
    {
        return view('admin.settings.site_health', [
            'serverInfo'       => $this->siteHealthService->getServerInfo(),
            'directories'      => $this->siteHealthService->getDirectorySizes(),
            'siteHealthStatus' => $this->siteHealthService->getSiteHealthStatus(),
            'diskChartData'    => $this->siteHealthService->getDiskSpaceChartData(),
        ]);
    }
}