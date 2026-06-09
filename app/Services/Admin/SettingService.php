<?php

namespace App\Services\Admin;

use App\Models\Setting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class SettingService
{

    public function __construct(protected MediaService $mediaService) {}

    public function getSettings(): array
    {
        return Setting::getInstance()->toArray();
    }

    public function updateSettings(array $data): Setting
    {
        return DB::transaction(function () use ($data) {
            $setting = Setting::getInstance();
            $imageFields = [
                'logo', 'favicon', 'loader', 'footer_gateway_img', 
                'bg_image', 'breadcrumb', 'image1', 'image2'
            ];

            foreach ($imageFields as $field) {
                if (isset($data[$field]) && $data[$field] instanceof UploadedFile) {
                    if ($setting->{$field}) {
                        $this->mediaService->deleteImageVariants($setting->{$field});
                    }
                    $path = $this->mediaService->uploadImage($data[$field], 'settings');
                    $this->mediaService->dispatchImageProcessing($path);
                    $data[$field] = $path;
                } 
                elseif (array_key_exists($field, $data) && $data[$field] === null) {
                    if ($setting->{$field}) {
                        $this->mediaService->deleteImageVariants($setting->{$field});
                    }
                    $data[$field] = null;
                } 
                else {
                    unset($data[$field]);
                }
            }
            $setting->update($data);
            return $setting->fresh();
        });
    }
}