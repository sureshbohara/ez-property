<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;

use App\Models\Admin;
use App\Services\Admin\SettingService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void { }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // 1. Admin Permissions Gate
        Gate::before(function (Admin $user, string $ability) {
            if ($user->isSuperAdmin()) return true;
            if (!str_contains($ability, '.')) return null; 
            [$entity, $action] = explode('.', $ability, 2);
            $perms = Cache::remember("admin.permissions.{$user->id}", 3600, function () use ($user) {
                return $user->permissionRecord?->permissions ?? [];
            });

            return isset($perms[$entity][$action]) && $perms[$entity][$action] === '1';
        });

        // 2. Dynamic SMTP & Global Settings
        try {
            $settingsData = app(SettingService::class)->getSettings();
            
            if ($settingsData) {
                View::share('setting', (object) $settingsData);
                if (!empty($settingsData['smtp_check'])) {
                    Config::set('mail.default', 'smtp');
                    Config::set('mail.mailers.smtp.transport', $settingsData['mail_transport'] ?? 'smtp');
                    Config::set('mail.mailers.smtp.host', $settingsData['mail_host'] ?? 'smtp.gmail.com');
                    Config::set('mail.mailers.smtp.port', $settingsData['mail_port'] ?? 587);
                    Config::set('mail.mailers.smtp.encryption', $settingsData['mail_encryption'] ?? 'tls');
                    Config::set('mail.mailers.smtp.username', $settingsData['mail_username']);
                    Config::set('mail.mailers.smtp.password', $settingsData['mail_password']);
                    $safeFromAddress = $settingsData['mail_username']; 
                    Config::set('mail.from.address', $safeFromAddress);
                    Config::set('mail.from.name', $settingsData['mail_from_name'] ?? 'White Transportation LLC');
                }
            }
        } catch (\Exception $e) {
            Log::error('AppServiceProvider Settings Error: ' . $e->getMessage());
        }
    }
}