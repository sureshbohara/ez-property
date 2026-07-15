<?php

namespace App\Services\Admin;

use App\Jobs\ProcessImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    public function uploadImage(UploadedFile $file): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
 
        $path = $file->storeAs('', $filename, 'images');
        
        return $path; 
    }

    public function dispatchImageProcessing(string $path): void
    {
        ProcessImage::dispatch($path);
    }

    public function deleteImageVariants(?string $path): void
    {
        if (empty($path)) return;

   
        Storage::disk('images')->delete($path);

      
        $pathInfo = pathinfo($path);
        foreach (['thumb', 'medium'] as $size) {
            $variantPath = "{$pathInfo['dirname']}/{$pathInfo['filename']}-{$size}.{$pathInfo['extension']}";
            Storage::disk('images')->delete($variantPath);
        }
    }
}