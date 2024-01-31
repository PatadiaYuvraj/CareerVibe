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
        dd(Uuid::uuid());
        /*
        return [
        'USER_TYPE' => [
            'user' => 'USER',
            'company' => 'COMPANY',
            'admin' => 'ADMIN',
        ],
        'USER_GUARD' => 'user',
        'COMPANY_GUARD' => 'company',
        'ADMIN_GUARD' => 'admin',
        'CLOUDINARY_FOLDER' => [
            'user' => 'career-vibe/users/profile_image',
            'company' => 'career-vibe/companies/profile_image',
            'admin' => 'career-vibe/admins/profile_image',
        ],
        'USER_RESUME_PATH' => "uploads/users/resumes",
        "APP_URL" => Env::get('APP_URL', 'http://localhost:8000'),
        "APP_NAME" => Env::get('APP_NAME', 'Career Vibe'),
        'pagination' => Env::get('PAGINATEVALUE', 10),
        'gender' => [
            "MALE" => 'Male',
            "FEMALE" => 'Female',
            "OTHER" => 'Other',
        ],
        "IS_NOTIFICATION_SERVICE_ENABLED" => Env::get('IS_NOTIFICATION_SERVICE_ENABLED', true),
        "IS_MAIL_SERVICE_ENABLED" => Env::get('IS_MAIL_SERVICE_ENABLED', true),
        "IS_FILE_UPLOAD_SERVICE_ENABLED" => Env::get('IS_FILE_UPLOAD_SERVICE_ENABLED', true),
        'mail' => [
            'email_verification' => true,
            'password_reset' => true,
            'change_password' => true,

        ],
        'post' => [
            'type' => [
            'TEXT' => 'text',
            'IMAGE' => 'image',
            'VIDEO' => 'video',
            ],
        ],
        'job' => [
            'work_type' => [
            'REMOTE' => 'Remote',
            'WFO' => 'Work From Office',
            'HYBRID' => 'Hybrid',
            ],
            'job_type' => [
            'FULL_TIME' => 'Full Time',
            'PART_TIME' => 'Part Time',
            'INTERNSHIP' => 'Internship',
            'CONTRACT' => 'Contract',
            ],
            'experience_level' => [
            'FRESHER' => 'Fresher',
            'EXPERIENCED' => 'Experienced',
            ],
            'experience_type' => [
            'ANY' => 'Any',
            '1-2' => '1-2',
            '2-3' => '2-3',
            '3-5' => '3-5',
            '5-8' => '5-8',
            '8-10' => '8-10',
            '10+' => '10+',
            ],
        ]
        ];
        */


        // DB::table('settings')
        //     ->insert([
        //         'key' => 'USER_TYPE',
        //         'value' => json_encode([
        //             'user' => 'USER',
        //             'company' => 'COMPANY',
        //             'admin' => 'ADMIN',
        //         ]),
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ]);





        dd('done');

        Artisan::call('migrate:fresh');

        DB::table('users')->insert([
            'name' => 'User 1',
            'email' => 'user1@user.com',
            'password' => Hash::make('12121212'),
            'is_email_verified' => 1,
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('users')->insert([
            'name' => 'User 2',
            'email' => 'user2@user.com',
            'password' => Hash::make('12121212'),

            'is_email_verified' => 1,
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('users')->insert([
            'name' => 'User 3',
            'email' => 'user3@user.com',
            'password' => Hash::make('12121212'),

            'is_email_verified' => 1,
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('users')->insert([
            'name' => 'User 4',
            'email' => 'user4@user.com',
            'password' => Hash::make('12121212'),

            'is_email_verified' => 1,
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('users')->insert([
            'name' => 'User 5',
            'email' => 'user5@user.com',
            'password' => Hash::make('12121212'),

            'is_email_verified' => 1,
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('companies')->insert([
            'name' => 'Company 1',
            'email' => 'company1@company.com',
            'password' => Hash::make('12121212'),
            'is_verified' => true,
            'is_email_verified' => 1,
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('companies')->insert([
            'name' => 'Company 2',
            'email' => 'company2@company.com',
            'password' => Hash::make('12121212'),
            'is_verified' => true,
            'is_email_verified' => 1,
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('companies')->insert([
            'name' => 'Company 3',
            'email' => 'company3@company.com',
            'password' => Hash::make('12121212'),
            'is_verified' => true,
            'is_email_verified' => 1,
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('companies')->insert([
            'name' => 'Company 4',
            'email' => 'company4@company.com',
            'password' => Hash::make('12121212'),
            'is_verified' => true,
            'is_email_verified' => 1,
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('companies')->insert([
            'name' => 'Company 5',
            'email' => 'company5@company.com',
            'password' => Hash::make('12121212'),
            'is_verified' => true,
            'is_email_verified' => 1,
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('admins')->insert([
            'name' => 'Admin 1',
            'email' => 'admin1@admin.com',
            'password' => Hash::make('12121212'),

            'is_email_verified' => 1,
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // locations

        DB::table('locations')->insert([
            'city' => 'Rajkot',
            'state' => 'Gujarat',
            'country' => 'India',
            'pincode' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('locations')->insert([
            'city' => 'Ahmedabad',
            'state' => 'Gujarat',
            'country' => 'India',
            'pincode' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('locations')->insert([
            'city' => 'Surat',
            'state' => 'Gujarat',
            'country' => 'India',
            'pincode' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('locations')->insert([
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'country' => 'India',
            'pincode' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('locations')->insert([
            'city' => 'Delhi',
            'state' => 'Delhi',
            'country' => 'India',
            'pincode' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('locations')->insert([
            'city' => 'Chennai',
            'state' => 'Tamil Nadu',
            'country' => 'India',
            'pincode' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('locations')->insert([
            'city' => 'Kolkata',
            'state' => 'West Bengal',
            'country' => 'India',
            'pincode' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('locations')->insert([
            'city' => 'Bengaluru',
            'state' => 'Karnataka',
            'country' => 'India',
            'pincode' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('locations')->insert([
            'city' => 'Hyderabad',
            'state' => 'Telangana',
            'country' => 'India',
            'pincode' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('locations')->insert([
            'city' => 'Pune',
            'state' => 'Maharashtra',
            'country' => 'India',
            'pincode' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

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


        for ($i = 1; $i <= 100; $i++) {
            $job = DB::table('jobs')
                ->insertGetId([
                    'company_id' => rand(1, 3),
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

        for ($i = 1; $i <= 50; $i++) {
            $post = DB::table('posts')
                ->insertGetId([
                    'authorable_id' => rand(1, 5),
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
                    'post_id' => rand(1, 50),
                    'authorable_id' => rand(1, 5),
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
