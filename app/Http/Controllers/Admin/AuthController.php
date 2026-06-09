<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Models\LoginActivity;
use Jenssegers\Agent\Agent;
class AuthController extends BaseController
{
    public function showLogin(): View
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !$admin->status) {
            return response()->json([
                'success' => false,
                'errors'  => ['email' => ['Account is inactive or not found. Contact support.']],
            ], 403);
        }

        if (!Hash::check($request->password, $admin->password)) {
            return response()->json([
                'success' => false,
                'errors'  => ['password' => ['Incorrect password.']],
            ], 401);
        }

        Auth::guard('admin')->login($admin, $request->boolean('remember'));
        $request->session()->regenerate();

        LoginActivity::recordLogin($admin, $request);

        $admin->update(['last_login_at' => now()]);

        return $this->successJson('Login successful!', [
            'redirect' => route('admin.dashboard'),
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {


        LoginActivity::where('admin_id', Auth::guard('admin')->id())
        ->whereNull('logout_at')
        ->latest('login_at')
        ->first()
        ?->update(['logout_at' => now()]);
        
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    // ─── Profile Methods ──────────────────────
    public function showProfile(): View
    {
        return view('admin.profile.update_profile', [
            'admin' => Auth::guard('admin')->user(),
        ]);
    }

     public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $admin = Auth::guard('admin')->user();
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->handleProfileImageUpload($request->file('image'), $admin->image);
        }

        $admin->update($data);
        return $this->successJson('Profile updated successfully!', $admin->fresh());
    }


    // ─── Password Methods ─────────────────────
    public function showChangePassword(): View
    {
        return view('admin.profile.update_password', [
            'admin' => Auth::guard('admin')->user(),
        ]);
    }

    public function updatePassword(ChangePasswordRequest $request): JsonResponse
    {
        $admin = Auth::guard('admin')->user();
        $admin->update(['password' => Hash::make($request->validated()['password'])]);

        return $this->successJson('Password updated successfully!');
    }

    // ─── Account Deletion ─────────────────────
    public function deleteAccount(Request $request): RedirectResponse
    {
        $admin = Auth::guard('admin')->user();

        if ($admin->role?->name !== 'normal_user') {
            $request->session()->flash('error', 'Only normal users can delete their accounts.');
            return redirect()->back();
        }

        $validated = $request->validate([
            'password' => ['required', 'current_password:admin'],
            'confirm'  => ['required', 'in:yes'],
        ], [
            'confirm.in' => 'Please confirm by typing "yes".',
        ]);

        if ($admin->image) {
            $this->deleteProfileImageVariants($admin->image);
        }

        $admin->delete();
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->flash('success', 'Your account has been deleted successfully.');

        return redirect()->route('admin.login');
    }

    // ─── Helper Methods ───────────────────────
    private function handleProfileImageUpload($file, ?string $old): string
    {
        $this->deleteProfileImageVariants($old);
        return $file->store('admin-avatars', 'public');
    }


    private function deleteProfileImageVariants(?string $path): void
    {
        if (!$path) {
            return;
        }

        $disk = Storage::disk('public');
        if ($disk->exists($path)) {
            $disk->delete($path);
        }

        foreach (['thumb', 'medium'] as $size) {
            $variant = preg_replace('/\.(jpe?g|png|webp)$/i', "-{$size}.$0", $path);
            
            if ($variant && $variant !== $path && $disk->exists($variant)) {
                $disk->delete($variant);
            }
        }
    }
}