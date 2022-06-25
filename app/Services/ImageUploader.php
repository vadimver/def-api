<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class ImageUploader
{
    public function upload(?UploadedFile $file, string $path = 'images'): ?string
    {
        if ($file) {
            return Storage::disk('public')->put($path, $file);
        }

        return null;
    }
}
