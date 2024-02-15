<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $users = User::all();
        return view('test', compact('users'));

        // for ($i = 1; $i <= 100; $i++) {
        //     DB::table('job_locations')
        //         ->insert([
        //             'jobs_id' => rand(1, 1000),
        //             'locations_id' => rand(1, 100),
        //             'created_at' => Carbon::now(),
        //             'updated_at' => Carbon::now(),
        //         ]);
        // }
        // UPDATE `users` SET `gender` = in (MALE,FEMALE,OTHER) WHERE `id` = 1
        // for ($i = 1; $i <= 100; $i++) {
        //     DB::table('job_qualifications')
        //         ->insert([
        //             'jobs_id' => rand(1, 1000),
        //             'qualifications_id' => rand(1, 100),
        //             'created_at' => Carbon::now(),
        //             'updated_at' => Carbon::now(),
        //         ]);
        // }

        dd("done");
        // for ($i = 1; $i <= 100; $i++) {
        //     DB::table('job_user')
        //         ->insertGetId([
        //             'user_id' => rand(1, 100),
        //             'job_id' => rand(1, 1000),
        //             'created_at' => Carbon::now(),
        //             'updated_at' => Carbon::now(),
        //         ]);
        // }
        // // job_user 
        // for ($i = 1; $i <= 100; $i++) {
        //     DB::table('saved_jobs')
        //         ->insertGetId([
        //             'user_id' => rand(1, 100),
        //             'job_id' => rand(1, 1000),
        //             'created_at' => Carbon::now(),
        //             'updated_at' => Carbon::now(),
        //         ]);
        // }


        // saved_jobs
        //
        // 1000 of follows
        // for ($i = 1; $i <= 100; $i++) {
        //     $follow = DB::table('follows')
        //         ->insertGetId([
        //             'user_id' => rand(1, 100),
        //             'followable_id' => rand(1, 100),
        //             'followable_type' => rand(0, 1) ? 'App\Models\User' : 'App\Models\Company',
        //             'created_at' => Carbon::now(),
        //             'updated_at' => Carbon::now(),
        //         ]);
        // }


        // likes

        // for ($i = 1; $i <= 500; $i++) {
        //     $post = DB::table('likes')
        //         ->insertGetId([
        //             'likeable_id' => rand(1, 2500), // post 2500 or comment 4300
        //             // 'App\Models\User' or 'App\Models\Company'
        //             // 'likeable_type' => rand(0, 1) ? 'App\Models\Comment' : 'App\Models\Post',
        //             'likeable_type' => 'App\Models\Post',
        //             'authorable_id' => rand(1, 100),
        //             'authorable_type' => rand(0, 1) ? 'App\Models\User' : 'App\Models\Company',
        //             'created_at' => Carbon::now(),
        //             'updated_at' => Carbon::now(),
        //         ]);
        // }

        // for ($i = 1; $i <= 500; $i++) {
        //     $post = DB::table('posts')
        //         ->insertGetId([
        //             'authorable_id' => rand(1, 100),
        //             // 'App\Models\User' or 'App\Models\Company'
        //             'authorable_type' => rand(0, 1) ? 'App\Models\User' : 'App\Models\Company',
        //             'title' => 'This is post title ' . $i,
        //             'type' => 'text',
        //             'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
        //             'created_at' => Carbon::now(),
        //             'updated_at' => Carbon::now(),
        //         ]);
        // }
        // for ($j = 1; $j <= 1000; $j++) {
        //     DB::table('comments')
        //         ->insert([
        //             'post_id' => rand(1, 2500),
        //             'authorable_id' => rand(1, 100),
        //             'authorable_type' => rand(0, 1) ? 'App\Models\User' : 'App\Models\Company',
        //             'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
        //             'created_at' => Carbon::now(),
        //             'updated_at' => Carbon::now(),
        //         ]);
        // }
        // for ($j = 1; $j <= 1000; $j++) {
        //     DB::table('comments')
        //         ->insert([
        //             'post_id' => rand(1, 1000),
        //             'authorable_id' => rand(1, 100),
        //             'authorable_type' => rand(0, 1) ? 'App\Models\User' : 'App\Models\Company',
        //             'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
        //             'created_at' => Carbon::now(),
        //             'updated_at' => Carbon::now(),
        //         ]);
        // }

        dd("done");

        // for ($i = 1; $i <= 500; $i++) {
        //     $job = DB::table('jobs')
        //         ->insertGetId([
        //             'company_id' => rand(1, 100),
        //             'sub_profile_id' => rand(1, 100),
        //             'vacancy' => rand(1, 25),
        //             'min_salary' => rand(100000, 500000),
        //             'max_salary' => rand(500000, 1000000),
        //             'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
        //             'responsibility' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
        //             'benifits_perks' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
        //             'other_benifits' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
        //             'is_verified' => true,
        //             'is_featured' => true,
        //             'is_active' => true,
        //             'keywords' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
        //             'work_type' =>  array_rand(Config::get('constants.job.work_type')),
        //             'job_type' => array_rand(Config::get('constants.job.job_type')),
        //             'experience_level' => array_rand(Config::get('constants.job.experience_level')),
        //             'experience_type' => array_rand(Config::get('constants.job.experience_type')),
        //             'created_at' => Carbon::now(),
        //             'updated_at' => Carbon::now(),
        //         ]);
        //     $locations = DB::table('locations')
        //         ->inRandomOrder()
        //         ->limit(rand(1, 5))
        //         ->get();

        //     foreach ($locations as $location) {
        //         DB::table('job_locations')
        //             ->insert([
        //                 'jobs_id' => $job,
        //                 'locations_id' => $location->id,
        //                 'created_at' => Carbon::now(),
        //                 'updated_at' => Carbon::now(),
        //             ]);
        //     }

        //     $qualifications = DB::table('qualifications')
        //         ->inRandomOrder()
        //         ->limit(rand(1, 5))
        //         ->get();

        //     foreach ($qualifications as $qualification) {
        //         DB::table('job_qualifications')
        //             ->insert([
        //                 'jobs_id' => $job,
        //                 'qualifications_id' => $qualification->id,
        //                 'created_at' => Carbon::now(),
        //                 'updated_at' => Carbon::now(),
        //             ]);
        //     }
        // }

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

        dd("done");
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
        // dd("user done");


        // for ($i = 11; $i <= 100; $i++) {
        //     DB::table('profile_categories')->insert([
        //         'name' => 'Category ' . $i,
        //     ]);
        // }

        // // Insert 10 rows for Sub Profiles
        // for ($i = 11; $i <= 100; $i++) {
        //     DB::table('sub_profiles')->insert([
        //         'profile_category_id' => random_int(1, 10), // Assuming you have 10 categories already
        //         'name' => 'Sub Profile ' . $i,
        //     ]);
        // }

        // // Insert 10 rows for Qualifications
        // for ($i = 11; $i <= 100; $i++) {
        //     DB::table('qualifications')->insert([
        //         'name' => 'Qualification ' . $i,
        //     ]);
        // }

        // // Insert 10 rows for Locations
        // for ($i = 11; $i <= 100; $i++) {
        //     DB::table('locations')->insert([
        //         'city' => 'City ' . $i,
        //         'state' => 'State ' . $i,
        //         'country' => 'Country ' . $i,
        //         'pincode' => 10000 + $i,
        //     ]);
        // }

        dd("done");

        // https://res.cloudinary.com/career-vibe/video/upload/v1707803711/career-vibe/videos/wyuftapb9wobdxj3a5e5.mp4
        $id = "career-vibe/videos/wyuftapb9wobdxj3a5e5";
        return view('test', compact('id'));
        dd('test');
        DB::table('qualifications')->insert([
            // 'name' => 'B.E.',
            'name' => 'Bachelor of Engineering',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('qualifications')->insert([
            // 'name' => 'B.Tech.',
            'name' => 'Bachelor of Technology',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('qualifications')->insert([
            // 'name' => 'B.Sc.',
            'name' => 'Bachelor of Science',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('qualifications')->insert([
            // 'name' => 'B.Com.',
            'name' => 'Bachelor of Commerce',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('qualifications')->insert([
            // 'name' => 'B.A.',
            'name' => 'Bachelor of Arts',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('qualifications')->insert([
            // 'name' => 'M.E.',
            'name' => 'Master of Engineering',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('qualifications')->insert([
            // 'name' => 'M.Tech.',
            'name' => 'Master of Technology',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('qualifications')->insert([
            // 'name' => 'M.Sc.',
            'name' => 'Master of Science',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('qualifications')->insert([
            // 'name' => 'M.Com.',
            'name' => 'Master of Commerce',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('qualifications')->insert([
            // 'name' => 'M.A.',
            'name' => 'Master of Arts',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('qualifications')->insert([
            // 'name' => 'Ph.D.',
            'name' => 'Doctor of Philosophy',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('qualifications')->insert([
            // 'name' => 'Diploma',
            'name' => 'Diploma',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // mca
        DB::table('qualifications')->insert([
            // 'name' => 'M.C.A.',
            'name' => 'Master of Computer Applications',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // bca

        DB::table('qualifications')->insert([
            // 'name' => 'B.C.A.',
            'name' => 'Bachelor of Computer Applications',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // bba

        DB::table('qualifications')->insert([
            // 'name' => 'B.B.A.',
            'name' => 'Bachelor of Business Administration',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // mba

        DB::table('qualifications')->insert([
            // 'name' => 'M.B.A.',
            'name' => 'Master of Business Administration',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // b.e. computer

        DB::table('qualifications')->insert([
            // 'name' => 'B.E. Computer',
            'name' => 'Bachelor of Engineering in Computer',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // b.e. mechanical

        DB::table('qualifications')->insert([
            // 'name' => 'B.E. Mechanical',
            'name' => 'Bachelor of Engineering in Mechanical',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // b.e. civil

        DB::table('qualifications')->insert([
            // 'name' => 'B.E. Civil',
            'name' => 'Bachelor of Engineering in Civil',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // b.e. electrical

        DB::table('qualifications')->insert([
            // 'name' => 'B.E. Electrical',
            'name' => 'Bachelor of Engineering in Electrical',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // b.e. electronics

        DB::table('qualifications')->insert([
            // 'name' => 'B.E. Electronics',
            'name' => 'Bachelor of Engineering in Electronics',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // b.e. it

        DB::table('qualifications')->insert([
            // 'name' => 'B.E. IT',
            'name' => 'Bachelor of Engineering in Information Technology',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


        // b.e. mechatronics

        DB::table('qualifications')->insert([
            // 'name' => 'B.E. Mechatronics',
            'name' => 'Bachelor of Engineering in Mechatronics',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // b.e. chemical

        DB::table('qualifications')->insert([
            // 'name' => 'B.E. Chemical',
            'name' => 'Bachelor of Engineering in Chemical',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // b.e. production

        DB::table('qualifications')->insert([
            // 'name' => 'B.E. Production',
            'name' => 'Bachelor of Engineering in Production',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        dd("done");

        // $noOfUsers = 100;

        // for ($i = 1288; $i <= 1500; $i++) {
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




        // dd("user done");
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
        // dd("user done");
        // for ($i = 1; $i <= 5000; $i++) {
        //     $post = DB::table('posts')
        //         ->insertGetId([
        //             'authorable_id' => rand(1, 100),
        //             // 'App\Models\User' or 'App\Models\Company'
        //             'authorable_type' => rand(0, 1) ? 'App\Models\User' : 'App\Models\Company',
        //             'title' => 'This is post title ' . $i,
        //             'type' => 'text',
        //             'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
        //             'created_at' => Carbon::now(),
        //             'updated_at' => Carbon::now(),
        //         ]);
        // }
        // dd("user done");

        // for ($j = 1; $j <= 5000; $j++) {
        //     DB::table('comments')
        //         ->insert([
        //             'post_id' => rand(5000, 10000),
        //             'authorable_id' => rand(1, 100),
        //             'authorable_type' => rand(0, 1) ? 'App\Models\User' : 'App\Models\Company',
        //             'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
        //             'created_at' => Carbon::now(),
        //             'updated_at' => Carbon::now(),
        //         ]);
        // }
        // dd("user done");
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

        // // dd("admin done");

        // // profile_categories

        // DB::table('profile_categories')->insert([
        //     'name' => 'IT',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('profile_categories')->insert([
        //     'name' => 'Marketing',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('profile_categories')->insert([
        //     'name' => 'Sales',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('profile_categories')->insert([
        //     'name' => 'Finance',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('profile_categories')->insert([
        //     'name' => 'HR',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);


        // // sub_profiles => profile_category_id and name

        // DB::table('sub_profiles')->insert([
        //     'profile_category_id' => 1,
        //     'name' => 'Web Developer',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('sub_profiles')->insert([
        //     'profile_category_id' => 1,
        //     'name' => 'Android Developer',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('sub_profiles')->insert([
        //     'profile_category_id' => 1,
        //     'name' => 'iOS Developer',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('sub_profiles')->insert([
        //     'profile_category_id' => 1,
        //     'name' => 'UI/UX Designer',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('sub_profiles')->insert([
        //     'profile_category_id' => 2,
        //     'name' => 'Digital Marketing',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('sub_profiles')->insert([
        //     'profile_category_id' => 2,
        //     'name' => 'Content Marketing',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('sub_profiles')->insert([
        //     'profile_category_id' => 2,
        //     'name' => 'SEO',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('sub_profiles')->insert([
        //     'profile_category_id' => 2,
        //     'name' => 'Social Media Marketing',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('sub_profiles')->insert([
        //     'profile_category_id' => 3,
        //     'name' => 'Sales Executive',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('sub_profiles')->insert([
        //     'profile_category_id' => 3,
        //     'name' => 'Sales Manager',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('sub_profiles')->insert([
        //     'profile_category_id' => 3,
        //     'name' => 'Sales Head',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('sub_profiles')->insert([
        //     'profile_category_id' => 3,
        //     'name' => 'Business Development Executive',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('sub_profiles')->insert([
        //     'profile_category_id' => 4,
        //     'name' => 'Accountant',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('sub_profiles')->insert([
        //     'profile_category_id' => 4,
        //     'name' => 'Financial Analyst',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('sub_profiles')->insert([
        //     'profile_category_id' => 4,
        //     'name' => 'Financial Advisor',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('sub_profiles')->insert([
        //     'profile_category_id' => 4,
        //     'name' => 'Financial Manager',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('sub_profiles')->insert([
        //     'profile_category_id' => 5,
        //     'name' => 'HR Executive',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('sub_profiles')->insert([
        //     'profile_category_id' => 5,
        //     'name' => 'HR Manager',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('sub_profiles')->insert([
        //     'profile_category_id' => 5,
        //     'name' => 'HR Head',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('sub_profiles')->insert([
        //     'profile_category_id' => 5,
        //     'name' => 'HR Recruiter',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // // qualifications

        // DB::table('qualifications')->insert([
        //     'name' => 'B.E.',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     'name' => 'B.Tech.',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     'name' => 'B.Sc.',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     'name' => 'B.Com.',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     'name' => 'B.A.',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     'name' => 'M.E.',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     'name' => 'M.Tech.',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     'name' => 'M.Sc.',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     'name' => 'M.Com.',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     'name' => 'M.A.',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     'name' => 'Ph.D.',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     'name' => 'Diploma',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);
        // dd("done");

        // for ($i = 1; $i <= 10000; $i++) {
        //     $job = DB::table('jobs')
        //         ->insertGetId([
        //             'company_id' => rand(1, 100),
        //             'sub_profile_id' => rand(1, 20),
        //             'vacancy' => rand(1, 10),
        //             'min_salary' => rand(10000, 50000),
        //             'max_salary' => rand(50000, 100000),
        //             'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
        //             'responsibility' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
        //             'benifits_perks' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
        //             'other_benifits' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
        //             'is_verified' => true,
        //             'is_featured' => true,
        //             'is_active' => true,
        //             'keywords' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
        //             'work_type' => rand(0, 1) ? 'REMOTE' : 'WFO',
        //             'job_type' => rand(0, 1) ? 'FULL_TIME' : 'PART_TIME',
        //             'experience_level' => rand(0, 1) ? 'FRESHER' : 'EXPERIENCED',
        //             'experience_type' => rand(0, 1) ? 'ANY' : '1-2',
        //             'created_at' => Carbon::now(),
        //             'updated_at' => Carbon::now(),
        //         ]);

        //     $locations = DB::table('locations')
        //         ->inRandomOrder()
        //         ->limit(rand(1, 5))
        //         ->get();

        //     foreach ($locations as $location) {
        //         DB::table('job_locations')
        //             ->insert([
        //                 'jobs_id' => $job,
        //                 'locations_id' => $location->id,
        //                 'created_at' => Carbon::now(),
        //                 'updated_at' => Carbon::now(),
        //             ]);
        //     }

        //     $qualifications = DB::table('qualifications')
        //         ->inRandomOrder()
        //         ->limit(rand(1, 5))
        //         ->get();

        //     foreach ($qualifications as $qualification) {
        //         DB::table('job_qualifications')
        //             ->insert([
        //                 'jobs_id' => $job,
        //                 'qualifications_id' => $qualification->id,
        //                 'created_at' => Carbon::now(),
        //                 'updated_at' => Carbon::now(),
        //             ]);
        //     }
        // }

        // add random user or company post and comments
        dd("done");
        // for ($i = 1; $i <= 500; $i++) {
        //     $post = DB::table('posts')
        //         ->insertGetId([
        //             'authorable_id' => rand(1, 100),
        //             // 'App\Models\User' or 'App\Models\Company'
        //             'authorable_type' => rand(0, 1) ? 'App\Models\User' : 'App\Models\Company',
        //             'title' => 'This is post title ' . $i,
        //             'type' => 'text',
        //             'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
        //             'created_at' => Carbon::now(),
        //             'updated_at' => Carbon::now(),
        //         ]);
        // }
        // for ($j = 1; $j <= 100; $j++) {
        //     DB::table('comments')
        //         ->insert([
        //             'post_id' => rand(1, 500),
        //             'authorable_id' => rand(1, 100),
        //             'authorable_type' => rand(0, 1) ? 'App\Models\User' : 'App\Models\Company',
        //             'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
        //             'created_at' => Carbon::now(),
        //             'updated_at' => Carbon::now(),
        //         ]);
        // }
        // for ($j = 1; $j <= 1000; $j++) {
        //     DB::table('comments')
        //         ->insert([
        //             'post_id' => rand(1, 500),
        //             'authorable_id' => rand(1, 100),
        //             'authorable_type' => rand(0, 1) ? 'App\Models\User' : 'App\Models\Company',
        //             'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
        //             'created_at' => Carbon::now(),
        //             'updated_at' => Carbon::now(),
        //         ]);
        // }


        dd('done');

        $username = "John Doe";
        $url = "https://www.google.com";
        return view("mail.verifyEmail", compact([
            'username',
            'url'
        ]));
    }

    // public function test()
    // {
    //     return view("test");
    // }

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
