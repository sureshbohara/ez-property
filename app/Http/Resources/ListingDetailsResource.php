<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ListingDetailsResource extends JsonResource
{
    public function toArray($request)
    {
        $reviews = $this->whenLoaded('reviews');
        $totalReviews = $reviews->count();
        
        if ($totalReviews > 0) {
            $avgOverall = round($reviews->avg('overall_rating'), 1);
            $avgCleanliness = round($reviews->avg('cleanliness'), 1);
            $avgAccuracy = round($reviews->avg('accuracy'), 1);
            $avgCheckIn = round($reviews->avg('check_in'), 1);
            $avgLocation = round($reviews->avg('location'), 1);
            $avgValue = round($reviews->avg('value'), 1);
        } else {
            $avgOverall = $avgCleanliness = $avgAccuracy = $avgCheckIn = $avgLocation = $avgValue = 0;
        }
        $calendarData = [];
        $availabilities = $this->whenLoaded('availabilities');
        foreach ($availabilities as $avail) {
            $dateKey = Carbon::parse($avail->date)->format('Y-m-d');
            $calendarData[$dateKey] = [
                'status' => $avail->status, 
                'price' => $avail->custom_price ? (float) $avail->custom_price : null
            ];
        }
        return [
            'id'                 => $this->id,
            'title'              => $this->title,
            'slug'               => $this->slug,
            'description'        => $this->description,
            'image_url'          => $this->image_url,
            'gallery'            => $this->gallery,
            'address'            => $this->address,
            'city'               => $this->city,
            'province'           => $this->province,
            'listing_type'       => $this->listing_type,
            'base_price'         => (float) $this->base_price,
            'cleaning_fee'       => (float) $this->cleaning_fee,
            'service_fee'        => (float) $this->service_fee,
            'minimum_nights'     => $this->minimum_nights,
            'guests'             => $this->guests,
            'bedrooms'           => $this->bedrooms,
            'beds'               => $this->beds,
            'bathrooms'          => $this->bathrooms,
            'instant_bookable'   => $this->instant_bookable,
            'cancellation_policy'=> $this->cancellation_policy,
    
            'calendarData'       => $calendarData,
            'totalReviews'       => $totalReviews,
            'reviews'            => ReviewResource::collection($reviews->take(6)),
            'avgOverall'         => $avgOverall,
            'avgCleanliness'     => $avgCleanliness,
            'avgAccuracy'        => $avgAccuracy,
            'avgCheckIn'         => $avgCheckIn,
            'avgLocation'        => $avgLocation,
            'avgValue'           => $avgValue,
            
            'amenities'          => $this->whenLoaded('amenities'),
            'host'               => $this->whenLoaded('user'),
        ];
    }
}