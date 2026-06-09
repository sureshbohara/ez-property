<?php

namespace App\Services\Admin;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MenuService
{
    public function __construct(protected Menu $menu) {}

    public function getMenus(array $filters = [])
    {
        return $this->menu->query()
            ->when(!empty($filters['status']), function ($q) use ($filters) {
                $q->where('status', filter_var($filters['status'], FILTER_VALIDATE_BOOLEAN));
            })
            ->when(!empty($filters['name']), function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(!empty($filters['location']), function ($q) use ($filters) {
                $q->where('location', $filters['location']);
            })
            ->orderBy('order_level', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends($filters);
    }

    public function storeMenu(array $data)
    {
        return DB::transaction(function () use ($data) {
            $menu = $this->menu->create([
                'name' => $data['name'],
                'slug' => $data['slug'] ?? Str::slug($data['name']),
                'location' => $data['location'] ?? null,
                'order_level' => $data['order_level'] ?? 0,
                'status' => $data['status'] ?? 1,
            ]);

            if (isset($data['menu_items']) && is_array($data['menu_items'])) {
                $this->saveMenuItems($menu->id, $data['menu_items']);
            }

            return $menu->load('items.children');
        });
    }

    public function updateMenu(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $menu = $this->menu->findOrFail($id);
            
            $menu->update([
                'name' => $data['name'],
                'slug' => $data['slug'] ?? Str::slug($data['name']),
                'location' => $data['location'] ?? null,
                'order_level' => $data['order_level'] ?? 0,
                'status' => $data['status'] ?? 1,
            ]);

            // Delete old items
            MenuItem::where('menu_id', $menu->id)->delete();

            // Save new items
            if (isset($data['menu_items']) && is_array($data['menu_items'])) {
                $this->saveMenuItems($menu->id, $data['menu_items']);
            }

            return $menu->fresh()->load('items.children');
        });
    }

    public function deleteMenu(int $id): bool
    {
        $menu = $this->menu->findOrFail($id);
        return $menu->delete();
    }

    public function toggleStatus(int $id): bool
    {
        $menu = $this->menu->findOrFail($id);
        $menu->status = !$menu->status;
        $menu->save();
        return $menu->status;
    }

    public function updateOrderLevel(int $id, int $orderLevel): bool
    {
        $menu = $this->menu->findOrFail($id);
        $menu->order_level = $orderLevel;
        $menu->save();
        return true;
    }

    public function getMenuWithItems(int $id)
    {
        return $this->menu->with('items.children')->findOrFail($id);
    }

    private function saveMenuItems(int $menuId, array $items, ?int $parentId = null)
    {
        foreach ($items as $index => $item) {
            $menuItem = MenuItem::create([
                'menu_id'   => $menuId,
                'title'     => $item['title'] ?? 'Untitled',
                'url'       => $item['url'] ?? '#',
                'type'      => $item['type'] ?? 'custom',
                'target'    => $item['target'] ?? '_self',
                'order'     => $index,
                'parent_id' => $parentId,
            ]);

            if (isset($item['children']) && is_array($item['children'])) {
                $this->saveMenuItems($menuId, $item['children'], $menuItem->id);
            }
        }
    }
}