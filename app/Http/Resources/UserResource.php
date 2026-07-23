<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'email'   => $this->email,
            'phone'   => $this->phone,
            'address' => $this->address,
            'gender'  => $this->gender,
            'details' => $this->details,
            'role'    => $this->role,
            'image_url' => $this->image_url,
            'created_at' => $this->created_at->toDateString(),
        ];
    }
}