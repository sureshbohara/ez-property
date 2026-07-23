<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'slug'       => $this->slug,
            'excerpt'    => $this->excerpt,
            'font_icon'  => $this->font_icon,
            'image_url'  => $this->image_url, 
            'order_level'=> $this->order_level,
            'children'   => CategoryResource::collection($this->whenLoaded('children')),
        ];
    }
}