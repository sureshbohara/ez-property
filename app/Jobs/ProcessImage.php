<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProcessImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 120;
    public $tries = 3;
    public $backoff = [10, 30];

    public function __construct(
        public string $imagePath,
        public string $disk = 'public',
        public array $sizes = ['thumb' => [150, 150], 'medium' => [400, 400]]
    ) {}

    public function handle(): void
    {
        if (!Storage::disk($this->disk)->exists($this->imagePath)) {
            Log::warning("Image not found: {$this->imagePath}");
            return;
        }

        try {
            $manager = new ImageManager(new Driver());
            $originalPath = Storage::disk($this->disk)->path($this->imagePath);
            $image = $manager->read($originalPath);

            foreach ($this->sizes as $label => [$width, $height]) {
                $resized = $image->cover($width, $height, 'center');
                $newPath = $this->generateVariantPath($this->imagePath, $label);
                $resized->save(Storage::disk($this->disk)->path($newPath), 85);
                Log::info("Variant created: {$newPath}");
            }

            $image->save($originalPath, 85);
        } catch (\Exception $e) {
            Log::error("Image processing failed: " . $e->getMessage());
            throw $e;
        }
    }

    protected function generateVariantPath(string $original, string $variant): string
    {
        $path = pathinfo($original);
        return "{$path['dirname']}/{$path['filename']}-{$variant}.{$path['extension']}";
    }
}