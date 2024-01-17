<?php

namespace App\Jobs;

use App\Models\Admin;
use App\Models\Company;
use App\Models\User;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Asset\File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class UploadToCloudinary implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $file;
    private string $folder;
    private int $id;
    private string $user_type;
    // fix user type to enum



    /**
     * Create a new job instance.
     */
    public function __construct(string $file, string $folder, int $id, string $user_type)
    {
        $this->file = $file;
        $this->folder = $folder;
        $this->id = $id;
        $this->user_type = $user_type;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        if ($this->user_type == 'admin') {
            $user = Admin::find($this->id);
        } else if ($this->user_type == 'company') {
            $user = Company::find($this->id);
        } else if ($this->user_type == 'user') {
            $user = User::find($this->id);
        }

        // create a file to write to








        $stored_path = Storage::putFile('temp', $this->file);
        $obj = (new UploadApi())->upload(
            $stored_path,
            [
                'folder' => $this->folder,
                'resource_type' => 'image'
            ]
        );

        $data = [
            "profile_image_public_id" => $obj['public_id'],
            "profile_image_url" => $obj['secure_url'],
        ];



        unlink($stored_path);

        $user->update($data);



        // $obj = (new UploadApi())->upload(
        //     $this->stored_path,
        //     [
        //         'folder' => 'career-vibe/admins/profile_image',
        //         'resource_type' => 'image'
        //     ]
        // );

        // $data = [
        //     "profile_image_public_id" => $obj['public_id'],
        //     "profile_image_url" => $obj['secure_url'],
        // ];
    }
}
