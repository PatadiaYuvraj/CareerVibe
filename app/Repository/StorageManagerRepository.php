<?php

namespace App\Repository;

use Illuminate\Http\Request;

interface StorageManagerRepository
{

    // uploadToCloudinary() is used to upload image to cloudinary
    public function uploadToCloudinary(
        Request $request,
        string $field_name,
        string $folder,
        string $resource_type, // image or video or pdf
        string $model_type, // user, company, admin, post
        int $model_id,
        string $tag_name
    ): void;

    // deleteFromCloudinary() is used to delete image from cloudinary
    public function deleteFromCloudinary(
        string $public_id
    ): void;

    // uploadToLocal() is used to upload image to local storage
    public function uploadToLocal(Request $request, string $field_name): string;

    // deleteFromLocal() is used to delete image from local storage
    public function deleteFromLocal(string $path): void;
}
