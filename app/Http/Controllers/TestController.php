<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        $username = "John Doe";
        $url = "https://www.google.com";
        return view("mail.verifyEmail", compact([
            'username',
            'url'
        ]));
    }

    public function testing(Request $request)
    {
        dd($request->all());
    }
}
