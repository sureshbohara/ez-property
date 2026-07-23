<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Admin\MediaService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }


    // =========================================
    // LOGIN API
    // =========================================
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $token = $user->createToken('mobile-app-token')->plainTextToken;
        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ]);
    }

    // =========================================
    // REGISTER API
    // =========================================
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'guest',
        ]);
        $token = $user->createToken('mobile-app-token')->plainTextToken;
        return response()->json([
            'status' => true,
            'message' => 'Account created successfully!',
            'token' => $token,
            'user' => $user
        ], 201);
    }


    // =========================================
    // LOGOUT API
    // =========================================
    public function logout(Request $request) {
        // Current Token लाई Delete गर्ने
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully!'
        ]);
    }



    // =========================================
    // FORGOT PASSWORD API
    // =========================================
    public function store(Request $request) {
        $request->validate([
            'email' => 'required|email',
        ]);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        if ($status == Password::RESET_LINK_SENT) {
            return response()->json([
                'status' => true,
                'message' => __($status)
            ]);
        }
        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);
    }


    // =========================================
    // RESET PASSWORD API
    // =========================================
    public function updateResetPassword(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );
        if ($status == Password::PASSWORD_RESET) {
            return response()->json([
                'status' => true,
                'message' => __($status)
            ]);
        }

        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);
    }


    // =========================================
    // UPDATE PROFILE API
    // =========================================
    public function updateProfile(Request $request){
        $user = $request->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gender' => 'nullable|string|max:20',
            'details' => 'nullable|string|max:1000',
        ]);
        $data = $request->only('name', 'email', 'phone', 'address', 'gender', 'details');
        if ($request->hasFile('image')) {
            if ($user->image && !filter_var($user->image, FILTER_VALIDATE_URL)) {
                $this->mediaService->deleteImageVariants($user->image);
            }
            $path = $this->mediaService->uploadImage($request->file('image'));
            $this->mediaService->dispatchImageProcessing($path);
            $data['image'] = $path;
        }
        $user->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
    }

    // =========================================
    // UPDATE PASSWORD API
    // =========================================
    public function updatePassword(Request $request){
        $user = $request->user();
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Current password is incorrect.']
            ]);
        }
        $user->update(['password' => Hash::make($request->password)]);
        return response()->json([
            'status' => true,
            'message' => 'Password updated successfully'
        ]);
    }
}