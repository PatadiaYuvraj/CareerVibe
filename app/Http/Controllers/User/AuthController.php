<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\ProfileCategory;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\AuthenticableService;
use App\Services\NavigationManagerService;
use App\Services\StorageManagerService;
use App\Services\MailableService;
use App\Services\NotifiableService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class AuthController extends Controller
{
    private User $user;
    private StorageManagerService $storageManagerService;
    private NotifiableService $notifiableService;
    private MailableService $mailableService;
    private int $paginate;
    private NavigationManagerService $navigationManagerService;
    private AuthenticableService $authenticableService;

    public function __construct(

        User $user,
        NotifiableService $notifiableService,
        MailableService $mailableService,
        StorageManagerService $storageManagerService,
        NavigationManagerService $navigationManagerService,
        AuthenticableService $authenticableService,
    ) {
        $this->user = $user;
        $this->notifiableService = $notifiableService;
        $this->mailableService = $mailableService;
        $this->storageManagerService = $storageManagerService;
        $this->navigationManagerService = $navigationManagerService;
        $this->authenticableService = $authenticableService;
        $this->paginate = Config::get('constants.pagination');
    }

    public function dashboard1()
    {
        $latestJobs = Job::select([
            'id',
            "sub_profile_id",
            'min_salary',
            'max_salary',
            "experience_level",
            'description',
            "job_type",
            "work_type",

        ])->with([
            'subProfile' => function ($query) {
                $query->select('id', 'name');
            },
        ])->withCount([
            'savedByUsers' => function ($query) {
                $query->where('user_id', auth()->id());
            }
        ])->orderBy('id', 'DESC')->limit(10)->get();

        $featuredJobs = Job::select([
            'id',
            "sub_profile_id",
            'min_salary',
            'max_salary',
            "experience_level",
            'description',
            "job_type",
            "work_type",

        ])->with([
            'subProfile' => function ($query) {
                $query->select('id', 'name');
            },
        ])->withCount([
            'savedByUsers' => function ($query) {
                $query->where('user_id', auth()->id());
            },
            'applyByUsers' => function ($query) {
                $query->where('user_id', auth()->id());
            }
        ])->where('is_featured', 1)->orderBy('id', 'DESC')->limit(10)->get();

        // $categories = ProfileCategory::limit(8)->select([
        //     'id',
        //     'name',
        // ])->withCount([
        //     'jobs'
        // ])->get();

        return $this->navigationManagerService->loadView('user.dashboard.index', compact(
            'latestJobs',
            'featuredJobs',
            // 'categories'
        ));
    }

    public function dashboard()
    {
        $latestJobs =
            // Cache::remember('latestJobs', now()->addMinutes(60), function () {
            //     return
            Job::with(['subProfile:id,name'])
            ->withCount(['savedByUsers' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
            ->orderByDesc('id')
            ->limit(10)
            ->get(['id', 'sub_profile_id', 'min_salary', 'max_salary', 'experience_level', 'description', 'job_type', 'work_type']);
        // });

        $featuredJobs =
            // Cache::remember('featuredJobs', now()->addMinutes(60), function () {
            //     return
            Job::with(['subProfile:id,name'])
            ->withCount([
                'savedByUsers' => function ($query) {
                    $query->where('user_id', auth()->id());
                },
                'applyByUsers' => function ($query) {
                    $query->where('user_id', auth()->id());
                }
            ])
            ->where('is_featured', 1)
            ->orderByDesc('id')
            ->limit(10)
            ->get(['id', 'sub_profile_id', 'min_salary', 'max_salary', 'experience_level', 'description', 'job_type', 'work_type']);
        // });

        $categories =
            Cache::remember('categories', now()->addMinutes(60), function () {
                return
                    ProfileCategory::limit(8)
                    ->withCount(['jobs'])
                    ->get(['id', 'name']);
            });

        return $this->navigationManagerService->loadView('user.dashboard.index', compact('latestJobs', 'featuredJobs', 'categories'));
    }


    public function login()
    {
        return $this->navigationManagerService->loadView('user.auth.login');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            "email" => [
                "required",
                "email",
                function ($attribute, $value, $fail) {
                    $user = $this->authenticableService->getUserByEmail($value);
                    if (!$user) {
                        return $fail(__('The email is not registered.'));
                    }
                },
                // check email verification
                function ($attribute, $value, $fail) {
                    $user = $this->authenticableService->getUserByEmail($value);
                    if ($user && !$user->is_email_verified) {
                        return $fail(__('The email is not verified.'));
                    }
                },
                // user is_active
                function ($attribute, $value, $fail) {
                    $user = $this->authenticableService->getUserByEmail($value);
                    if ($user && !$user->is_active) {
                        return $fail(__('The user is not active.'));
                    }
                }
            ],
            "password" => [
                "required",
                "min:6",
                "max:20",
                function ($attribute, $value, $fail) {
                    $user = $this->authenticableService->getUserByEmail(request()->get('email'));
                    if ($user && !$this->authenticableService->verifyPassword($value, $user->password)) {
                        return $fail(__('The password is incorrect.'));
                    }
                }
            ]
        ]);
        $data = [
            "email" => $request->get("email"),
            "password" => $request->get("password")
        ];


        $user = $this->authenticableService->getUserByEmail($data['email']);

        // user is_active
        if ($user && !$user->is_active) {
            return $this->navigationManagerService->redirectRoute('user.login', [], 302, [], false, ["warning" => "User is not active"]);
        }

        // check email verification
        if ($user && !$user->is_email_verified) {
            return $this->navigationManagerService->redirectRoute('user.login', [], 302, [], false, ["warning" => "Verify your email to login"]);
        }

        if ($user && $user->is_email_verified && $this->authenticableService->loginUser($data)) {
            return $this->navigationManagerService->redirectRoute('user.dashboard', [], 302, [], false, ["success" => "You're Logged In"]);
        }
        return $this->navigationManagerService->redirectRoute('user.login', [], 302, [], false, ["warning" => "Invalid Credentials"]);
    }

    public function register()
    {
        return $this->navigationManagerService->loadView('user.auth.register');
    }

    public function doRegister(Request $request)
    {
        $request->validate([
            "name" => [
                "required",
                "string",
                "max:100",
            ],
            "email" => [
                "required",
                "email",
                function ($attribute, $value, $fail) {
                    $user = $this->authenticableService->getUserByEmail($value);
                    if ($user) {
                        return $fail(__('The email is already registered.'));
                    }
                },
            ],
            "password" => [
                "required",
                "min:6",
                "max:20",
            ],
            "confirm_password" => [
                "required",
                "min:6",
                "max:20",
                "same:password",
            ]
        ]);

        $token = $this->authenticableService->generateEmailVerificationToken();
        $data = [
            "name" => $request->get("name"),
            "email" => $request->get("email"),
            "password" => $request->get("password"),
            "email_verification_token" => $token,
            'is_email_verified' => false,
        ];

        $details = [
            'username' => $data['name'],
            'url' => $this->authenticableService->generateUserEmailVerificationLink('user.verifyEmail', $token),
        ];

        // send mail
        $this->mailableService->emailVerificationMail($data['email'], $details);


        $isCreated = $this->authenticableService->registerUser($data);

        if ($isCreated) {
            return $this->navigationManagerService->redirectRoute('user.login', [], 302, [], false, ["success" => "Verification Link Sent To Your Email"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User Not Registered"]);
    }

    public function verifyEmail($token)
    {
        $user = $this->user->where('email_verification_token', $token)->first();
        if (!$user) {
            return $this->navigationManagerService->redirectRoute('user.login', [], 302, [], false, ["warning" => "Invalid Token"]);
        }
        $data = [
            "is_email_verified" => true,
            "email_verification_token" => null,
            "email_verified_at" => now(),
        ];
        $isUpdated = $this->user->where('id', $user->id)->update($data);
        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('user.login', [], 302, [], false, ["success" => "Email Verified Successfully"]);
        }
        return $this->navigationManagerService->redirectRoute('user.login', [], 302, [], false, ["warning" => "Email Not Verified"]);
    }

    public function forgotPassword()
    {
        return $this->navigationManagerService->loadView('user.auth.forgot-password');
    }

    public function doForgotPassword(Request $request)
    {
        $request->validate([
            "email" => [
                "required",
                "email",
                function ($attribute, $value, $fail) {
                    $user = $this->authenticableService->getUserByEmail($value);
                    if (!$user) {
                        return $fail(__('The email is not registered.'));
                    }
                },
                function ($attribute, $value, $fail) {
                    $user = $this->authenticableService->getUserByEmail($value);
                    if ($user && !$user->is_email_verified) {
                        return $fail(__('The email is not verified.'));
                    }
                },
            ],
        ]);

        $token = $this->authenticableService->generatePasswordResetToken();
        $data = [
            "email" => $request->get("email"),
            "password_reset_token" => $token,
        ];

        $details = [
            'username' => $data['email'],
            'url' => $this->authenticableService->generateUserPasswordResetLink('user.resetPassword', $token),
        ];

        // send mail
        $this->mailableService->passwordResetMail($data['email'], $details);

        $isUpdated = $this->user->where('email', $data['email'])->update($data);

        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('user.login', [], 302, [], false, ["success" => "Reset Password Link Sent Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Reset Password Link Not Sent"]);
    }

    public function resetPassword($token)
    {
        $user = $this->user->where('password_reset_token', $token)->first();
        if (!$user) {
            return $this->navigationManagerService->redirectRoute('user.login', [], 302, [], false, ["warning" => "Invalid Token"]);
        }
        return $this->navigationManagerService->loadView('user.auth.reset-password', compact('token'));
    }
    public function doResetPassword(Request $request, $token)
    {
        $request->validate([
            "password" => [
                "required",
                "min:6",
                "max:20",
            ],
            "confirm_password" => [
                "required",
                "min:6",
                "max:20",
                "same:password",
            ]
        ]);

        $user = $this->user->where('password_reset_token', $token)->first();
        if (!$user) {
            return $this->navigationManagerService->redirectRoute('user.login', [], 302, [], false, ["warning" => "Invalid Token"]);
        }

        $data = [
            "password" => $this->authenticableService->passwordHash($request->get("password")),
            "password_reset_token" => null,
        ];

        $isUpdated = $this->user->where('id', $user->id)->update($data);

        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('user.login', [], 302, [], false, ["success" => "Password Reset Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Password Not Reset"]);
    }

    public function logout()
    {
        $this->authenticableService->logoutUser();
        return $this->navigationManagerService->redirectRoute('user.login', [], 302, [], false, ["success" => "You're Logged Out"]);
    }

    public function changePassword()
    {
        return $this->navigationManagerService->loadView('user.profile.change-password');
    }

    public function doChangePassword(Request $request)
    {
        // if (!$this->authenticableService->isUser()) {
        //     return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You are not authorized"]);
        // }

        $id = $this->authenticableService->getUser()->id;
        $request->validate([
            "currentPassword" => [
                "required",
                function ($attribute, $value, $fail) use ($id) {
                    $user = $this->user->find($id);
                    if (!$this->authenticableService->verifyPassword($value, $user->password)) {
                        return $fail(__('The current password is incorrect.'));
                    }
                },
            ],
            "newPassword" => [
                "required",
                "min:6",
                "max:20",
                function ($attribute, $value, $fail) use ($id) {
                    $user = $this->user->find($id);
                    if ($this->authenticableService->verifyPassword($value, $user->password)) {
                        return $fail(__('The new password must be different from current password.'));
                    }
                }
            ],
            "confirmPassword" => [
                "required",
                "min:6",
                "max:20",
                "same:newPassword"
            ]
        ]);

        $data = [
            "password" => $this->authenticableService->passwordHash($request->get("newPassword")),
        ];

        $isUpdated = $this->user->find($id)->update($data);

        $user = $this->user->find($id);
        $details = [
            'title' => 'Password Changed',
            'body' => 'Your password is changed'
        ];
        $this->notifiableService->sendNotification($user, $details['body']);
        $this->mailableService->sendMail($user->email, $details);

        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('user.profile.changePassword', [], 302, [], false, ["success" => "Password Updated Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Password Not Updated"]);
    }

    public function editProfile()
    {
        return $this->navigationManagerService->loadView('user.profile.edit-profile');
    }

    public function updateProfile(Request $request)
    {
        // if (!$this->authenticableService->isUser()) {
        //     return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You are not authorized"]);
        // }

        $user = $this->authenticableService->getUser();

        $request->validate(
            [
                "name" => [
                    "required",
                    "string",
                    "max:100",
                    function ($attribute, $value, $fail) use ($user) {
                        $isExist = $this->user->where('id', '!=', $user->id)->where('name', $value)->get()->ToArray();
                        if ($isExist) {
                            return $fail(__('The name is already taken.'));
                        }
                    },
                ],
            ],
            [
                "name.required" => "Name is required",
                "name.string" => "Name should be string",
                "name.max" => "Name should not be greater than 100 characters",

            ]
        );

        $data = [
            "name" => $request->get("name"),
            // "email" => $request->get("email")

        ];

        $data['contact'] = $data['city'] = $data['headline'] = $data['gender'] = $data['education'] = $data['interest'] = $data['hobby'] = $data['about'] = $data['experience'] = null;

        if ($request->contact) {
            $request->validate(
                [
                    "contact" => [
                        "required",
                        "regex:/^[0-9]{10}$/",
                    ],
                ],
                [
                    "contact.regex" => "Contact number should be 10 digit",
                ]
            );
            $data["contact"] = $request->contact;
        }

        if ($request->city) {
            $request->validate([
                "city" => [
                    "required",
                    "string",
                    "max:30",
                ],
            ]);
            $data["city"] = $request->city;
        }

        if ($request->headline) {
            $request->validate([
                "headline" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data["headline"] = $request->headline;
        }

        if ($request->get('gender')) {
            $request->validate([
                'gender' => [
                    'required',
                    'string',
                    'in:' . implode(',', array_keys(Config::get('constants.gender'))),
                ],
            ]);
            $data['gender'] = $request->gender;
        }


        if ($request->education) {
            $request->validate([
                "education" => [
                    "required",
                    "string",
                    "max:200",
                ],
            ]);
            $data["education"] = $request->education;
        }

        if ($request->interest) {
            $request->validate([
                "interest" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data["interest"] = $request->interest;
        }

        if ($request->hobby) {
            $request->validate([
                "hobby" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data["hobby"] = $request->hobby;
        }

        if ($request->about) {
            $request->validate([
                "about" => [
                    "required",
                    "string",
                    "max:500",
                ],
            ]);
            $data["about"] = $request->about;
        }

        if ($request->experience) {
            $request->validate([
                "experience" => [
                    "required",
                    "string",
                    "max:200",
                ],
            ]);
            $data["experience"] = $request->experience;
        }
        $isUpdated = $this->user->find($user->id)->update($data);

        if ($isUpdated) {

            $user = $this->user->find($user->id);
            $details = [
                'title' => 'Profile Updated',
                'body' => 'Your profile is updated'
            ];
            $this->notifiableService->sendNotification($user, $details['body']);
            $this->mailableService->sendMail($user->email, $details);
            return $this->navigationManagerService->redirectRoute('user.profile.editProfile', [], 302, [], false, ["success" => "Profile Updated Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Not Updated"]);
    }

    public function editProfileImage()
    {
        return $this->navigationManagerService->loadView('user.profile.edit-profile-image');
    }

    public function updateProfileImage(Request $request)
    {
        if (!$this->authenticableService->isUser()) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You are not authorized"]);
        }
        $request->validate(
            [
                "profile_image_url" => [
                    "required",
                    "image",
                    "mimes:jpeg,png,jpg",
                    "max:2048",
                ],
            ],
            [
                "profile_image_url.required" => "Profile Image is required",
                "profile_image_url.image" => "Profile Image should be image",
                "profile_image_url.mimes" => "Profile Image should be jpeg, png, jpg",
                "profile_image_url.max" => "Profile Image should not be greater than 2MB",
            ]
        );

        $user = $this->authenticableService->getUser();

        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }

        if ($user->profile_image_url) {
            $public_ids = $user->profile_image_public_id;
            $this->storageManagerService->deleteFromCloudinary($public_ids);
        }

        // $this->storageManagerService->uploadToCloudinary($request, "USER", $user->id);
        $this->storageManagerService->uploadToCloudinary(
            $request,
            'profile_image_url',
            Config::get('constants.CLOUDINARY_FOLDER_DEMO.user-profile-image'),
            'image',
            User::class,
            $user->id,
            Config::get('constants.TAGE_NAMES.user-profile-image')
        );

        $data = [
            "profile_image_public_id" => null,
            "profile_image_url" => null,
        ];

        $isUpdated = $this->user->find($user->id)->update($data);
        if ($isUpdated) {
            $details = [
                'title' => 'Profile Image Updated',
                'body' => 'Your profile image is updated'
            ];
            $this->notifiableService->sendNotification($user, $details['body']);
            $this->mailableService->sendMail($user->email, $details);
            return $this->navigationManagerService->redirectRoute('user.profile.editProfileImage', [], 302, [], false, ["success" => "Profile Image Updated Successfully"]);
        }

        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Image Not Updated"]);
    }

    public function deleteProfileImage()
    {
        if (!$this->authenticableService->isUser()) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You are not authorized"]);
        }

        $id = $this->authenticableService->getUser()->id;

        $user = $this->user->find($id);

        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }

        if ($user->profile_image_url) {
            $public_ids = $user->profile_image_public_id;
            $this->storageManagerService->deleteFromCloudinary($public_ids);
        }

        $data = [
            "profile_image_public_id" => null,
            "profile_image_url" => null,
        ];

        $isUpdated = $this->user->where('id', $id)->update($data);

        if ($isUpdated) {

            $user = $this->user->find($id);
            $details = [
                'title' => 'Profile Image Deleted',
                'body' => 'Your profile image is deleted'
            ];
            $this->notifiableService->sendNotification($user, $details['body']);
            $this->mailableService->sendMail($user->email, $details);
            return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Profile Image Deleted Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Image Not Deleted"]);
    }

    public function editResumePdf()
    {
        return $this->navigationManagerService->loadView('user.profile.edit-resume-pdf');
    }

    public function updateResumePdf(Request $request)
    {
        if (!$this->authenticableService->isUser()) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You are not authorized"]);
        }

        $id = $this->authenticableService->getUser()->id;

        $request->validate(
            [
                "resume_pdf_url" => [
                    "required",
                    "mimes:pdf",
                    "max:2048",
                ],
            ],
            [
                "resume_pdf_url.required" => "Resume Pdf is required",
                "resume_pdf_url.mimes" => "Resume Pdf should be pdf",
                "resume_pdf_url.max" => "Resume Pdf should not be greater than 2MB",
            ]
        );
        $user = $this->user->find($id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        if ($user->resume_pdf_url) {
            // $this->storageManagerService->deleteFromLocal($user->resume_pdf_url);
            $public_ids = $user->resume_pdf_public_id;
            $this->storageManagerService->deleteFromCloudinary($public_ids);
        }
        // $stored_path = $this->storageManagerService->uploadToLocal($request, "resume_pdf_url");
        $this->storageManagerService->uploadToCloudinary(
            $request,
            'resume_pdf_url',
            Config::get('constants.CLOUDINARY_FOLDER_DEMO.user-resume'),
            'pdf',
            User::class,
            $user->id,
            Config::get('constants.TAGE_NAMES.user-resume')
        );
        $data = [
            "resume_pdf_url" => null,
            "resume_pdf_public_id" => null,
        ];
        $isUpdated = $this->user->where('id', $id)->update($data);
        if ($isUpdated) {

            $user = $this->user->find($id);
            $details = [
                'title' => 'Resume Updated',
                'body' => 'Your resume is updated'
            ];
            // UNCOMMENT: To send notification
            $this->notifiableService->sendNotification($user, $details['body']);
            // UNCOMMENT: To send mail
            $this->mailableService->sendMail($user->email, $details);
            return $this->navigationManagerService->redirectRoute('user.profile.editResumePdf', [], 302, [], false, ["success" => "User resume is updated"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User resume is not updated"]);
    }

    public function deleteResumePdf()
    {
        if (!$this->authenticableService->isUser()) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You are not authorized"]);
        }

        $id =  $this->authenticableService->getUser()->id;

        $user = $this->user->find($id);

        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }

        if ($user->resume_pdf_url) {
            $public_ids = $user->resume_pdf_public_id;
            $this->storageManagerService->deleteFromCloudinary($public_ids);
        }

        $data = [
            "resume_pdf_public_id" => null,
            "resume_pdf_url" => null,
        ];

        $isUpdated = $this->user->where('id', $id)->update($data);

        if ($isUpdated) {

            $user = $this->user->find($id);
            $details = [
                'title' => 'Profile Image Deleted',
                'body' => 'Your profile image is deleted'
            ];
            return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Resume Pdf Deleted Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Resume Pdf Not Deleted"]);
    }
}
