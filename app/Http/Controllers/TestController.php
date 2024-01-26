<?php

namespace App\Http\Controllers;

use App\Jobs\UploadToCloudinary;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function test()
    {
        return view("test");
    }

    public function testing(Request $request)
    {
        $request->validate([
            "profile_image_url" => [
                "required",
                "image",
                "mimes:jpeg,png,jpg",
                "max:2048",
            ],
        ]);

        $originalFilename = $request->file('profile_image_url')->getClientOriginalName();
        $storedPath = Storage::putFileAs("temp", $request->file("profile_image_url"), $originalFilename);

        UploadToCloudinary::dispatch($storedPath)->onQueue('file_uploads');
    }
}
