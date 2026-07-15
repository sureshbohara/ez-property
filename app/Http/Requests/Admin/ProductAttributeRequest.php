<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductAttributeRequest extends FormRequest
{
    public function authorize(): bool { 
        return auth('admin')->check(); 
    }

    public function rules(): array {
        $attrId = $this->route('product_attribute')?->id;
        return [
            'name' => 'required|string|max:255',
            'slug' => $attrId ? 'nullable|string|unique:product_attributes,slug,' . $attrId : 'nullable|string|unique:product_attributes,slug',
            'type' => 'required|in:select,text,color,image',
            'values' => 'nullable|array',
            'values.*' => 'nullable|string|max:255',
            'order_level' => 'nullable|integer|min:0',
            'status' => 'nullable|boolean',
        ];
    }

   
    protected function prepareForValidation() {
        if (!$this->has('status')) {
            $this->merge(['status' => true]);
        }
    }
}