<?php

namespace App\Http\Controllers\Admin;

use App\Models\LoginActivity;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class LoginActivityController extends BaseController
{
    
    public function index(Request $request){
        $query = LoginActivity::with('admin:id,name,email')
            ->latest('login_at');
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('admin', function($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('ip_address', 'like', "%{$search}%")
                ->orWhere('os', 'like', "%{$search}%")
                ->orWhere('browser', 'like', "%{$search}%");
            });
        }


        if ($request->filled('from_date')) {
            $query->whereDate('login_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('login_at', '<=', $request->to_date);
        }


        if ($request->filled('device_type') && in_array($request->device_type, ['desktop', 'mobile', 'tablet'])) {
            $query->where('device_type', $request->device_type);
        }


        $perPage = $request->get('per_page', 10);
        $activities = $query->paginate($perPage)->withQueryString();

        return view('admin.login-activities.index', compact('activities'));
    }

 
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:login_activities,id'
        ]);

        $deleted = LoginActivity::whereIn('id', $request->ids)->delete();

        return $this->successJson(
            "Successfully deleted {$deleted} login activity record(s)!",
            ['deleted_count' => $deleted]
        );
    }


    public function destroy($id): JsonResponse
    {
        $activity = LoginActivity::findOrFail($id);
        $activity->delete();

        return $this->successJson('Login activity deleted successfully!');
    }



    public static function recordLogin(Admin $admin, Request $request): LoginActivity
    {
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent() ?? '');

        return LoginActivity::create([
            'admin_id'    => $admin->id,
            'ip_address'  => $request->ip(),
            'user_agent'  => $request->userAgent(),
            'os'          => $agent->platform() ?: 'Unknown',
            'browser'     => $agent->browser() ?: 'Unknown',
            'device_type' => self::getDeviceType($agent),
            'login_at'    => now(),
        ]);
    }

    public static function recordLogout(?int $adminId): void
    {
        if (!$adminId) {
            return;
        }

        LoginActivity::where('admin_id', $adminId)
            ->whereNull('logout_at')
            ->latest('login_at')
            ->first()
            ?->update(['logout_at' => now()]);
    }

    private static function getDeviceType(Agent $agent): string
    {
        if ($agent->isPhone()) {
            return 'mobile';
        }
        if ($agent->isTablet()) {
            return 'tablet';
        }
        return 'desktop';
    }
}