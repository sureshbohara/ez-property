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
                // 1. General Info
                'system_name'        => $setting->system_name,
                'phone'              => $setting->phone,
                'extra_phone'        => $setting->extra_phone,
                'email'              => $setting->email,
                'address'            => $setting->address,
                'footer_copyright'   => $setting->footer_copyright,


                'facebook'           => $setting->facebook,
                'twitter'            => $setting->twitter,
                'linkedin'           => $setting->linkedin,
                'instagram'          => $setting->instagram,
                'youtube'            => $setting->youtube,

     
                'logo_url'           => $setting->logo_url,
                'favicon_url'        => $setting->favicon_url,
                'bg_image_url'       => $setting->bg_image_url,
                'footer_gateway_img_url' => $setting->footer_gateway_img_url,

                'info1'              => $setting->info1,
                'info2'              => $setting->info2,
                'info3'              => $setting->info3,


                'meta_title'         => $setting->meta_title,
                'meta_description'   => $setting->meta_description,
                'meta_keywords'      => $setting->meta_keywords,
            ] : null,

            'footerCategories' => $footerCategories,
        ]);
    }
}