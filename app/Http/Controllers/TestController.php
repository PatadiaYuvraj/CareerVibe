<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestController extends Controller
{
    public function test()
    {
        // DB::table('users')->insert([
        //     'name' => 'User 1',
        //     'email' => 'user1@user.com',
        //     'password' => Hash::make('12121212'),
        //     'is_email_verified' => 1,
        //     'email_verified_at' => Carbon::now(),
        // ]);
        // DB::table('users')->insert([
        //     'name' => 'User 2',
        //     'email' => 'user2@user.com',
        //     'password' => Hash::make('12121212'),

        //     'is_email_verified' => 1,
        //     'email_verified_at' => Carbon::now(),
        // ]);
        // DB::table('users')->insert([
        //     'name' => 'User 3',
        //     'email' => 'user3@user.com',
        //     'password' => Hash::make('12121212'),

        //     'is_email_verified' => 1,
        //     'email_verified_at' => Carbon::now(),
        // ]);
        // DB::table('users')->insert([
        //     'name' => 'User 4',
        //     'email' => 'user4@user.com',
        //     'password' => Hash::make('12121212'),

        //     'is_email_verified' => 1,
        //     'email_verified_at' => Carbon::now(),
        // ]);
        // DB::table('companies')->insert([
        //     'name' => 'Company 1',
        //     'email' => 'company1@company.com',
        //     'password' => Hash::make('12121212'),

        //     'is_email_verified' => 1,
        //     'email_verified_at' => Carbon::now(),
        // ]);
        // DB::table('companies')->insert([
        //     'name' => 'Company 2',
        //     'email' => 'company2@company.com',
        //     'password' => Hash::make('12121212'),

        //     'is_email_verified' => 1,
        //     'email_verified_at' => Carbon::now(),
        // ]);
        // DB::table('companies')->insert([
        //     'name' => 'Company 3',
        //     'email' => 'company3@company.com',
        //     'password' => Hash::make('12121212'),

        //     'is_email_verified' => 1,
        //     'email_verified_at' => Carbon::now(),
        // ]);
        // DB::table('admins')->insert([
        //     'name' => 'Admin 1',
        //     'email' => 'admin1@admin.com',
        //     'password' => Hash::make('12121212'),

        //     'is_email_verified' => 1,
        //     'email_verified_at' => Carbon::now(),
        // ]);
        dd('done');

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
