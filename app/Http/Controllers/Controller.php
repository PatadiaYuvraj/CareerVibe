<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    // get all profile image public id from cloudinary
    // $publicIds = \Cloudinary\Uploader::get_all_resources();
    // $publicIds = array_map(function ($publicId) {
    //     return $publicId['public_id'];
    // }, $publicIds['resources']);
    // dd($publicIds);


}
