<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PermissionRequest;
use App\Models\Permission;
use App\Services\Admin\PermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PermissionController extends BaseController
{
    public function __construct(protected PermissionService $service)
    {
        $this->middleware('auth:admin');
        $this->middleware('can:permission.read')->only('index');
        $this->middleware('can:permission.create')->only(['create', 'store']);
        $this->middleware('can:permission.update')->only(['edit', 'update']); 
        $this->middleware('can:permission.delete')->only('destroy');
    }

    public function index(): View
    {
        $permissions = Permission::with('role')->ordered()->paginate(15);
        $datas = $this->service->getPermissionData();
        return view('admin.permissions.index', compact('permissions', 'datas'));
    }

    public function create(): View
    {
        $data = $this->service->getPermissionData();
        return view('admin.permissions.form', [
            'permission' => null,
            'entities' => $data['entities'],
            'actions' => $data['actions'],
            'defaultPermissions' => $data['permissions'],
            'roles' => $data['roles'],
        ]);
    }

    public function store(PermissionRequest $request): JsonResponse
    {
        $user = auth('admin')->user();
        if (!$user->hasPermission('permission', 'create')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        $permission = $this->service->createPermissions($request->role_id, $request->permission ?? []);
        return $this->successJson('Permission created!', $permission, 201);
    }

    public function edit(int $id): View
    {
        $permission = Permission::with('role')->findOrFail($id);
        $data = $this->service->getPermissionData($permission->role_id);
        return view('admin.permissions.form', [
            'permission' => $permission,
            'entities' => $data['entities'],
            'actions' => $data['actions'],
            'defaultPermissions' => $data['permissions'],
            'roles' => $data['roles'],
        ]);
    }

    public function update(PermissionRequest $request, Permission $permission): JsonResponse
    {
        $user = auth('admin')->user();
        if (!$user->hasPermission('permission', 'update')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        if ($permission->role?->name === 'super_admin' && !$user->isSuperAdmin()) {
            return response()->json(['success' => false, 'message' => 'Cannot modify Super Admin'], 403);
        }
        $updated = $this->service->updatePermissions($permission->id, $request->permission ?? []);
        return $this->successJson('Permission updated!', $updated);
    }

    public function destroy(Permission $permission): JsonResponse
    {
        $user = auth('admin')->user();
        if (!$user->hasPermission('permission', 'delete')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        $this->service->deletePermissions($permission->id);
        return $this->successJson('Permission deleted!');
    }
}