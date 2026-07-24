<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ListingRequest;
use App\Services\Admin\ListingService;
use App\Models\Category;
use App\Models\Amenity;
use App\Models\Listing;
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



    public function create() {
        $user = auth()->user();
        if ($user->role !== 'host' || $user->host_status !== 'approved') {
            return redirect()->route('front.dashboard')->with('error', 'Only approved hosts can list properties.');
        }
        $categories = Category::whereNull('parent_id')->with('children')->ordered()->get();
        $amenities = Amenity::active()->ordered()->get();
        return Inertia::render('Properties/Create', [
            'listing' => null,
            'categories' => $categories,
            'amenities' => $amenities,
            'propertyTypes' => $this->getPropertyTypes(),
            'cancellationPolicies' => $this->getCancellationPolicies(),
        ]);
    }


    public function edit($id) {
        $user = auth()->user();
        $listing = Listing::where('id', $id)->where('user_id', $user->id)->with('amenities')->firstOrFail();
        $categories = Category::whereNull('parent_id')->with('children')->ordered()->get();
        $amenities = Amenity::active()->ordered()->get();
        
        return Inertia::render('Properties/Create', [
            'listing' => $listing,
            'categories' => $categories,
            'amenities' => $amenities,
            'propertyTypes' => $this->getPropertyTypes(),
            'cancellationPolicies' => $this->getCancellationPolicies(),
        ]);
    }


       public function storeProperty(ListingRequest $request) {
        $user = auth()->user();
        if ($user->role !== 'host' || $user->host_status !== 'approved') {
            return redirect()->back()->with('error', 'Your host account is not approved yet.');
        }
        $data = $request->validated();
        $data['status'] = false; 
        $this->service->storeListing($data, auth()->id());
        return redirect()->route('front.properties.my-listings')->with('success', 'Property submitted successfully! It will be visible to guests once approved by Admin.');
       }


    public function update(ListingRequest $request, $id) {
        $user = auth()->user();
        $listing = Listing::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $data = $request->validated();
        $this->service->updateListing($listing->id, $data);
        return redirect()->route('front.properties.my-listings')->with('success', 'Property updated successfully!');
    }


    public function deleteGalleryImage(Request $request, $id) {
        $user = auth()->user();
        $listing = Listing::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        
        $this->service->deleteGalleryImage($listing->id, $request->image);
        return back()->with('success', 'Image deleted successfully.');
    }


    public function myListings() {
        $user = auth()->user();
        $listings = Listing::where('user_id', $user->id)
        ->with(['category']) 
        ->latest()
        ->get();

        return Inertia::render('Properties/MyListings', [
            'listings' => $listings
        ]);
    }


    public function toggleSave(Request $request, $id) {
        $user = auth()->user();
        $listing = Listing::findOrFail($id);
        $isSaved = $user->savedListings()->where('listing_id', $id)->exists();
        if ($isSaved) {
            $user->savedListings()->detach($id);
            return back()->with('success', 'Removed from saved properties.');
        } else {
            $user->savedListings()->attach($id);
            return back()->with('success', 'Added to saved properties!');
        }
    }
    
    
}