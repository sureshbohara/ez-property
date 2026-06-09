<?php

namespace App\Services\Admin;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ProcessImage;
use Illuminate\Support\Facades\Log;

class MediaService
{
    public function uploadImage(UploadedFile $file, string $path = 'uploads'): string
    {
        return $file->store($path, 'public');
    }

    public function dispatchImageProcessing(string $imagePath): void
    {
        ProcessImage::dispatch($imagePath)
            ->onQueue('images')
            ->delay(now()->addSeconds(2));
            
        Log::info("Image job dispatched: {$imagePath}");
    }

    public function deleteImageVariants(?string $path, array $sizes = ['thumb', 'medium']): void
    {
        if (!$path || !Storage::disk('public')->exists($path)) {
            return;
        }

        Storage::disk('public')->delete($path);
        
        foreach ($sizes as $size) {
            $variant = $this->generateVariantPath($path, $size);
            if (Storage::disk('public')->exists($variant)) {
                Storage::disk('public')->delete($variant);
            }
        }
    }

    private function generateVariantPath(string $original, string $size): string
    {
        $info = pathinfo($original);
        return "{$info['dirname']}/{$info['filename']}-{$size}.{$info['extension']}";
    }
}