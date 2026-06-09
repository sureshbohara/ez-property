<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\GalleryRequest;
use App\Services\Admin\GalleryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Gallery;

class GalleryController extends BaseController
{
    public function __construct(protected GalleryService $service) {
        $this->middleware('auth:admin');
        $this->middleware('can:gallery.read')->only('index');
        $this->middleware('can:gallery.create')->only(['create', 'store']);
        $this->middleware('can:gallery.update')->only(['edit', 'update', 'toggleStatus', 'updateOrderLevel']);
        $this->middleware('can:gallery.delete')->only('destroy');
    }

    public function index(Request $request){
        $filters = $request->only('status', 'display_on', 'name');
        
        return view('admin.gallery.index', [
            'galleries' => $this->service->getGalleries($filters),
            'filters' => $filters,
        ]);
    }

    public function create(){
        return view('admin.gallery.form');
    }

    public function store(GalleryRequest $request): JsonResponse
    {
        $gallery = $this->service->storeGallery($request->validated());
        return $this->successJson('Gallery image created!', $gallery, 201);
    }

    public function edit(Gallery $gallery){
        return view('admin.gallery.form', ['gallery' => $gallery]);
    }

    public function update(GalleryRequest $request, Gallery $gallery): JsonResponse
    {
        $updated = $this->service->updateGallery($gallery->id, $request->validated());
        return $this->successJson('Gallery image updated!', $updated);
    }

    public function destroy(Gallery $gallery){
        $this->service->deleteGallery($gallery->id);
        return redirect()->back()->with('success', 'Gallery image deleted!');
    }

    public function galleryStatus(Request $request): JsonResponse
    {
        $request->validate(['status_id' => 'required|exists:galleries,id']);
        $newStatus = $this->service->toggleStatus($request->status_id);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request): JsonResponse
    {
        $request->validate([
            'id'          => 'required|exists:galleries,id',
            'order_level' => 'required|integer|min:0',
        ]);
        $this->service->updateOrderLevel($request->id, $request->order_level);
        return $this->successJson('Order updated!');
    }
}