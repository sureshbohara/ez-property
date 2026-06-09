<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ServiceRequest;
use App\Services\Admin\ServiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends BaseController
{
    public function __construct(protected ServiceService $service) {
       $this->middleware('auth:admin');
       $this->middleware('can:service.read')->only('index');
       $this->middleware('can:service.create')->only(['create', 'store']);
       $this->middleware('can:service.update')->only(['edit', 'update', 'serviceStatus', 'updateOrderLevel']);
       $this->middleware('can:service.delete')->only('destroy');
   }

   public function index(Request $request){
    $filters = $request->only('status', 'title');
    return view('admin.service.index', [
        'services' => $this->service->getServices($filters),
        'filters' => $filters,
    ]);
}

public function create(){
    return view('admin.service.form');
}

public function store(ServiceRequest $request): JsonResponse
{
    $service = $this->service->storeService($request->validated());
    return $this->successJson('Service created!', $service, 201);
}

public function edit(Service $service){
    return view('admin.service.form', ['service' => $service]);
}

public function update(ServiceRequest $request, Service $service): JsonResponse
{
    $updated = $this->service->updateService($service->id, $request->validated());
    return $this->successJson('Service updated!', $updated);
}

public function destroy(Service $service){
    $this->service->deleteService($service->id);
    return redirect()->back()->with('success', 'Service deleted permanently!');
}

public function serviceStatus(Request $request): JsonResponse
{
    $request->validate(['status_id' => 'required|exists:services,id']);
    $newStatus = $this->service->toggleStatus($request->status_id);
    return $this->successJson('Status updated', ['new_status' => $newStatus]);
}

public function updateOrderLevel(Request $request): JsonResponse
{
    $request->validate([
        'id' => 'required|exists:services,id',
        'order_level' => 'required|integer|min:0',
    ]);
    $this->service->updateOrderLevel($request->id, $request->order_level);
    return $this->successJson('Order updated!');
}
}