<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessRecordsChunk;
use Illuminate\Http\Request;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Process;
use League\Csv\Reader;
use League\Csv\Statement;

class TestController extends Controller
{

    public function test()
    {
        $d = [
            ["id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at"], ["1", "Gregory Bednar Sr.", "ernser.antwan@example.org", "2024-02-22 06:49:11", "", "fuF20WjNZ7", "2024-02-22 06:49:18", "2024-02-22 06:49:18"]
        ];
        $records = Reader::createFromPath(public_path('users.csv'), 'r');
        // dd(collect($records->getRecords())->toArray());
        // $DATA = $records->getRecords();


        $stmt = Statement::create()->offset(1)->limit(100);
        $data = $stmt->process($records);
        ProcessRecordsChunk::dispatch($data);
        dd("test");
    }

    public function testing(Request $request)
    {
        // file is pdf
        // $request->validate([
        //     'file' => [
        //         'required',
        //         // video file
        //         'file',
        //         'mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime,video/3gpp,video/x-msvideo,video/x-flv,video/x-ms-wmv,video/webm',
        //         'max:102400',

        //     ]
        // ]);


        // $storageManagerService = new StorageManagerService();
        // $storageManagerService->uploadToCloudinary(
        //     $request,
        //     'file',
        //     Config::get('constants.CLOUDINARY_FOLDER_DEMO.user-post-video'),
        //     'video',
        //     Post::class,
        //     2,
        //     Config::get('constants.TAGE_NAMES.user-post-video')
        // );



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
