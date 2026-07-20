<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ListingRequest;
use App\Services\Admin\ListingService;
use App\Models\Category;
use App\Models\Amenity;
use Inertia\Inertia;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function __construct(protected ListingService $service) {}

    private function getPropertyTypes(): array {
        return [
            'entire_home'  => 'Entire Home',
            'private_room' => 'Private Room',
            'shared_room'  => 'Shared Room',
            'homestay'     => 'Homestay',
            'hotel'        => 'Hotel',
            'resort'       => 'Resort',
            'lodge'        => 'Lodge',
            'cabin'        => 'Cabin',
            'camping'      => 'Camping',
        ];
    }

    private function getCancellationPolicies(): array {
        return [
            'flexible' => 'Flexible',
            'moderate' => 'Moderate',
            'strict'   => 'Strict',
        ];
    }

    public function create(){
        if (auth()->user()->role !== 'host') {
            return redirect()->route('front.become.host');
        }
        $categories = Category::whereNull('parent_id')->with('children')->ordered()->get();
        $amenities = Amenity::active()->ordered()->get();
        return Inertia::render('Properties/Create', [
            'categories' => $categories,
            'amenities' => $amenities,
            'propertyTypes' => $this->getPropertyTypes(),
            'cancellationPolicies' => $this->getCancellationPolicies(),
        ]);
    }

    public function store(ListingRequest $request){
        $data = $request->validated();
        $this->service->storeListing($data, auth()->id());
        return redirect()->route('front.dashboard')->with('success', 'Property listed successfully!');
    }

}