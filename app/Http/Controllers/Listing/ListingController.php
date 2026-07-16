<?php

namespace App\Http\Controllers\Listing;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\ListingRequest;
use App\Services\Admin\ListingService;
use App\Models\Category;
use App\Models\Amenity;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ListingController extends BaseController 
{
    public function __construct(protected ListingService $service) {
        $this->middleware('can:listing.read')->only(['index']);
        $this->middleware('can:listing.create')->only(['create', 'store']);
        $this->middleware('can:listing.update')->only(['edit', 'update', 'toggleStatus']);
        $this->middleware('can:listing.delete')->only('destroy');
    }

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
            'experience'      => 'Experience',
            'service'      => 'Service',
        ];
    }

    private function getCancellationPolicies(): array {
        return [
            'flexible' => 'Flexible',
            'moderate' => 'Moderate',
            'strict'   => 'Strict',
        ];
    }


    public function index(Request $request) {
        $filters = $request->only('status', 'title', 'city');
        return view('listings.property.index', [
            'listings' => $this->service->getListings($filters),
            'filters' => $filters,
        ]);
    }

    public function create() {
        $categories = Category::whereNull('parent_id')->with('children')->ordered()->get();
        $amenities = Amenity::active()->ordered()->get();
        
        return view('listings.property.form', [
            'listing' => null,
            'categories' => $categories,
            'amenities' => $amenities,
            'propertyTypes' => $this->getPropertyTypes(),
            'cancellationPolicies' => $this->getCancellationPolicies(),
        ]);
    }

    public function store(ListingRequest $request): JsonResponse {
        $data = $request->validated();
        $listing = $this->service->storeListing($data, null);
        return $this->successJson('Listing created successfully!', $listing, 201);
    }

    public function edit(Listing $listing) {
        $categories = Category::whereNull('parent_id')->with('children')->ordered()->get();
        $amenities = Amenity::active()->ordered()->get();
        
        return view('listings.property.form', [
            'listing' => $listing,
            'categories' => $categories,
            'amenities' => $amenities,
            'propertyTypes' => $this->getPropertyTypes(), 
            'cancellationPolicies' => $this->getCancellationPolicies(),
        ]);
    }

    public function update(ListingRequest $request, Listing $listing): JsonResponse {
        $data = $request->validated();
        $updated = $this->service->updateListing($listing->id, $data);
        return $this->successJson('Listing updated successfully!', $updated);
    }

    public function destroy(Listing $listing) {
        $this->service->deleteListing($listing->id);
        return redirect()->back()->with('success', 'Listing deleted!');
    }

    public function toggleStatus(Request $request): JsonResponse {
        $request->validate(['status_id' => 'required|exists:listings,id']);
        $newStatus = $this->service->toggleStatus($request->status_id);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function deleteGalleryImage(Request $request): JsonResponse {
        $request->validate([
            'id' => 'required|integer|exists:listings,id',
            'image' => 'required|string'
        ]);
        $this->service->deleteGalleryImage($request->id, $request->image);
        return response()->json(['status' => 200, 'msg' => 'Image deleted successfully.']);
    }



     public function updateListingType(Request $request): JsonResponse {
        $request->validate(['id' => 'required|exists:listings,id', 'display_on' => 'nullable']);
        $this->service->updateDisplayType($request->id, $request->display_on);
        return $this->successJson('Display updated!');
    }
    
}