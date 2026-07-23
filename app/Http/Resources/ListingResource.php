<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ListingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'               => $this->id,
            'slug'             => $this->slug,
            'title'            => $this->title,
            'image_url'        => $this->image_url, 
            'listing_type'     => $this->listing_type,
            'city'             => $this->city,
            'province'         => $this->province,
            'base_price'       => (float) $this->base_price,
            'minimum_nights'   => $this->minimum_nights,
            'instant_bookable' => $this->instant_bookable,
            'avg_rating'       => $this->reviews->isNotEmpty() ? round($this->reviews->avg('overall_rating'), 1) : 0,
            'reviews_count'    => $this->reviews->count(),
            'category'         => new CategoryResource($this->whenLoaded('category')),
            'amenities'        => AmenityResource::collection($this->whenLoaded('amenities')),
            'user'             => new UserResource($this->whenLoaded('user')),
        ];
    }
}