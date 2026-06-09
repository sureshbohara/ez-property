<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'email'       => 'nullable|email|max:255',
            'address'     => 'nullable|string|max:500',
            'bio'         => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'facebook'    => 'nullable|url|max:500',
            'youtube'     => 'nullable|url|max:500',
            'tiktok'      => 'nullable|url|max:500',
            'instagram'   => 'nullable|url|max:500',
            'order_level' => 'nullable|integer|min:0',
            'status'      => 'nullable|boolean',
        ];
    }
}