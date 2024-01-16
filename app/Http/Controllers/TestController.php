<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Profile;
use App\Models\Qualification;
use App\Models\User;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Tag\ImageTag;
use Cloudinary\Transformation\Delivery;
use Cloudinary\Transformation\Format;
use Cloudinary\Transformation\Quality;
use Cloudinary\Transformation\Resize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    // test func
    public function test()
    {
        return view('test');
    }

    // testing func
    public function testing(Request $request)
    {
        $cloudinary = Cloudinary();

        // Configuration::instance('cloudinary://465536872651195:NwKWjOyJe3jY91sulDGAAGtGuUM@career-vibe?secure=true');

        // Configuration::instance([
        //     'cloud' => [
        //         'cloud_name' => 'career-vibe',
        //         'api_key' => '465536872651195',
        //         'api_secret' => 'NwKWjOyJe3jY91sulDGAAGtGuUM'
        //     ],
        //     'url' => [
        //         'secure' => true
        //     ]
        // ]);
        $stored_path = Storage::putFile('temp', $request->file('file'));

        $obj = (new UploadApi())->upload(
            $stored_path,
            [
                'folder' => 'career-vibe/users/profile_image',
                'resource_type' => 'image'
            ]
        );
        unlink($stored_path);
        User::where('id', 5000)->update([
            'profile_image_url' => $obj['secure_url']
        ]);


        return redirect()->back();
    }

    // testing func
    public function testing2(Request $request)
    {
        $path = 'temp/XmONlgASaVV5iF3xzHgsVrjvbT0fpBDtjdbL9qsn.png';
        // $data = (new ImageTag($path))
        //     ->resize(Resize::scale()->width(1000))
        //     ->delivery(Delivery::quality(
        //         Quality::auto()
        //     ))
        //     ->delivery(Delivery::format(
        //         Format::auto()
        //     ));
        // $cloudinary = Cloudinary();
        // Configuration::instance([
        //     'cloud' => [
        //         'cloud_name' => 'career-vibe',
        //         'api_key' => '465536872651195',
        //         'api_secret' => 'NwKWjOyJe3jY91sulDGAAGtGuUM'
        //     ],
        //     'url' => [
        //         'secure' => true
        //     ]
        // ]);

        // $result = (new UploadApi())->upload('mns-logo.png', [
        //     'folder' => '',
        //     'resource_type' => 'image'
        // ]);

        // $obj = $cloudinary->uploadApi()->upload(
        //     $path
        // );
        // dd($obj);
    }
}
