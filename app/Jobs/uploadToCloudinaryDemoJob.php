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

class uploadToCloudinaryDemoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $data;
    private Model $user;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        // $data = [
        //     "stored_path" => $storedPath,
        //     "model_type" => $model_type,
        //     "model_id" => $model_id,

        // ];
        // try {

        //     if ($this->data['model_type']  == "USER") {
        //         $this->user = USER::find($this->data['user_id']);
        //         $folder = $this->data['folder'];
        //     }
        //     if ($this->data['model_type']  == "ADMIN") {
        //         $this->user = Admin::find($this->data['user_id']);
        //         $folder = $this->data['folder'];
        //     }
        //     if ($this->data['model_type']  == "COMPANY") {
        //         $this->user = Company::find($this->data['user_id']);
        //         $folder = $this->data['folder'];
        //     }
        //     if ($this->data['model_type']  == "POST") {
        //         $this->user = Post::find($this->data['user_id']);
        //         $folder = $this->data['folder'];
        //     }

        //     $response = (new UploadApi())->upload(
        //         Storage::path($this->data['stored_path']),
        //         [
        //             'folder' => $folder,
        //             'resource_type' => 'image'
        //         ]
        //     );

        //     // $user->profile_image_url = $response['secure_url'];
        //     // $user->profile_image_public_id = $response['public_id'];
        //     // $user->save();

        //     // // unlink(Storage::path($this->data['stored_path']));
        //     // $storageManagerService  = new StorageManagerService();
        //     // $storageManagerService->deleteFromLocal($this->data['stored_path']);
        //     // // delete instance $storageManagerService 

        //     // Log::info('File upload response:', [$user, $response]);
        // } catch (\Exception $e) {
        //     Log::error('Unexpected error during upload: ', [$e->getMessage()]);
        // }
    }
}
