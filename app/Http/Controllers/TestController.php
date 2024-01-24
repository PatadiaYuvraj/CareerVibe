<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;

class TestController extends Controller
{
    public function test()
    {
        $user_id = 2;
        $follow = Follow::where('user_id', $user_id)->with('followable')->get()->toArray();
        // if followable_type = App\Models\Company then get company details by followable_id
        // if followable_type = App\Models\User then get user details by followable_id

        dd($follow);
        // $email = auth()->guard('admin')->user()->email;
        // $details = [
        //     'title' => 'New Admin Created',
        //     'body' => 'This mail is to inform you that a new admin has been created.'
        // ];

        // SendMailJob::dispatch($email, $details);
    }
}
