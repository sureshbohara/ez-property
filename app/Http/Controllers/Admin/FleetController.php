<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\FleetRequest;
use App\Services\Admin\FleetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Fleet;

class FleetController extends BaseController
{
    public function __construct(protected FleetService $fleet) {
       $this->middleware('auth:admin');
       $this->middleware('can:fleet.read')->only('index');
       $this->middleware('can:fleet.create')->only(['create', 'store']);
       $this->middleware('can:fleet.update')->only(['edit', 'update', 'fleetStatus', 'updateOrderLevel']);
       $this->middleware('can:fleet.delete')->only('destroy');
   }

   public function index(Request $request){
        $filters = $request->only('status', 'title');
        return view('admin.fleet.index', [
            'fleets' => $this->fleet->getFleets($filters),
            'filters' => $filters,
        ]);
    }

    public function create(){
        return view('admin.fleet.form');
    }

    public function store(FleetRequest $request): JsonResponse
    {
        $fleet = $this->fleet->storeFleet($request->validated());
        return $this->successJson('Fleet created!', $fleet, 201);
    }

    public function edit(Fleet $fleet){
        return view('admin.fleet.form', ['fleet' => $fleet]);
    }

    public function update(FleetRequest $request, Fleet $fleet): JsonResponse
    {
        $updated = $this->fleet->updateFleet($fleet->id, $request->validated());
        return $this->successJson('Fleet updated!', $updated);
    }

    public function destroy(Fleet $fleet){
        $this->fleet->deleteFleet($fleet->id);
        return redirect()->back()->with('success', 'Fleet deleted permanently!');
    }

    public function fleetStatus(Request $request): JsonResponse
    {
        $request->validate(['status_id' => 'required|exists:fleets,id']);
        $newStatus = $this->fleet->toggleStatus($request->status_id);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|exists:fleets,id',
            'order_level' => 'required|integer|min:0',
        ]);
        $this->fleet->updateOrderLevel($request->id, $request->order_level);
        return $this->successJson('Order updated!');
    }
}