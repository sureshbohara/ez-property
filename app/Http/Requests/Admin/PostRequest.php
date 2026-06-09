<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id'      => 'required|exists:categories,id',
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'excerpt'          => 'nullable|string|max:500',
            'description'      => 'required|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_featured'      => 'nullable',
            'status'           => 'nullable|in:active,inactive',
            'order_level'      => 'nullable|integer|min:0',
        ];
    }
}