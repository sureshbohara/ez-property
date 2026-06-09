<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FleetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $fleetId = $this->route('fleet')?->id;
        
        return [
            'title'             => 'required|string|max:255',
            'subtitle'          => 'nullable|string|max:255',
            'short_content'     => 'nullable|string',
            'slug'              => $fleetId 
                ? 'nullable|string|max:255|unique:fleets,slug,' . $fleetId 
                : 'nullable|string|max:255|unique:fleets,slug',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'feature_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'bags'              => 'nullable|string|max:255',
            'passengers'        => 'nullable|string|max:255',
            'highlight'         => 'nullable|array',
            'order_level'       => 'nullable|integer|min:0',
            'status'            => 'nullable|boolean',
        ];
    }
}