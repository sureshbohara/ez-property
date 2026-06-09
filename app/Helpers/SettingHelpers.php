<?php

if (!function_exists('setting')) {
 
    function setting(string $key, mixed $default = null): mixed
    {
        $settings = app(App\Services\Admin\SettingService::class)->getSettings();
        return data_get($settings, $key, $default);
    }
}