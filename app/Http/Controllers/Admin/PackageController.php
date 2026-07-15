<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PackageRequest;
use App\Services\Admin\PackageService;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Package;

class PackageController extends BaseController
{
    public function __construct(protected PackageService $service) {
        $this->middleware('auth:admin');
        
        // Read Permissions
        $this->middleware('can:package.read')->only(['index', 'fixDepature']);
        // Create Permissions
        $this->middleware('can:package.create')->only(['create', 'store', 'fixDepatureAdd']);
        // Update Permissions
        $this->middleware('can:package.update')->only(['edit', 'update', 'packageStatus', 'updateOrderLevel', 'updatePackageType', 'packagePrices', 'updatePackagePrices', 'deleteGalleryImage', 'tripItinerary', 'tripIncExc', 'tripEquipment', 'fixDepatureStatus']);
        // Delete Permissions
        $this->middleware('can:package.delete')->only(['destroy', 'deleteFixDepature']);
    }

    public function index(Request $request) {
        $filters = $request->only('status', 'name');
        return view('admin.package.index', [
            'packages' => $this->service->getPackages($filters),
            'filters' => $filters,
        ]);
    }

    public function create() { 
        $getCategories = Category::whereNull('parent_id')->with('children')->orderBy('order_level')->get();
        return view('admin.package.form', compact('getCategories')); 
    }

    public function store(PackageRequest $request): JsonResponse {
        $data = $request->validated();
        $categoryIds = $request->input('category_id', []);
        $package = $this->service->storePackage($data, $categoryIds);
        return $this->successJson('Package created!', $package, 201);
    }

    public function edit(Package $package) { 
        $getCategories = Category::whereNull('parent_id')->with('children')->orderBy('order_level')->get();
        $selectedCategoryIds = $package->categories->pluck('id')->toArray();
        return view('admin.package.form', compact('package', 'getCategories', 'selectedCategoryIds')); 
    }

    public function update(PackageRequest $request, Package $package): JsonResponse {
        $data = $request->validated();
        $categoryIds = $request->input('category_id', []);
        $updated = $this->service->updatePackage($package->id, $data, $categoryIds);
        return $this->successJson('Package updated!', $updated);
    }

    public function destroy(Package $package) {
        $this->service->deletePackage($package->id);
        return redirect()->back()->with('success', 'Package deleted!');
    }

    public function packageStatus(Request $request): JsonResponse {
        $request->validate(['status_id' => 'required|exists:packages,id']);
        $newStatus = $this->service->toggleStatus($request->status_id);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request): JsonResponse {
        $request->validate(['id' => 'required|exists:packages,id', 'order_level' => 'required|integer|min:0']);
        $this->service->updateOrderLevel($request->id, $request->order_level);
        return $this->successJson('Order updated!');
    }

    public function updatePackageType(Request $request): JsonResponse {
        $request->validate(['id' => 'required|exists:packages,id', 'display_on' => 'nullable']);
        $this->service->updateDisplayType($request->id, $request->display_on);
        return $this->successJson('Display updated!');
    }

    public function packagePrices() {
        return view('admin.package.package_price', ['datas' => Package::ordered()->get()]);
    }

    public function updatePackagePrices(Request $request): JsonResponse {
        $request->validate(['id' => 'required|integer', 'trip_previous_price' => 'nullable|numeric', 'trip_price' => 'nullable|numeric']);
        $this->service->updatePrices($request->id, $request->only('trip_previous_price', 'trip_price'));
        return response()->json(['success' => true]);
    }

    public function deleteGalleryImage(Request $request): JsonResponse {
        $request->validate(['id' => 'required|integer', 'image' => 'required|string']);
        $this->service->deleteGalleryImage($request->id, $request->image);
        return response()->json(['status' => 200, 'msg' => 'Image deleted.']);
    }


    public function tripItinerary(Request $request, $id) {
        if ($request->isMethod('POST')) {
            $request->validate([
                'title' => 'nullable|array',
                'title.*' => 'nullable|string',
                'content' => 'nullable|array',
                'content.*' => 'nullable|string',
                'max_elevation' => 'nullable|array',
                'duration' => 'nullable|array',
                'distance' => 'nullable|array',
                'meals' => 'nullable|array',
                'accommodation' => 'nullable|array',
            ]);
            
            $this->service->updateItinerary($id, $request->only('title', 'content', 'max_elevation', 'duration', 'distance', 'meals', 'accommodation'));
            return redirect()->route('admin.trip.itinerary', $id)->with('success', 'Itinerary updated!');
        }
        
        $data = Package::findOrFail($id);
        $data->itinerary_data = !empty($data->itinerary_data) ? $data->itinerary_data : []; 
        
        return view('admin.package.itinerary', compact('data'));
    }

    
    public function tripIncExc(Request $request, $id) {
        if ($request->isMethod('POST')) {
            $this->service->updateIncExc($id, $request->only('included', 'excluded'));
            return redirect()->route('admin.trip.incexc', $id)->with('success', 'Inclusions/Exclusions updated!');
        }
        $data = Package::findOrFail($id);
        return view('admin.package.inc_exc', compact('data'));
    }

    public function tripEquipment(Request $request, $id) {
        if ($request->isMethod('POST')) {
            $this->service->updateEquipment($id, $request->only('equipment1', 'equipment2', 'equipment3', 'equipment4', 'equipment5'));
            return redirect()->route('admin.trip.equipment', $id)->with('success', 'Equipment updated!');
        }
        $data = Package::findOrFail($id);
        return view('admin.package.equipment', compact('data'));
    }

    public function fixDepature() {
        return view('admin.package.fix_departure', ['getData' => $this->service->getFixedDepartures()]);
    }

    public function fixDepatureAdd(Request $request): JsonResponse {
        $request->validate([
            'package_id' => 'required|exists:packages,id', 
            'discount_price' => 'required|numeric',
            'max_seats' => 'required|integer|min:1', 
            'start_date' => 'required|date', 
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        $this->service->addFixedDeparture($request->only('package_id', 'start_date', 'end_date', 'discount_price', 'max_seats', 'description') + ['booked_seats' => 0, 'status' => 'active']);
        return response()->json(['status' => 200, 'msg' => 'Departure added.']);
    }

    public function deleteFixDepature($id) {
        try {
            $this->service->deleteFixedDeparture($id);
            return redirect()->back()->with('success', 'Departure deleted.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function fixDepatureStatus(Request $request): JsonResponse {
        $this->service->toggleDepartureStatus($request->id, $request->status);
        return response()->json(['status' => 200, 'msg' => 'Status updated.']);
    }
}