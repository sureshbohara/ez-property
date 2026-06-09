<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $menuId = $this->route('menu')?->id;
        
        return [
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:menus,slug,' . $menuId,
            'location'    => 'nullable|string|max:100',
            'order_level' => 'nullable|integer|min:0',
            'status'      => 'nullable|boolean',
            'menu_items'  => 'nullable|array',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->has('status')) {
            $this->merge(['status' => 0]);
        } else {
            $this->merge(['status' => filter_var($this->status, FILTER_VALIDATE_BOOLEAN)]);
        }

        if ($this->filled('menu_items') && is_string($this->menu_items)) {
            $decoded = json_decode($this->menu_items, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->merge(['menu_items' => $decoded]);
            }
        }
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Menu name is required',
            'slug.required' => 'Menu slug is required',
            'slug.unique' => 'This slug is already in use',
        ];
    }
}