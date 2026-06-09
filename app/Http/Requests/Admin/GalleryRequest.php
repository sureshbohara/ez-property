<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        $galleryId = $this->route('gallery')?->id;
        
        return [
            'name'        => 'required|string|max:255',
            'display_on'  => 'required|string|max:100',
            

            'image'       => $galleryId 
            ? 'nullable|image|mimes:jpg,jpeg,png,webp' 
            : 'required|image|mimes:jpg,jpeg,png,webp',
            
            'alt'         => 'nullable|string|max:255',
            'order_level' => 'nullable|integer|min:0',
            'status'      => 'nullable|boolean',
        ];
    }


    public function messages(): array
    {
        return [
            'image.required' => 'Please select an image to upload.',
            'image.image'    => 'The file must be a valid image (JPG, PNG, or WebP).',
            'image.mimes'    => 'Supported formats: JPG, JPEG, PNG, WebP.',
            'image.max'      => 'Image size must not exceed 2MB.',
        ];
    }
}