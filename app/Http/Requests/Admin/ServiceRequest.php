<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $serviceId = $this->route('service')?->id;
        
        return [
            'title'             => 'required|string|max:255',
            'subtitle'          => 'nullable|string|max:255',
            'icon'     => 'nullable|string',
            'short_content'     => 'nullable|string',
            'long_content'      => 'nullable|string',
            'slug'              => $serviceId 
                ? 'nullable|string|max:255|unique:services,slug,' . $serviceId 
                : 'nullable|string|max:255|unique:services,slug',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'feature_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'process_title'     => 'nullable|string|max:255',
            'process_sub_title' => 'nullable|string|max:255',
            'process_item'      => 'nullable|array',
            'highlight'         => 'nullable|array',
            'order_level'       => 'nullable|integer|min:0',
            'status'            => 'nullable|boolean',
            'meta_keywords'     => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
        ];
    }
}