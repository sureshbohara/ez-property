<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PageRequest;
use App\Services\Admin\PageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends BaseController
{
    public function __construct(protected PageService $service) {
        $this->middleware('auth:admin');
        $this->middleware('can:page.read')->only('index');
        $this->middleware('can:page.create')->only(['create', 'store']);
        $this->middleware('can:page.update')->only(['edit', 'update', 'pageStatus', 'updateOrderLevel']);
        $this->middleware('can:page.delete')->only('destroy');
    }

    public function index(Request $request){
        $filters = $request->only('status', 'title');
        return view('admin.page.index', [
            'pages' => $this->service->getPages($filters),
            'filters' => $filters,
        ]);
    }

    public function create() { return view('admin.page.form'); }

    public function store(PageRequest $request): JsonResponse
    {
        $page = $this->service->storePage($request->validated());
        return $this->successJson('Page created!', $page, 201);
    }

    public function edit(Page $page) { return view('admin.page.form', ['page' => $page]); }

    public function update(PageRequest $request, Page $page): JsonResponse
    {
        $updated = $this->service->updatePage($page->id, $request->validated());
        return $this->successJson('Page updated!', $updated);
    }

    public function destroy(Page $page){
        $this->service->deletePage($page->id);
        return redirect()->back()->with('success', 'Page deleted permanently!');
    }

    public function pageStatus(Request $request): JsonResponse
    {
        $request->validate(['status_id' => 'required|exists:pages,id']);
        $newStatus = $this->service->toggleStatus($request->status_id);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request): JsonResponse
    {
        $request->validate(['id' => 'required|exists:pages,id', 'order_level' => 'required|integer|min:0']);
        $this->service->updateOrderLevel($request->id, $request->order_level);
        return $this->successJson('Order updated!');
    }
}