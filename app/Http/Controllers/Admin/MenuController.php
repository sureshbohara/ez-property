<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\MenuRequest;
use App\Services\Admin\MenuService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Route;

class MenuController extends BaseController
{
    public function __construct(protected MenuService $service)
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request){
        return view('admin.menu.index', [
            'menus'   => $this->service->getMenus($request->only('status', 'name', 'location')),
            'filters' => $request->only('status', 'name', 'location'),
        ]);
    }

    public function create(){
        return view('admin.menu.form', [
            'namedRoutes' => $this->getSafeNamedRoutes(),
            'locations'   => Menu::LOCATIONS
        ]);
    }

    public function store(MenuRequest $request): JsonResponse
    {
        try {
            $menu = $this->service->storeMenu($request->validated());
            return $this->successJson('Menu created successfully!', $menu, 201);
        } catch (\Exception $e) {
            return $this->errorJson('Failed to create menu: ' . $e->getMessage());
        }
    }

    public function edit(Menu $menu){
        $menu->load('items.children');
        return view('admin.menu.form', [
            'menu'        => $menu,
            'namedRoutes' => $this->getSafeNamedRoutes(),
            'locations'   => Menu::LOCATIONS
        ]);
    }

    public function update(MenuRequest $request, Menu $menu): JsonResponse
    {
        try {
            $this->service->updateMenu($menu->id, $request->validated());
            return $this->successJson('Menu updated successfully!', $menu->fresh());
        } catch (\Exception $e) {
            return $this->errorJson('Failed to update menu: ' . $e->getMessage());
        }
    }

    public function destroy(Menu $menu): JsonResponse
    {
        try {
            $this->service->deleteMenu($menu->id);
            return $this->successJson('Menu deleted successfully!');
        } catch (\Exception $e) {
            return $this->errorJson('Failed to delete menu: ' . $e->getMessage());
        }
    }

    public function menuStatus(Request $request): JsonResponse
    {
        $request->validate(['status_id' => 'required|exists:menus,id']);
        $newStatus = $this->service->toggleStatus($request->status_id);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request): JsonResponse
    {
        $request->validate([
            'id'          => 'required|exists:menus,id',
            'order_level' => 'required|integer|min:0'
        ]);
        $this->service->updateOrderLevel($request->id, $request->order_level);
        return $this->successJson('Order updated!');
    }

    private function getSafeNamedRoutes(): array
    {
        $skipPrefixes = ['admin.', 'api.', 'sanctum.', 'debugbar.', 'ignition.', '_telescope.', 'horizon.', 'nova.'];
        
        return collect(Route::getRoutes())
            ->map(fn($route) => [
                'name'   => $route->getName(),
                'uri'    => '/' . $route->uri(),
                'action' => $route->getActionName(),
            ])
            ->filter(fn($route) => 
                !empty($route['name']) 
                && !str_contains($route['uri'], '{')
                && !collect($skipPrefixes)->contains(fn($prefix) => str_starts_with($route['name'], $prefix))
            )
            ->sortBy('name')
            ->values()
            ->toArray();
    }
}