<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Cache;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        $setting = Cache::rememberForever('site_settings', function () {
            return Setting::first();
        });

        $footerCategories = Cache::rememberForever('footer_categories', function () {
            return Category::whereNull('parent_id')
                ->where('status', true) 
                ->orderBy('order_level', 'asc')
                ->select('id', 'name', 'slug', 'image')
                ->take(7)
                ->get();
        });

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'flash' => [
                'success' => $request->session()->get('success'),
                'error'   => $request->session()->get('error'),
                'info'    => $request->session()->get('info'),
            ],
            
            'setting' => $setting ? [
                // General Info
                'system_name'        => $setting->system_name,
                'phone'              => $setting->phone,
                'extra_phone'        => $setting->extra_phone,
                'email'              => $setting->email,
                'address'            => $setting->address,
                'work_hours'         => $setting->work_hours, 
                'google_map'         => $setting->google_map,
                'footer_copyright'   => $setting->footer_copyright,

                // Social Links
                'facebook'           => $setting->facebook,
                'twitter'            => $setting->twitter,
                'linkedin'           => $setting->linkedin,
                'instagram'          => $setting->instagram,
                'youtube'            => $setting->youtube,

                // Media
                'logo_url'           => $setting->logo_url,
                'favicon_url'        => $setting->favicon_url,
                'bg_image_url'       => $setting->bg_image_url,
                'footer_gateway_img_url' => $setting->footer_gateway_img_url,
                'image1_url'         => $setting->image1_url,
                'image2_url'         => $setting->image2_url,

                // Info Texts
                'info1'              => $setting->info1, 
                'info2'              => $setting->info2, 
                'info3'              => $setting->info3,
                'info4'              => $setting->info4,
                'info5'              => $setting->info5,
                'info6'              => $setting->info6,

                // Process Info (Why Choose Us)
                'process_title'      => $setting->process_title, 
                'process_sub_title'  => $setting->process_sub_title, 
                'process_item'       => $setting->process_item, 

                // Work Info (Our Services)
                'work_title'         => $setting->work_title, 
                'work_sub_title'     => $setting->work_sub_title, 
                'work_item'          => $setting->work_item, 

                // Counter Info (Statistics)
                'counter_title'      => $setting->counter_title, 
                'counter_sub_title'  => $setting->counter_sub_title, 
                'counter_item'       => $setting->counter_item, 

                // SEO
                'meta_title'         => $setting->meta_title,
                'meta_description'   => $setting->meta_description,
                'meta_keywords'      => $setting->meta_keywords,
            ] : null,

            'footerCategories' => $footerCategories,
        ]);
    }
}