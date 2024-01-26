<?php

namespace App\Jobs;

use Cloudinary\Api\Upload\UploadApi;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
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


    private $filepath;

    /**
     * Create a new job instance.
     */
    public function __construct($filepath)
    {
        $this->filepath = $filepath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Upload file to Cloudinary
            $response = (new UploadApi())->upload(
                Storage::path($this->filepath),
                [
                    'folder' => 'temp',
                    'resource_type' => 'image'
                ]
            );

            unlink(Storage::path($this->filepath));

            Log::info('File upload response:', [$response]);

            // Additional processing after successful upload
            // - Store Cloudinary URL in database
            // - Update user profile with image information
            // - Send notifications, etc.

        } catch (\Exception $e) {
            // Handle other unexpected errors
            Log::error('Unexpected error during upload:', [$e->getMessage()]);
            // Handle appropriately
        }
    }
}
