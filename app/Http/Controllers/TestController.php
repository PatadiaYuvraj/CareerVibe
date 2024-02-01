<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestController extends Controller
{
    public function test()
    {

        // $noOfUsers = 100;

        // for ($i = 1; $i <= $noOfUsers; $i++) {
        //     $user = DB::table('users')
        //         ->insertGetId([
        //             'name' => 'User ' . $i,
        //             'email' => 'user' . $i . '@user.com',
        //             'password' => Hash::make('12121212'),
        //             'is_email_verified' => 1,
        //             'email_verified_at' => Carbon::now(),
        //             'created_at' => Carbon::now(),
        //             'updated_at' => Carbon::now(),
        //         ]);
        // }

        for ($j = 1; $j <= 1000; $j++) {
            DB::table('comments')
                ->insert([
                    'post_id' => rand(1, 500),
                    'authorable_id' => rand(1, 100),
                    'authorable_type' => rand(0, 1) ? 'App\Models\User' : 'App\Models\Company',
                    'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
        }

        dd("user done");


        // $noOfCompanies = 100;

        // for ($i = 1; $i <= $noOfCompanies; $i++) {
        //     DB::table('companies')->insert([
        //         'name' => 'Company ' . $i,
        //         'email' => 'company' . $i . '@company.com',
        //         'password' => Hash::make('12121212'),
        //         'is_verified' => true,
        //         'is_email_verified' => 1,
        //         'email_verified_at' => Carbon::now(),
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ]);
        // }


        // dd("company done");
        // DB::table('admins')->insert([
        //     'name' => 'Admin 1',
        //     'email' => 'admin1@admin.com',
        //     'password' => Hash::make('12121212'),

        //     'is_email_verified' => 1,
        //     'email_verified_at' => Carbon::now(),
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // $noOfAdmins = 10;

        // for ($i = 1; $i <= $noOfAdmins; $i++) {
        //     DB::table('admins')->insert([
        //         'name' => 'Admin ' . $i,
        //         'email' => 'admin' . $i . '@admin.com',
        //         'password' => Hash::make('12121212'),

        //         'is_email_verified' => 1,
        //         'email_verified_at' => Carbon::now(),
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ]);
        // }

        // dd("admin done");

        // locations

        // DB::table('locations')->insert([
        //     'city' => 'Rajkot',
        //     'state' => 'Gujarat',
        //     'country' => 'India',
        //     'pincode' => null,
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('locations')->insert([
        //     'city' => 'Ahmedabad',
        //     'state' => 'Gujarat',
        //     'country' => 'India',
        //     'pincode' => null,
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('locations')->insert([
        //     'city' => 'Surat',
        //     'state' => 'Gujarat',
        //     'country' => 'India',
        //     'pincode' => null,
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('locations')->insert([
        //     'city' => 'Mumbai',
        //     'state' => 'Maharashtra',
        //     'country' => 'India',
        //     'pincode' => null,
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('locations')->insert([
        //     'city' => 'Delhi',
        //     'state' => 'Delhi',
        //     'country' => 'India',
        //     'pincode' => null,
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('locations')->insert([
        //     'city' => 'Chennai',
        //     'state' => 'Tamil Nadu',
        //     'country' => 'India',
        //     'pincode' => null,
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('locations')->insert([
        //     'city' => 'Kolkata',
        //     'state' => 'West Bengal',
        //     'country' => 'India',
        //     'pincode' => null,
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('locations')->insert([
        //     'city' => 'Bengaluru',
        //     'state' => 'Karnataka',
        //     'country' => 'India',
        //     'pincode' => null,
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('locations')->insert([
        //     'city' => 'Hyderabad',
        //     'state' => 'Telangana',
        //     'country' => 'India',
        //     'pincode' => null,
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('locations')->insert([
        //     'city' => 'Pune',
        //     'state' => 'Maharashtra',
        //     'country' => 'India',
        //     'pincode' => null,
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // dd("admin done");

        // profile_categories

        DB::table('profile_categories')->insert([
            'name' => 'IT',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('profile_categories')->insert([
            'name' => 'Marketing',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('profile_categories')->insert([
            'name' => 'Sales',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('profile_categories')->insert([
            'name' => 'Finance',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('profile_categories')->insert([
            'name' => 'HR',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


        // sub_profiles => profile_category_id and name

        DB::table('sub_profiles')->insert([
            'profile_category_id' => 1,
            'name' => 'Web Developer',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('sub_profiles')->insert([
            'profile_category_id' => 1,
            'name' => 'Android Developer',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('sub_profiles')->insert([
            'profile_category_id' => 1,
            'name' => 'iOS Developer',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('sub_profiles')->insert([
            'profile_category_id' => 1,
            'name' => 'UI/UX Designer',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('sub_profiles')->insert([
            'profile_category_id' => 2,
            'name' => 'Digital Marketing',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('sub_profiles')->insert([
            'profile_category_id' => 2,
            'name' => 'Content Marketing',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('sub_profiles')->insert([
            'profile_category_id' => 2,
            'name' => 'SEO',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('sub_profiles')->insert([
            'profile_category_id' => 2,
            'name' => 'Social Media Marketing',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('sub_profiles')->insert([
            'profile_category_id' => 3,
            'name' => 'Sales Executive',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('sub_profiles')->insert([
            'profile_category_id' => 3,
            'name' => 'Sales Manager',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('sub_profiles')->insert([
            'profile_category_id' => 3,
            'name' => 'Sales Head',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('sub_profiles')->insert([
            'profile_category_id' => 3,
            'name' => 'Business Development Executive',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('sub_profiles')->insert([
            'profile_category_id' => 4,
            'name' => 'Accountant',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('sub_profiles')->insert([
            'profile_category_id' => 4,
            'name' => 'Financial Analyst',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('sub_profiles')->insert([
            'profile_category_id' => 4,
            'name' => 'Financial Advisor',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('sub_profiles')->insert([
            'profile_category_id' => 4,
            'name' => 'Financial Manager',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('sub_profiles')->insert([
            'profile_category_id' => 5,
            'name' => 'HR Executive',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('sub_profiles')->insert([
            'profile_category_id' => 5,
            'name' => 'HR Manager',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('sub_profiles')->insert([
            'profile_category_id' => 5,
            'name' => 'HR Head',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('sub_profiles')->insert([
            'profile_category_id' => 5,
            'name' => 'HR Recruiter',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // qualifications

        DB::table('qualifications')->insert([
            'name' => 'B.E.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('qualifications')->insert([
            'name' => 'B.Tech.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('qualifications')->insert([
            'name' => 'B.Sc.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('qualifications')->insert([
            'name' => 'B.Com.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('qualifications')->insert([
            'name' => 'B.A.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('qualifications')->insert([
            'name' => 'M.E.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('qualifications')->insert([
            'name' => 'M.Tech.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('qualifications')->insert([
            'name' => 'M.Sc.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('qualifications')->insert([
            'name' => 'M.Com.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('qualifications')->insert([
            'name' => 'M.A.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('qualifications')->insert([
            'name' => 'Ph.D.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('qualifications')->insert([
            'name' => 'Diploma',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // dd("done");

        for ($i = 1; $i <= 100; $i++) {
            $job = DB::table('jobs')
                ->insertGetId([
                    'company_id' => rand(1, 100),
                    'sub_profile_id' => rand(1, 20),
                    'vacancy' => rand(1, 10),
                    'min_salary' => rand(10000, 50000),
                    'max_salary' => rand(50000, 100000),
                    'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
                    'responsibility' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
                    'benifits_perks' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
                    'other_benifits' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
                    'is_verified' => true,
                    'is_featured' => true,
                    'is_active' => true,
                    'keywords' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
                    'work_type' => rand(0, 1) ? 'REMOTE' : 'WFO',
                    'job_type' => rand(0, 1) ? 'FULL_TIME' : 'PART_TIME',
                    'experience_level' => rand(0, 1) ? 'FRESHER' : 'EXPERIENCED',
                    'experience_type' => rand(0, 1) ? 'ANY' : '1-2',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

            $locations = DB::table('locations')
                ->inRandomOrder()
                ->limit(rand(1, 5))
                ->get();

            foreach ($locations as $location) {
                DB::table('job_locations')
                    ->insert([
                        'jobs_id' => $job,
                        'locations_id' => $location->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
            }

            $qualifications = DB::table('qualifications')
                ->inRandomOrder()
                ->limit(rand(1, 5))
                ->get();

            foreach ($qualifications as $qualification) {
                DB::table('job_qualifications')
                    ->insert([
                        'jobs_id' => $job,
                        'qualifications_id' => $qualification->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
            }
        }

        // add random user or company post and comments

        for ($i = 1; $i <= 500; $i++) {
            $post = DB::table('posts')
                ->insertGetId([
                    'authorable_id' => rand(1, 100),
                    // 'App\Models\User' or 'App\Models\Company'
                    'authorable_type' => rand(0, 1) ? 'App\Models\User' : 'App\Models\Company',
                    'title' => 'This is post title ' . $i,
                    'type' => 'text',
                    'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
        }
        for ($j = 1; $j <= 100; $j++) {
            DB::table('comments')
                ->insert([
                    'post_id' => rand(1, 500),
                    'authorable_id' => rand(1, 100),
                    'authorable_type' => rand(0, 1) ? 'App\Models\User' : 'App\Models\Company',
                    'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
        }


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
