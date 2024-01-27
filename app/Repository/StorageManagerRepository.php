<?php

namespace App\Repository;

use Illuminate\Http\Request;

interface StorageManagerRepository
{

    // uploadToCloudinary() is used to upload image to cloudinary
    public function uploadToCloudinary(Request $request, string $user_type, int $user_id): void;

    // deleteFromCloudinary() is used to delete image from cloudinary
    public function deleteFromCloudinary(string $public_id): void;

    // uploadToLocal() is used to upload image to local storage
    public function uploadToLocal(Request $request, string $field_name): string;

    // deleteFromLocal() is used to delete image from local storage
    public function deleteFromLocal(string $path): void;
}
