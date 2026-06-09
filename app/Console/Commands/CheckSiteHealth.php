<?php

namespace App\Console\Commands;

use App\Models\DiskUsageLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CheckSiteHealth extends Command
{
    protected $signature = 'health:check';
    protected $description = 'Calculate disk usage and update cache in the background';

    public function handle()
    {
        $this->info('Starting background health check...');

        // 1. Calculate Disk Space
        $totalSpace = disk_total_space(base_path());
        $freeSpace = disk_free_space(base_path());
        $usedSpace = $totalSpace - $freeSpace;
        $today = now()->toDateString();

        // 2. Save to Database
        DiskUsageLog::updateOrCreate(
            ['log_date' => $today],
            [
                'used_bytes' => $usedSpace,
                'total_bytes' => $totalSpace,
            ]
        );

        // 3. Calculate Directory Sizes and Cache them
        $directories = [
            'public' => $this->getDirectorySize(public_path()),
            'storage' => $this->getDirectorySize(storage_path()),
            'uploads' => $this->getDirectorySize(storage_path('app/public')),
            'views' => $this->getDirectorySize(resource_path('views')),
            'cache' => $this->getDirectorySize(storage_path('framework/cache')),
            'bootstrap_cache' => $this->getDirectorySize(storage_path('framework/views')),
            'node_modules' => $this->getDirectorySize(base_path('node_modules')),
        ];

        Cache::put('directory_sizes', $directories, now()->addHours(1));

        $this->info('Health check complete. Data cached.');
        return 0;
    }

    // Helper to format bytes
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    // Helper to get directory size
    private function getDirectorySize($path)
    {
        if (!is_dir($path)) {
            return '0 B';
        }
        $size = 0;
        try {
            foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path)) as $file) {
                if ($file->isFile()) {
                    $size += $file->getSize();
                }
            }
        } catch (\Exception $e) {
            return 'Permission Denied';
        }
        return $this->formatBytes($size);
    }
}