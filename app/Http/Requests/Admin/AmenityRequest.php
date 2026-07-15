<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AmenityRequest extends FormRequest {
    public function authorize(): bool {
        return auth('admin')->check();
    }

    public function rules(): array {
        $id = $this->route('amenity')?->id;
        return [
            'name' => 'required|string|max:100|unique:amenities,name,' . $id,
            'slug' => 'nullable|string|max:100|unique:amenities,slug,' . $id,
            'icon' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
            'order_level' => 'nullable|integer|min:0',
            'status' => 'nullable|boolean',
        ];
    }
}