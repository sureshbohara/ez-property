<?php
namespace App\Http\Controllers\Listing;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\AmenityRequest;
use App\Services\Admin\AmenityService;
use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AmenityController extends BaseController {

    public function __construct(protected AmenityService $service) {
        $this->middleware('can:amenity.read')->only(['index']);
        $this->middleware('can:amenity.create')->only(['create', 'store']);
        $this->middleware('can:amenity.update')->only(['edit', 'update', 'toggleStatus', 'updateOrderLevel']);
        $this->middleware('can:amenity.delete')->only('destroy');
    }

    public function index(Request $request) {
        $filters = $request->only('status', 'name');
        return view('listings.amenities.index', [
            'amenities' => $this->service->getAmenities($filters),
            'filters' => $filters,
        ]);
    }

    public function create() {
        return view('listings.amenities.form');
    }

    public function store(AmenityRequest $request): JsonResponse {
        $data = $request->validated();
        $amenity = $this->service->storeAmenity($data);
        return $this->successJson('Amenity created successfully!', $amenity, 201);
    }

    public function edit(Amenity $amenity) {
        return view('listings.amenities.form', compact('amenity'));
    }

    public function update(AmenityRequest $request, Amenity $amenity): JsonResponse {
        $data = $request->validated();
        $updated = $this->service->updateAmenity($amenity->id, $data);
        return $this->successJson('Amenity updated successfully!', $updated);
    }

    public function destroy(Amenity $amenity) {
        $this->service->deleteAmenity($amenity->id);
        return redirect()->back()->with('success', 'Amenity deleted!');
    }

    public function toggleStatus(Request $request): JsonResponse {
        $request->validate(['status_id' => 'required|exists:amenities,id']);
        $newStatus = $this->service->toggleStatus($request->status_id);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request): JsonResponse {
        $request->validate(['id' => 'required|exists:amenities,id', 'order_level' => 'required|integer|min:0']);
        $this->service->updateOrderLevel($request->id, $request->order_level);
        return $this->successJson('Order level updated!');
    }
    
}