<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WebSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'system_name' => $this->system_name,
            'logo'        => $this->logo_url, 
            'favicon'     => $this->favicon_url,
            'image1'      => $this->image1_url,
            'image2'      => $this->image2_url,
            'phone'       => $this->phone,
            'email'       => $this->email,
            'address'     => $this->address,
            'work_hours'  => $this->work_hours,
            'google_map'  => $this->google_map,
            'facebook'    => $this->facebook,
            'instagram'   => $this->instagram,
            'youtube'     => $this->youtube,
            'tiktok'      => $this->tiktok,
        ];
    }
}