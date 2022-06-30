<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class ImageUploader
{
    public function upload(?UploadedFile $file, string $path = 'images'): ?string
    {
        if ($file === null) {
            return null;
        }

        return Storage::disk('public')->put($path, $file);
    }
}
