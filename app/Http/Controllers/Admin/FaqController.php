<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\FaqRequest;
use App\Services\Admin\FaqService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends BaseController
{
    public function __construct(protected FaqService $service) {
        $this->middleware('auth:admin');
        $this->middleware('can:faq.read')->only('index');
        $this->middleware('can:faq.create')->only(['create', 'store']);
        $this->middleware('can:faq.update')->only(['edit', 'update', 'toggleStatus', 'updateOrderLevel']);
        $this->middleware('can:faq.delete')->only('destroy');
    }

    public function index(Request $request){
        $filters = $request->only('status', 'display_on', 'question');
        
        return view('admin.faq.index', [
            'faqs' => $this->service->getFaqs($filters),
            'filters' => $filters,
        ]);
    }

    public function create(){
        return view('admin.faq.form');
    }

    public function store(FaqRequest $request): JsonResponse
    {
        $faq = $this->service->storeFaq($request->validated());
        return $this->successJson('FAQ created!', $faq, 201);
    }

    public function edit(Faq $faq){
        return view('admin.faq.form', ['faq' => $faq]);
    }

    public function update(FaqRequest $request, Faq $faq): JsonResponse
    {
        $updated = $this->service->updateFaq($faq->id, $request->validated());
        return $this->successJson('FAQ updated!', $updated);
    }

    public function destroy(Faq $faq){
        $this->service->deleteFaq($faq->id);
        return redirect()->back()->with('success', 'FAQ deleted permanently!');
    }

    public function faqStatus(Request $request): JsonResponse
    {
        $request->validate(['status_id' => 'required|exists:faqs,id']);
        $newStatus = $this->service->toggleStatus($request->status_id);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request): JsonResponse
    {
        $request->validate([
            'id'          => 'required|exists:faqs,id',
            'order_level' => 'required|integer|min:0',
        ]);
        $this->service->updateOrderLevel($request->id, $request->order_level);
        return $this->successJson('Order updated!');
    }
}