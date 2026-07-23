<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'guest_name'    => $this->guest_name,
            'overall_rating'=> (float) $this->overall_rating,
            'cleanliness'   => (float) $this->cleanliness,
            'accuracy'      => (float) $this->accuracy,
            'check_in'      => (float) $this->check_in,
            'location'      => (float) $this->location,
            'value'         => (float) $this->value,
            'comment'       => $this->comment,
            'stay_date'     => $this->stay_date?->format('Y-m-d'),
            'created_at'    => $this->created_at->diffForHumans(),
            'user'          => new UserResource($this->whenLoaded('user')),
        ];
    }
}