<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
    public function authorize(): bool { return auth('admin')->check(); }

    public function rules(): array {
        $brandId = $this->route('brand')?->id;
        return [
            'name' => 'required|string|max:255',
            'slug' => $brandId ? 'nullable|string|unique:brands,slug,' . $brandId : 'nullable|string|unique:brands,slug',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'order_level' => 'nullable|integer|min:0',
            'status' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ];
    }
}