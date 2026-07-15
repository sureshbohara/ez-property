<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
{
    public function authorize(): bool { return auth('admin')->check(); }

    public function rules(): array {
        $packageId = $this->route('package')?->id;
        return [
            // Basic Info
            'name' => 'required|string|max:255',
            'slug' => $packageId ? 'nullable|string|unique:packages,slug,' . $packageId : 'nullable|string|unique:packages,slug',
            'excerpt' => 'nullable|string',
            'description' => 'nullable|string',
            'content' => 'nullable|string',

            // Media
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'feature_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            // Pricing
            'trip_previous_price' => 'nullable|numeric',
            'trip_price' => 'nullable|numeric',
            'group_size_price' => 'nullable|array',
            'group_size_price.*.label' => 'nullable|string|max:255',
            'group_size_price.*.price' => 'nullable|numeric|min:0',

            // Trip Facts
            'duration' => 'nullable|string|max:100',
            'max_altitude' => 'nullable|string|max:100',
            'best_season' => 'nullable|string|max:100',
            'meals' => 'nullable|string|max:100',
            'accommodation' => 'nullable|string|max:100',
            'transportation' => 'nullable|string|max:100',
            'trip_grading' => 'nullable|string|max:100', 

            // Highlights & FAQs
            'highlight_key' => 'nullable|array',
            'highlight_key.*' => 'nullable|string|max:255',
            'faqs' => 'nullable|array',
            'faqs.*.label' => 'nullable|string|max:255',
            'faqs.*.detail' => 'nullable|string',


             // Activities / Travel Styles
            'activities' => 'nullable|array',
            'activities.*' => 'nullable|string|max:255',

            // Settings
            'status' => 'nullable|boolean',
            'order_level' => 'nullable|integer|min:0',
            'display_on' => 'nullable|string|max:255',

            // SEO
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',

            // Categories
            'category_id' => 'nullable|array',
            'category_id.*' => 'integer|exists:categories,id',
        ];
    }
}