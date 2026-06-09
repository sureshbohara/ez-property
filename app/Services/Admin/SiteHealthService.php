<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SiteHealthService
{
    public function getServerInfo()
    {
        return Cache::remember('server_info', now()->addHours(24), function () {
            return [
                'PHP Version'               => phpversion(),
                'Server Architecture'       => php_uname('m'),
                'Web Server'                => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
                'PHP SAPI'                  => php_sapi_name(),
                'PHP Max Input Variables'   => ini_get('max_input_vars'),
                'PHP Time Limit'            => ini_get('max_execution_time'),
                'PHP Memory Limit'          => ini_get('memory_limit'),
                'PHP Upload Max Filesize'   => ini_get('upload_max_filesize'),
                'PHP Post Max Size'         => ini_get('post_max_size'),
                'MySQL Version'             => $this->getMySQLVersion(),
                'Database Charset'          => 'utf8mb4',
                'Database Collation'        => 'utf8mb4_unicode_520_ci',
                'Server Timezone'           => date_default_timezone_get(),
                'Current Server Time'       => now()->toDateTimeString(),
                'Site URL'                  => config('app.url'),
                'Is HTTPS Enabled'          => $this->isHttpsEnabled(),
                'Is Multisite'              => 'No',
            ];
        });
    }

    public function getDirectorySizes()
    {
        return Cache::get('directory_sizes', [
            'public'  => 'Calculating...',
            'storage' => 'Calculating...',
            'uploads' => 'Calculating...',
        ]);
    }

    public function getSiteHealthStatus()
    {
        $cacheStatus = 'No';
        try {
            Cache::put('health_check_test', 'ok', 10);
            Cache::forget('health_check_test');
            $cacheStatus = 'Yes';
        } catch (\Exception $e) {
            $cacheStatus = 'Error';
        }

        return [
            'Site is online'             => 'Yes',
            'Cache Enabled'              => $cacheStatus,
            'Disk Space Usage'           => $this->getDiskSpace(),
            'Required PHP Extensions'    => $this->checkRequiredPHPExtensions(),
            'Database Connection'        => $this->checkDatabaseConnection(),
            'Error Logging'              => ini_get('log_errors') ? 'Enabled' : 'Disabled',
        ];
    }

    public function getDiskSpaceChartData()
    {
        $logs = \App\Models\DiskUsageLog::orderBy('log_date', 'desc')
            ->limit(7)
            ->get()
            ->reverse();

        return [
            'labels' => $logs->pluck('log_date')
                ->map(fn($date) => \Carbon\Carbon::parse($date)->format('M d'))
                ->toArray(),
            'data'   => $logs->pluck('used_bytes')->toArray(),
            'colors' => ['rgba(75,192,192,0.4)'],
        ];
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    private function getDiskSpace()
    {
        try {
            $totalSpace = disk_total_space(base_path());
            $freeSpace = disk_free_space(base_path());
            $usedSpace = $totalSpace - $freeSpace;
            return $this->formatBytes($usedSpace) . ' / ' . $this->formatBytes($totalSpace);
        } catch (\Exception $e) {
            return 'Error calculating';
        }
    }

    private function checkRequiredPHPExtensions()
    {
        $requiredExtensions = ['mbstring', 'openssl', 'pdo', 'curl'];
        $missingExtensions = array_filter($requiredExtensions, fn($ext) => !extension_loaded($ext));
        return empty($missingExtensions) ? 'All installed' : 'Missing: ' . implode(', ', $missingExtensions);
    }

    private function checkDatabaseConnection()
    {
        try {
            DB::connection()->getPdo();
            return 'Connected';
        } catch (\Exception $e) {
            return 'Failed';
        }
    }

    private function isHttpsEnabled()
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'Yes' : 'No';
    }

    private function getMySQLVersion()
    {
        try {
            return DB::selectOne('SELECT VERSION() as version')->version;
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }
}