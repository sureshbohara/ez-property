<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SettingRequest;
use App\Services\Admin\SettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class SettingController extends BaseController
{
    public function __construct(protected SettingService $service)
    {
        $this->middleware('auth:admin');
        $this->middleware('can:setting.read')->only('index');
        $this->middleware('can:setting.update')->only('update');
    }

    public function index(): View
    {

        $setting = $this->service->getSettings();
        return view('admin.settings.index', compact('setting'));
    }

    public function update(SettingRequest $request): JsonResponse
    {

        $this->service->updateSettings($request->validated());
        return $this->successJson('Settings updated successfully!');
    }
}