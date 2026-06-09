<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\BannerRequest;
use App\Services\Admin\BannerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends BaseController
{

    public function __construct(protected BannerService $service) {
        $this->middleware('auth:admin');
        $this->middleware('can:banner.read')->only('index');
        $this->middleware('can:banner.create')->only(['create', 'store']);
        $this->middleware('can:banner.update')->only(['edit', 'update', 'bannerStatus', 'updateOrderLevel']);
        $this->middleware('can:banner.delete')->only('destroy');
    }



    public function index(Request $request)
    {
        $filters = $request->only('status', 'title');
        return view('admin.banner.index', [
            'banners' => $this->service->getBanners($filters),
            'filters' => $filters,
        ]);
    }



    public function create(){
        return view('admin.banner.form');
    }

  
    public function store(BannerRequest $request): JsonResponse
    {
        $banner = $this->service->storeBanner($request->validated());
        return $this->successJson('Banner created!', $banner, 201);
    }




    public function edit(Banner $banner)
    {
        return view('admin.banner.form', ['banner' => $banner]);
    }



    public function update(BannerRequest $request, Banner $banner): JsonResponse
    {
        $updated = $this->service->updateBanner($banner->id, $request->validated());
        return $this->successJson('Banner updated!', $updated);
    }



    public function destroy(Banner $banner)
    {
        $this->service->deleteBanner($banner->id);
        return redirect()->back()->with('success', 'Banner deleted permanently!');
    }



    public function bannerStatus(Request $request): JsonResponse
    {
        $request->validate(['status_id' => 'required|exists:banners,id']);
        $newStatus = $this->service->toggleStatus($request->status_id);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }



    public function updateOrderLevel(Request $request): JsonResponse
    {
        $request->validate([
            'id'          => 'required|exists:banners,id',
            'order_level' => 'required|integer|min:0',
        ]);
        $this->service->updateOrderLevel($request->id, $request->order_level);
        return $this->successJson('Order updated!');
    }

    
}