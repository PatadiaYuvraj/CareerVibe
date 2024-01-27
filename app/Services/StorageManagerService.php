<?php

namespace App\Services;

use App\Jobs\DeleteFromCloudinary;
use App\Jobs\UploadToCloudinary;
use App\Repository\StorageManagerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageManagerService implements StorageManagerRepository
{
    public function uploadToCloudinary(Request $request, string $user_type, int $user_id): void
    {
        $originalFilename = $request->file('profile_image_url')->getClientOriginalName();
        $storedPath = Storage::putFileAs("temp", $request->file("profile_image_url"), $originalFilename);
        $user_data = [
            "stored_path" => $storedPath,
            "user_type" => $user_type,
            "user_id" => $user_id,

        ];
        UploadToCloudinary::dispatch($user_data)->delay(now()->addSeconds(5));
    }

    public function deleteFromCloudinary(string $public_id): void
    {
        DeleteFromCloudinary::dispatch($public_id)->delay(now()->addSeconds(1));
    }

    public function uploadToLocal(Request $request, string $field_name): string
    {
        $stored_path = Storage::putFile(
            "uploads/users/resumes",
            $request->file($field_name)
        );
        return $stored_path;
    }

    public function deleteFromLocal(string $path): void
    {
        Storage::delete($path);
    }
}
