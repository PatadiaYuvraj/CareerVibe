<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Services\StorageManagerService;
use Carbon\Carbon;
use Cloudinary\Api\Admin\AdminApi;
use Cloudinary\Api\Upload\UploadApi;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class TestController extends Controller
{

    public function test()
    {
        return view("test");
    }

    public function testing(Request $request)
    {
        // file is pdf
        $request->validate([
            'file' => [
                'required',
                // video file
                'file',
                'mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime,video/3gpp,video/x-msvideo,video/x-flv,video/x-ms-wmv,video/webm',
                'max:102400',

            ]
        ]);


        $storageManagerService = new StorageManagerService();
        $storageManagerService->uploadToCloudinary(
            $request,
            'file',
            Config::get('constants.CLOUDINARY_FOLDER_DEMO.user-post-video'),
            'video',
            Post::class,
            2,
            Config::get('constants.TAGE_NAMES.user-post-video')
        );



        dd("done uploading");
        // $request->validate([
        //     // video file
        //     'file' => [
        //         'required',
        //         'file',
        //         'mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime,video/3gpp,video/x-msvideo,video/x-flv,video/x-ms-wmv,video/webm',
        //         'max:102400',
        //     ]
        // ]);

        // // store video in local then upload to cloudinary
        // $originalFilename = $request->file('file')->getClientOriginalName();
        // $storedPath = Storage::putFileAs("temp/video", $request->file("file"), $originalFilename);

        // $response = (new UploadApi())->upload(
        //     $storedPath,
        //     [
        //         'folder' => 'career-vibe/videos',
        //         'resource_type' => 'video'
        //     ]
        // );
        // Log::info('Local file path: ', [$storedPath]);
        // Log::info('File upload response: ', [$response]);
        // unlink(Storage::path($storedPath));
        // dd($response);
    }
}
