<?php

namespace App\Services;

use App\Jobs\DeleteFromCloudinary;
use App\Jobs\UploadToCloudinary;
use App\Repository\StorageManagerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class StorageManagerService implements StorageManagerRepository
{
    public function uploadToCloudinary(Request $request, string $user_type, int $user_id): void
    {
        if (Config::get('constants.IS_FILE_UPLOAD_SERVICE_ENABLED')) {
            $originalFilename = $request->file('profile_image_url')->getClientOriginalName();
            $storedPath = Storage::putFileAs("temp", $request->file("profile_image_url"), $originalFilename);
            $user_data = [
                "stored_path" => $storedPath,
                "user_type" => $user_type,
                "user_id" => $user_id,
            ];
            UploadToCloudinary::dispatch($user_data);
        } else {
            Log::info('File upload service is disabled');
        }
    }

    public function deleteFromCloudinary(string $public_id): void
    {
        // DeleteFromCloudinary::dispatch($public_id);
        Config::get('constants.IS_FILE_UPLOAD_SERVICE_ENABLED')
            ? DeleteFromCloudinary::dispatch($public_id)
            : Log::info('File upload service is disabled');
    }

    public function uploadToLocal(Request $request, string $field_name): string
    {
        if (!$request->hasFile($field_name)) {
            Log::info('No file uploaded : ' . $field_name);
            return "";
        }
        $stored_path = Storage::putFile(
            Config::get('constants.USER_RESUME_PATH'),
            $request->file($field_name)
        );
        Log::info('File uploaded to local storage : ' . $stored_path);
        return $stored_path;
    }

    public function deleteFromLocal(string $path): void
    {
        if (Storage::exists($path)) {
            Storage::delete($path);
            Log::info('File deleted from local storage : ' . $path);
        }
    }
}
