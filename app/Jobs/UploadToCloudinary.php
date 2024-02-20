<?php

namespace App\Jobs;

use App\Models\Admin;
use App\Models\Company;
use App\Models\Post;
use App\Models\User;
use App\Services\StorageManagerService;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadToCloudinary implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private Model $model;
    private string $local_stored_path;
    private string $model_type;
    private int $model_id;
    private string $folder;
    private string $resource_type;
    private string $tag_name;

    /**
     * Create a new job instance.
     */
    public function __construct(
        $local_stored_path,
        $model_type,
        $model_id,
        $folder,
        $resource_type,
        $tag_name
    ) {
        $this->local_stored_path = $local_stored_path;
        $this->model_type = $model_type;
        $this->model_id = $model_id;
        $this->folder = $folder;
        $this->resource_type = $resource_type;
        $this->tag_name = $tag_name;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {

            $resource_type = match ($this->resource_type) {
                'image' => 'image',
                'video' => 'video',
                'pdf' => 'image',
            };

            $response = (new UploadApi())->upload(
                Storage::path($this->local_stored_path),
                [
                    'folder' => $this->folder,
                    'resource_type' => $resource_type
                ]
            );

            if ($this->model_type === User::class) {
                $model = User::find($this->model_id);
            }
            if ($this->model_type === Company::class) {
                $model = Company::find($this->model_id);
            }
            if ($this->model_type === Admin::class) {
                $model = Admin::find($this->model_id);
            }
            if ($this->model_type === Post::class) {
                $model = Post::find($this->model_id);
            }

            if (
                $this->tag_name === Config::get('constants.TAGE_NAMES.user-profile-image') ||
                $this->tag_name === Config::get('constants.TAGE_NAMES.company-profile-image') ||
                $this->tag_name === Config::get('constants.TAGE_NAMES.admin-profile-image')
            ) {
                $model->profile_image_url = $response['secure_url'];
                $model->profile_image_public_id = $response['public_id'];
                $model->save();
            }

            if (
                $this->tag_name === Config::get('constants.TAGE_NAMES.user-resume')
            ) {
                $model->resume_pdf_url = $response['secure_url'];
                $model->resume_pdf_public_id = $response['public_id'];
                $model->save();
            }

            if (
                $this->tag_name === Config::get('constants.TAGE_NAMES.user-post-image') ||
                $this->tag_name === Config::get('constants.TAGE_NAMES.user-post-video') ||
                $this->tag_name === Config::get('constants.TAGE_NAMES.company-post-image') ||
                $this->tag_name === Config::get('constants.TAGE_NAMES.company-post-video')
            ) {
                $model->file = $response['secure_url'];
                $model->public_id = $response['public_id'];
                $model->save();
            }

            $storageManagerService  = new StorageManagerService();
            $storageManagerService->deleteFromLocal($this->local_stored_path);
            unset($storageManagerService);

            Log::info('File upload response: ', [$response]);
        } catch (\Exception $e) {
            Log::error('Error occurred in ' . self::class . ' with message:', [$e->getMessage()]);
        }
    }
}
