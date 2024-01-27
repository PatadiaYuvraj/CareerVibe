<?php

namespace App\Jobs;

use App\Models\Admin;
use App\Models\Company;
use App\Models\User;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadToCloudinary implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private array $user_data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $user_data)
    {
        $this->user_data = $user_data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {

            /*
        $user_data = [
            "stored_path" => $storedPath,
            "user_type" => "USER",
            "user_id" => 1,
            "folder" => 'career-vibe/users/profile_image'
        ];
    */

            if ($this->user_data['user_type']  == "USER") {
                $user = USER::find($this->user_data['user_id']);
                $folder = 'career-vibe/users/profile_image';
            }
            if ($this->user_data['user_type']  == "ADMIN") {
                $user = Admin::find($this->user_data['user_id']);
                $folder = 'career-vibe/admins/profile_image';
            }
            if ($this->user_data['user_type']  == "COMPANY") {
                $user = Company::find($this->user_data['user_id']);
                $folder = 'career-vibe/companies/profile_image';
            }

            $response = (new UploadApi())->upload(
                Storage::path($this->user_data['stored_path']),
                [
                    'folder' => $folder,
                    'resource_type' => 'image'
                ]
            );

            unlink(Storage::path($this->user_data['stored_path']));


            $user->profile_image_url = $response['secure_url'];
            $user->profile_image_public_id = $response['public_id'];
            $user->save();

            Log::info('File upload response:', [$user, $response]);
        } catch (\Exception $e) {
            Log::error('Unexpected error during upload:', [$e->getMessage()]);
        }
    }
}
