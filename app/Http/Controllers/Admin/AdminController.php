<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminRequest;
use App\Services\Admin\AdminService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends BaseController
{
    public function __construct(protected AdminService $service) {
        $this->middleware('auth:admin');
        $this->middleware('can:user.read')->only('index');
        $this->middleware('can:user.create')->only(['create', 'store']);
        $this->middleware('can:user.update')->only(['edit', 'update', 'userStatus', 'updateOrderLevel']);
        $this->middleware('can:user.delete')->only('destroy');
    }

    
    public function index(Request $request){
        $filters = $request->only('status', 'name', 'role_id');
        $currentAdminId = auth('admin')->id();
        
        return view('admin.user.index', [
            'admins' => $this->service->getAdmins($filters, $currentAdminId),
            'filters' => $filters,
            'roles' => $this->service->getRolesForSelect(),
        ]);
    }

    public function create(){
        return view('admin.user.form', [
            'roles' => $this->service->getRolesForSelect(),
        ]);
    }


    public function store(AdminRequest $request): JsonResponse
    {
        $admin = $this->service->storeAdmin($request->validated());
        return $this->successJson('Admin created!', $admin, 201);
    }



     public function edit(int $id){
        $admin = Admin::with('role')->findOrFail($id);
        return view('admin.user.form', [
            'admin' => $admin,
            'roles' => $this->service->getRolesForSelect(),
        ]);
    }


    public function update(AdminRequest $request, Admin $user): JsonResponse
    {

        $updated = $this->service->updateAdmin($user->id, $request->validated());
        return $this->successJson('Admin updated successfully!', $updated);
    }



    public function destroy(Admin $user){

        $this->service->deleteAdmin($user->id);
        return redirect()->back()->with('success', 'Admin deleted permanently!');
    }


    public function userStatus(Request $request): JsonResponse
    {
        $request->validate(['status_id' => 'required|exists:admins,id']);
        $newStatus = $this->service->toggleStatus($request->status_id);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }


    public function updateOrderLevel(Request $request): JsonResponse
    {
        $request->validate([
            'id'          => 'required|exists:admins,id',
            'order_level' => 'required|integer|min:0',
        ]);
        $this->service->updateOrderLevel($request->id, $request->order_level);
        return $this->successJson('Order updated!');
    }
}