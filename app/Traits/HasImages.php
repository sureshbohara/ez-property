<?php

namespace App\Traits;

trait HasImages
{
    public function getImageUrlAttribute(): string
    {
        return $this->resolveImage($this->image);
    }

    public function getFeatureImageUrlAttribute(): string
    {
        return $this->resolveImage($this->feature_image ?? null);
    }

    protected function resolveImage(?string $path): string
    {
        if (empty($path)) {
            return asset('default/noimage.png');
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return asset('images/' . $path);
    }
}