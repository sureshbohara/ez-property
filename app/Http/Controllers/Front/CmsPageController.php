<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Setting;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class CmsPageController extends Controller
{
    
    public function cmsPage($slug){
        $setting = Setting::first();
        $page = Page::where('slug', $slug)->where('status', 1)->firstOrFail();
        $metaTitle       = $page->meta_title ?: ($setting->meta_title ?? 'EzProperty');
        $metaDescription = $page->meta_description ?: ($setting->meta_description ?? 'EzProperty CMS Page.');
        $metaKeywords    = $page->meta_keywords ?: ($setting->meta_keywords ?? '');
        $pageImage = $page->image ? Storage::url($page->image) : asset('default/noimage.png');
        return Inertia::render('CmsPage', [
            'page'             => $page,
            'setting'          => $setting,
            'metaTitle'        => $metaTitle,
            'metaDescription'  => $metaDescription,
            'metaKeywords'     => $metaKeywords,
            'pageImage'        => $pageImage,
        ]);
    }
}