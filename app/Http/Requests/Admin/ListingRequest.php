<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListingRequest extends FormRequest 
{

    public const LISTING_TYPES = [
        'entire_home', 'private_room', 'shared_room', 
        'homestay', 'hotel', 'resort', 'lodge', 'cabin', 'camping'
    ];

    public const CANCELLATION_POLICIES = ['flexible', 'moderate', 'strict'];

    public function authorize(): bool 
    { 
        return true; 
    }

    public function rules(): array 
    {
        $id = $this->route('listing')?->id;
        
        return [
            'title' => 'required|string|max:255',
            'slug' => $id ? 'nullable|string|unique:listings,slug,'.$id : 'nullable|string|unique:listings,slug',
            'category_id' => 'nullable|integer|exists:categories,id',
            'description' => 'nullable|string',
            
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'display_on' => 'nullable',
            
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',

            'highlight_key' => 'nullable|array',
            'highlight_key.*' => 'nullable|string|max:255',

            'guests' => 'required|integer|min:1',
            'bedrooms' => 'required|integer|min:0',
            'beds' => 'required|integer|min:0',
            'bathrooms' => 'required|numeric|min:0',
            
       
            'listing_type' => ['required', Rule::in(self::LISTING_TYPES)],
            
            'base_price' => 'required|numeric|min:0',
            'cleaning_fee' => 'nullable|numeric|min:0',
            'service_fee' => 'nullable|numeric|min:0',
            'minimum_nights' => 'required|integer|min:1',
            
      
            'cancellation_policy' => ['required', Rule::in(self::CANCELLATION_POLICIES)],

            'instant_bookable' => 'nullable|boolean',
            'status' => 'nullable|boolean',
            'order_level' => 'nullable|integer|min:0',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'amenities' => 'nullable|array',
            'amenities.*' => 'integer|exists:amenities,id',

            'pricing_rules' => 'nullable|array',
            'pricing_rules.*.start_date' => 'required_with:pricing_rules|date',
            'pricing_rules.*.end_date' => 'required_with:pricing_rules|date|after_or_equal:pricing_rules.*.start_date',
            'pricing_rules.*.price_per_night' => 'required_with:pricing_rules|numeric|min:0',

            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ];
    }
}