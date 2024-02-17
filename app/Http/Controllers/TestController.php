<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{

    public function test()
    {

        dd("test");
        return view("test");
    }

    public function testing(Request $request)
    {
        dd($request->all());
        $request->validate([
            // video file
            'file' => [
                'required',
                'file',
                'mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime,video/3gpp,video/x-msvideo,video/x-flv,video/x-ms-wmv,video/webm',
                'max:102400',
            ]
        ]);

        // store video in local then upload to cloudinary
        $originalFilename = $request->file('file')->getClientOriginalName();
        $storedPath = Storage::putFileAs("temp/video", $request->file("file"), $originalFilename);

        $response = (new UploadApi())->upload(
            $storedPath,
            [
                'folder' => 'career-vibe/videos',
                'resource_type' => 'video'
            ]
        );
        Log::info('Local file path: ', [$storedPath]);
        Log::info('File upload response: ', [$response]);
        unlink(Storage::path($storedPath));
        dd($response);
    }
}
