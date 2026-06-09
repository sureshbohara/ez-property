<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')?->id;
        
        return [
            'parent_id'         => 'nullable|exists:categories,id',
            'name'              => 'required|string|max:255',
            'slug'              => $categoryId 
                ? 'nullable|string|max:255|unique:categories,slug,' . $categoryId 
                : 'nullable|string|max:255|unique:categories,slug',
            'excerpt'           => 'nullable|string|max:500',
            'description'       => 'nullable|string',
            'image'             => $categoryId 
                ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048' 
                : 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'font_icon'         => 'nullable|string|max:100',
            'order_level'       => 'nullable|integer|min:0',
            'display_on'        => 'nullable|string|max:100',
            'meta_keywords'     => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
            'status'            => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => 'Category name is required.',
            'slug.unique'      => 'This slug is already in use.',
            'parent_id.exists' => 'Selected parent category does not exist.',
            'image.image'      => 'Please upload a valid image file.',
            'image.mimes'      => 'Supported formats: JPG, JPEG, PNG, WebP.',
            'image.max'        => 'Image size must not exceed 2MB.',
        ];
    }
}