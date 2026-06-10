<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\MarketingService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MarketingController extends BaseController
{
    public function __construct(protected MarketingService $service) {
        $this->middleware('auth:admin');
    }

    public function index(){
        return view('admin.marketing.index', [
            'subscribers' => $this->service->getSubscribers()
        ]);
    }

    public function storeSubscriber(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email|unique:subscribers,email']);
        
        \App\Models\Subscriber::create([
            'email' => $request->email,
            'subscribed_at' => now()
        ]);

        return $this->successJson('Subscribed successfully!', [], 201);
    }

    public function sendBulkEmail(Request $request): JsonResponse
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $result = $this->service->sendBulkEmail($request->subject, $request->content);

        if ($result['status']) {
            return $this->successJson($result['message']);
        }

        return response()->json(['message' => $result['message']], 400);
    }
}