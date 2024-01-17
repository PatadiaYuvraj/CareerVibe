<?php

namespace App\Jobs;

use Cloudinary\Api\Admin\AdminApi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteFromCloudinary implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $publicId;


    /**
     * Create a new job instance.
     */

    public function __construct(string $publicId)
    {
        $this->publicId = $publicId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // php artisan queue:work --queue=high
        $result = (new AdminApi())->deleteAssets(
            $this->publicId,
            ["resource_type" => "image", "type" => "upload"]
        );
    }
}
