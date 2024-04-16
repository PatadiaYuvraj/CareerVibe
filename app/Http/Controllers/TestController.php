<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessRecordsChunk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Process;
use League\Csv\Reader;
use League\Csv\Statement;

class TestController extends Controller
{

    public function test()
    {
        dd("TEST");
        // $noOfAdmins = 3;

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

        // $noOfUsers = 20;

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

        // $noOfCompanies = 20;

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

        // DB::table('qualifications')->insert([
        //     // 'name' => 'B.E.',
        //     'name' => 'Bachelor of Engineering',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     // 'name' => 'B.Tech.',
        //     'name' => 'Bachelor of Technology',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     // 'name' => 'B.Sc.',
        //     'name' => 'Bachelor of Science',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     // 'name' => 'B.Com.',
        //     'name' => 'Bachelor of Commerce',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     // 'name' => 'B.A.',
        //     'name' => 'Bachelor of Arts',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     // 'name' => 'M.E.',
        //     'name' => 'Master of Engineering',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     // 'name' => 'M.Tech.',
        //     'name' => 'Master of Technology',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     // 'name' => 'M.Sc.',
        //     'name' => 'Master of Science',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     // 'name' => 'M.Com.',
        //     'name' => 'Master of Commerce',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     // 'name' => 'M.A.',
        //     'name' => 'Master of Arts',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     // 'name' => 'Ph.D.',
        //     'name' => 'Doctor of Philosophy',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     // 'name' => 'Diploma',
        //     'name' => 'Diploma',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     // 'name' => 'M.C.A.',
        //     'name' => 'Master of Computer Applications',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('qualifications')->insert([
        //     // 'name' => 'B.C.A.',
        //     'name' => 'Bachelor of Computer Applications',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);


        // DB::table('qualifications')->insert([
        //     // 'name' => 'B.B.A.',
        //     'name' => 'Bachelor of Business Administration',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);


        // DB::table('qualifications')->insert([
        //     // 'name' => 'M.B.A.',
        //     'name' => 'Master of Business Administration',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);


        // DB::table('qualifications')->insert([
        //     // 'name' => 'B.E. Computer',
        //     'name' => 'Bachelor of Engineering in Computer',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);


        // DB::table('qualifications')->insert([
        //     // 'name' => 'B.E. Mechanical',
        //     'name' => 'Bachelor of Engineering in Mechanical',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);


        // DB::table('qualifications')->insert([
        //     // 'name' => 'B.E. Civil',
        //     'name' => 'Bachelor of Engineering in Civil',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);


        // DB::table('qualifications')->insert([
        //     // 'name' => 'B.E. Electrical',
        //     'name' => 'Bachelor of Engineering in Electrical',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);


        // DB::table('qualifications')->insert([
        //     // 'name' => 'B.E. Electronics',
        //     'name' => 'Bachelor of Engineering in Electronics',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);


        // DB::table('qualifications')->insert([
        //     // 'name' => 'B.E. IT',
        //     'name' => 'Bachelor of Engineering in Information Technology',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);



        // DB::table('qualifications')->insert([
        //     // 'name' => 'B.E. Mechatronics',
        //     'name' => 'Bachelor of Engineering in Mechatronics',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);


        // DB::table('qualifications')->insert([
        //     // 'name' => 'B.E. Chemical',
        //     'name' => 'Bachelor of Engineering in Chemical',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);


        // DB::table('qualifications')->insert([
        //     // 'name' => 'B.E. Production',
        //     'name' => 'Bachelor of Engineering in Production',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        for ($company = 1; $company <= 20; $company++) {
            for ($i = 1; $i <= 20; $i++) {
                $job = DB::table('jobs')
                    ->insertGetId([
                        'company_id' => $company,
                        'sub_profile_id' => rand(1, 20),
                        'vacancy' => rand(1, 25),
                        'min_salary' => (int)rand(10, 45) . "000",
                        'max_salary' => (int)rand(46, 99) . "000",
                        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
                        'responsibility' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
                        'benifits_perks' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
                        'other_benifits' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
                        'is_verified' => true,
                        'is_featured' => true,
                        'is_active' => true,
                        'keywords' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
                        'work_type' =>  array_rand(Config::get('constants.job.work_type')),
                        'job_type' => array_rand(Config::get('constants.job.job_type')),
                        'experience_level' => array_rand(Config::get('constants.job.experience_level')),
                        'experience_type' => array_rand(Config::get('constants.job.experience_type')),
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
        }


        for ($i = 1; $i <= 100; $i++) {
            DB::table('applied_jobs')
                ->insertGetId([
                    'user_id' => rand(1, 20),
                    'job_id' => rand(1, 400),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
        }
        // applied_jobs
        for ($i = 1; $i <= 100; $i++) {
            DB::table('saved_jobs')
                ->insertGetId([
                    'user_id' => rand(1, 20),
                    'job_id' => rand(1, 400),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
        }



        for ($u = 1; $u <= 20; $u++) {
            for ($i = 1; $i <= 10; $i++) {
                $post = DB::table('posts')
                    ->insertGetId([
                        'authorable_id' => $u,
                        'authorable_type' => 'App\Models\User',
                        'title' => 'Post ' . $i . ' by user ' . $u,
                        'type' => 'TEXT',
                        'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
            }
        }
        for ($c = 1; $c <= 20; $c++) {
            for ($i = 1; $i <= 10; $i++) {
                $post = DB::table('posts')
                    ->insertGetId([
                        'authorable_id' => $c,
                        'authorable_type' => 'App\Models\Company',
                        'title' => 'Post ' . $i . ' by company ' . $c,
                        'type' => 'TEXT',
                        'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
            }
        }
        for ($u = 1; $u <= 10; $u++) {
            for ($i = 1; $i <= 10; $i++) {
                DB::table('comments')
                    ->insert([
                        'post_id' => rand(1, 400),
                        'authorable_id' => $u,
                        'authorable_type' => 'App\Models\User',
                        'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
            }
        }

        for ($u = 1; $u <= 10; $u++) {
            for ($i = 1; $i <= 10; $i++) {
                DB::table('comments')
                    ->insert([
                        'post_id' => rand(1, 400),
                        'authorable_id' => $u,
                        'authorable_type' => 'App\Models\Company',
                        'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
            }
        }

        for ($i = 1; $i <= 50; $i++) {
            $post = DB::table('likes')
                ->insertGetId([
                    'likeable_id' => rand(1, 2000),
                    'likeable_type' => 'App\Models\Comment',
                    'authorable_id' => rand(1, 20),
                    'authorable_type' => 'App\Models\User',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
        }

        for ($i = 1; $i <= 50; $i++) {
            $post = DB::table('likes')
                ->insertGetId([
                    'likeable_id' => rand(1, 2000),
                    'likeable_type' => 'App\Models\Comment',
                    'authorable_id' => rand(1, 20),
                    'authorable_type' => 'App\Models\Company',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
        }


        for ($i = 1; $i <= 100; $i++) {
            $follow = DB::table('follows')
                ->insertGetId([
                    'user_id' => rand(1, 20),
                    'followable_id' => rand(1, 20),
                    'followable_type' => rand(0, 1) ? 'App\Models\User' : 'App\Models\Company',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
        }

        // dd("test");
        // $d = [
        //     ["id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at"], ["1", "Gregory Bednar Sr.", "ernser.antwan@example.org", "2024-02-22 06:49:11", "", "fuF20WjNZ7", "2024-02-22 06:49:18", "2024-02-22 06:49:18"]
        // ];
        // $records = Reader::createFromPath(public_path('users.csv'), 'r');
        // // dd(collect($records->getRecords())->toArray());
        // // $DATA = $records->getRecords();


        // $stmt = Statement::create()->offset(1)->limit(100);
        // $data = $stmt->process($records);
        // ProcessRecordsChunk::dispatch($data);
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
