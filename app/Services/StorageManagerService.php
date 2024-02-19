<?php

namespace App\Services;

use App\Jobs\DeleteFromCloudinary;
use App\Jobs\UploadToCloudinary;
use App\Jobs\uploadToCloudinaryDemoJob;
use App\Repository\StorageManagerRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class StorageManagerService implements StorageManagerRepository
{
    public function uploadToCloudinary(
        Request $request,
        string $field_name,
        string $folder,
        string $resource_type, // image or video or pdf
        string $model_type, // user, company, admin, post
        int $model_id,
        string $tag_name
    ): void {
        if (!Config::get('constants.IS_FILE_UPLOAD_SERVICE_ENABLED')) {
            Log::info('File upload service is disabled');
            return;
        }


        $temp_local_path = Config::get('constants.CLOUDINARY_FOLDER_DEMO.temp_local_path');

        $local_stored_path = Storage::putFile($temp_local_path, $request->file($field_name));

        UploadToCloudinary::dispatch(
            $local_stored_path,
            $model_type,
            $model_id,
            $folder,
            $resource_type,
            $tag_name
        );
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
