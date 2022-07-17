<?php

use App\Services\ImageUploader;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('should load image to avatars', function () {
    Storage::fake('public');
    $imageUploader = new ImageUploader;
    $result = $imageUploader->upload(UploadedFile::fake()->image('photo1.jpg'), 'avatars');

    expect($result)->toBeString();
});

it('should load default image to images', function () {
    Storage::fake('public');
    $imageUploader = new ImageUploader;
    $result = $imageUploader->upload(UploadedFile::fake()->image('photo1.jpg'));

    expect($result)->toBeString();
});

it('should return null if does not have an image', function () {
    $imageUploader = new ImageUploader;
    $result = $imageUploader->upload(null);

    expect($result)->toBeNull();
});
