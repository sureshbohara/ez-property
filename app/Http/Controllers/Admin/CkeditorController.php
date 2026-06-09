<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CkeditorController extends BaseController
{
    public function ckeditorUpload(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $path = $request->file('file')->store('ckeditor', 'public');
        return response()->json(asset('storage/' . $path));
    }

    public function ckeditorDeleteImage(Request $request): JsonResponse
    {
        $filename = $request->input('filename');
        $path = "ckeditor/{$filename}";

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return $this->successJson('Image deleted.');
        }

        return $this->errorJson('Image not found.', null, 404);
    }
}