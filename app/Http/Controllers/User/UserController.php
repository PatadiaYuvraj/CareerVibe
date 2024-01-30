<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Follow;
use App\Models\Post;
use App\Models\User;
use App\Services\AuthenticableService;
use App\Services\NavigationManagerService;
use App\Services\StorageManagerService;
use App\Services\MailableService;
use App\Services\NotifiableService;
use Illuminate\Support\Facades\Config;

class UserController extends Controller
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

    public function dashboard()
    {
        return $this->navigationManagerService->loadView('user.dashboard.index');
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

        // check email verification
        $user = $this->authenticableService->getUserByEmail($data['email']);
        if (!$user->is_email_verified) {
            return $this->navigationManagerService->redirectRoute('user.login', [], 302, [], false, ["warning" => "Verify your email to login"]);
        }

        if ($this->authenticableService->loginUser($data)) {
            return $this->navigationManagerService->redirectRoute('user.dashboard', [], 302, [
                'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => 'Sat, 26 Jul 1997 05:00:00 GMT'
            ], true, ["success" => "You're Logged In"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Invalid Credentials"]);
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

    // fogot password
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
        return $this->navigationManagerService->loadView('user.auth.change-password');
    }

    public function doChangePassword(Request $request)
    {
        if (!$this->authenticableService->isUser()) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You are not authorized"]);
        }

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
            return $this->navigationManagerService->redirectRoute('user.dashboard', [], 302, [], false, ["success" => "Password Updated Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Password Not Updated"]);
    }

    public function editProfile()
    {
        return $this->navigationManagerService->loadView('user.auth.edit-profile');
    }

    public function updateProfile(Request $request)
    {
        if (!$this->authenticableService->isUser()) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You are not authorized"]);
        }

        $id = $this->authenticableService->getUser()->id;

        $request->validate([
            "name" => [
                "required",
                "string",
                "max:100",
                function ($attribute, $value, $fail) use ($id) {
                    $isExist = $this->user->where('id', '!=', $id)->where('name', $value)->get()->ToArray();
                    if ($isExist) {
                        return $fail($attribute . ' is already exist.');
                    }
                },
            ],
            "email" => [
                "required",
                "email",
                function ($attribute, $value, $fail) use ($id) {
                    $isExist = $this->user->where('id', '!=', $id)->where('email', $value)->get()->ToArray();
                    if ($isExist) {
                        return $fail($attribute . ' is already exist.');
                    }
                },
            ]
        ]);

        $data = [
            "name" => $request->get("name"),
            "email" => $request->get("email")
        ];

        $data['contact'] =  $data['city'] = $data['headline'] = $data['gender'] = $data['education'] = $data['interest'] = $data['hobby'] = $data['about'] = $data['experience'] = null;
        if ($request->contact) {
            $request->validate([
                "contact" => [
                    "required",
                    "string",
                    "max:15",
                ],
            ]);
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
                    'max:10',
                    'in:MALE,FEMALE,OTHER'
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

        $isUpdated = $this->user->find($id)->update($data);

        if ($isUpdated) {

            $user = $this->user->find($id);
            $details = [
                'title' => 'Profile Updated',
                'body' => 'Your profile is updated'
            ];
            $this->notifiableService->sendNotification($user, $details['body']);
            $this->mailableService->sendMail($user->email, $details);
            return $this->navigationManagerService->redirectRoute('user.dashboard', [], 302, [], false, ["success" => "Profile Updated Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Not Updated"]);
    }

    public function editProfileImage()
    {
        return $this->navigationManagerService->loadView('user.auth.edit-profile-image');
    }

    public function updateProfileImage(Request $request)
    {
        if (!$this->authenticableService->isUser()) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You are not authorized"]);
        }

        $request->validate([
            "profile_image_url" => [
                "required",
                "image",
                "mimes:jpeg,png,jpg",
                "max:2048",
            ],
        ]);

        $user = $this->authenticableService->getUser();

        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }

        if ($user->profile_image_url) {
            $public_ids = $user->profile_image_public_id;
            $this->storageManagerService->deleteFromCloudinary($public_ids);
        }

        $this->storageManagerService->uploadToCloudinary($request, "USER", $user->id);

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
            return $this->navigationManagerService->redirectRoute('user.dashboard', [], 302, [], false, ["success" => "Profile Image Updated Successfully"]);
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
            return $this->navigationManagerService->redirectRoute('user.dashboard', [], 302, [], false, ["success" => "Profile Image Deleted Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Image Not Deleted"]);
    }

    public function editResumePdf()
    {
        return $this->navigationManagerService->loadView('user.auth.edit-resume-pdf');
    }

    public function updateResumePdf(Request $request)
    {
        if (!$this->authenticableService->isUser()) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You are not authorized"]);
        }

        $id = $this->authenticableService->getUser()->id;

        $request->validate([
            "resume_pdf_url" => [
                "required",
                "mimes:pdf",
                "max:2048",
            ],
        ]);
        $user = $this->user->find($id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        if ($user->resume_pdf_url) {
            $this->storageManagerService->deleteFromLocal($user->resume_pdf_url);
        }
        $stored_path = $this->storageManagerService->uploadToLocal($request, "resume_pdf_url");
        $data = [
            "resume_pdf_url" => $stored_path,
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
            return $this->navigationManagerService->redirectRoute('user.dashboard', [], 302, [], false, ["success" => "User resume is updated"]);
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
            unlink($user->resume_pdf_url);
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
            return $this->navigationManagerService->redirectRoute('user.dashboard', [], 302, [], false, ["success" => "Resume Pdf Deleted Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Resume Pdf Not Deleted"]);
    }

    public function allUsers()
    {
        $current_user_id =  $this->authenticableService->getUser()->id;
        $users = $this->user
            ->where('id', '!=', $current_user_id)
            ->with([
                'followers',
                'following',
                'followingCompanies'
            ])
            ->paginate($this->paginate);
        return $this->navigationManagerService->loadView('user.dashboard.all-users', compact('users'));
    }

    public function follow($id)
    {
        $current_user_id =  $this->authenticableService->getUser()->id;
        $user = $this->user->find($id);

        if (!$user || $current_user_id == $id) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }

        $isAlreadyFollowed = $user->followers()->where('user_id', $current_user_id)->exists();

        if ($isAlreadyFollowed) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is already followed"]);
        }

        $user->followers()->syncWithoutDetaching($current_user_id);
        $msg = $this->authenticableService->getUser()->name . " is started following you";
        $this->notifiableService->sendNotification($user, $msg);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "User is followed"]);
    }

    public function unfollow($id)
    {
        $current_user_id =  $this->authenticableService->getUser()->id;
        $user = $this->user->find($id);

        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }

        $isAlreadyFollowed = $user->followers()->where('user_id', $current_user_id)->exists();

        if (!$isAlreadyFollowed) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not followed"]);
        }

        $user->followers()->detach($current_user_id);

        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "User is unfollowed"]);
    }

    public function removeFollower($id)
    {
        $current_user_id =  $this->authenticableService->getUser()->id;
        $current_user = $this->user->find($current_user_id);
        $user = $this->user->find($id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $isAlreadyFollowed = $current_user->followers()->where('user_id', $id)->exists();
        if (!$isAlreadyFollowed) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not followed"]);
        }
        $current_user->followers()->detach($user->id);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "User is unfollowed"]);
    }

    public function following()
    {
        $user_id =  $this->authenticableService->getUser()->id;
        $users = Follow::where('user_id', $user_id)
            ->with('followable')
            ->paginate($this->paginate);
        return $this->navigationManagerService->loadView('user.dashboard.following', compact('users'));
    }

    public function followers()
    {
        $id =  $this->authenticableService->getUser()->id;
        $user = $this->user->find($id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }

        $users = $user->followers()->paginate($this->paginate);
        return $this->navigationManagerService->loadView('user.dashboard.followers', compact('users'));
    }

    public function notifications()
    {
        $user_id =  $this->authenticableService->getUser()->id;
        $user = $this->user->find($user_id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $notifications = $user->notifications()->paginate($this->paginate);

        $notifications = $notifications->unique('data');
        return $this->navigationManagerService->loadView('user.dashboard.notifications', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $user_id =  $this->authenticableService->getUser()->id;
        $user = $this->user->find($user_id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $user->notifications()->where('id', $id)->update(['read_at' => now()]);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Notification is marked as read"]);
    }

    public function markAllAsRead()
    {
        $user_id =  $this->authenticableService->getUser()->id;
        $user = $this->user->find($user_id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $user->unreadNotifications->markAsRead();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "All notifications are marked as read"]);
    }

    public function markAsUnread($id)
    {
        $user_id =  $this->authenticableService->getUser()->id;
        $user = $this->user->find($user_id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $user->notifications()->where('id', $id)->update(['read_at' => null]);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Notification is marked as unread"]);
    }

    public function deleteNotification($id)
    {
        $user_id =  $this->authenticableService->getUser()->id;
        $user = $this->user->find($user_id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $user->notifications()->where('id', $id)->delete();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Notification is deleted"]);
    }

    public function deleteAllNotification()
    {
        $user_id =  $this->authenticableService->getUser()->id;
        $user = $this->user->find($user_id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $user->notifications()->delete();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "All notifications are deleted"]);
    }

    public function indexPost()
    {
        $user_id = $this->authenticableService->getUser()->id;
        $posts = Post::where([
            ['authorable_id', $user_id],
            ['authorable_type', 'App\Models\User']
        ])
            ->with([
                'authorable',
                // 'comments',
                // 'likes'
            ])
            ->paginate($this->paginate);
        return $this->navigationManagerService->loadView('user.post.index', compact('posts'));
    }

    public function allPost()
    {
        $user_id = $this->authenticableService->getUser()->id;
        $posts =
            Post::with([
                'authorable',
            ])
            ->withCount([
                'comments',
                'likes'
            ])
            ->paginate($this->paginate);
        return $this->navigationManagerService->loadView('user.post.all-post', compact('posts'));
    }

    public function createPost()
    {
        return $this->navigationManagerService->loadView('user.post.create');
    }

    public function storePost(Request $request)
    {
        $request->validate([
            "title" => [
                "required",
                "string",
                "max:100",
            ],
            "content" => [
                "required",
                "string",
                "max:500",
            ],
        ]);

        $user_id = $this->authenticableService->getUser()->id;

        $data = [
            "title" => $request->get("title"),
            "content" => $request->get("content"),
            "authorable_id" => $user_id,
            "authorable_type" => "App\Models\User"
        ];

        $isCreated = Post::create($data);

        if ($isCreated) {
            return $this->navigationManagerService->redirectRoute('user.post.index', [], 302, [], false, ["success" => "Post Created Successfully"]);
        }

        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post Not Created"]);
    }

    public function showPost($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        $user_id = $this->authenticableService->getUser()->id;
        if ($post->authorable_type != "App\Models\User" || $post->authorable_id != $user_id) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You are not authorized to see this post"]);
        }
        return $this->navigationManagerService->loadView('user.post.show', compact('post'));
    }

    public function editPost($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        $user_id = $this->authenticableService->getUser()->id;
        if ($post->authorable_type != "App\Models\User" || $post->authorable_id != $user_id) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "This post is not created by you"]);
        }
        return $this->navigationManagerService->loadView('user.post.edit', compact('post'));
    }

    public function updatePost(Request $request, $id)
    {
        $request->validate([
            "title" => [
                "required",
                "string",
                "max:100",
            ],
            "content" => [
                "required",
                "string",
                "max:500",
            ],
        ]);
        $post = Post::find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        $user_id = $this->authenticableService->getUser()->id;
        if ($post->authorable_type != "App\Models\User" || $post->authorable_id != $user_id) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "This post is not created by you"]);
        }
        $data = [
            "title" => $request->get("title"),
            "content" => $request->get("content"),
        ];
        $isUpdated = $post->update($data);
        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('user.post.index', [], 302, [], false, ["success" => "Post Updated Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post Not Updated"]);
    }

    public function deletePost($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        $user_id = $this->authenticableService->getUser()->id;
        if ($post->authorable_type != "App\Models\User" || $post->authorable_id != $user_id) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "This post is not created by you"]);
        }
        $post->comments()->delete();
        $post->likes()->delete();
        $isDeleted = $post->delete();
        if ($isDeleted) {
            return $this->navigationManagerService->redirectRoute('user.post.index', [], 302, [], false, ["success" => "Post Deleted Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post Not Deleted"]);
    }

    public function likePost($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        $user_id = $this->authenticableService->getUser()->id;
        $isAlreadyLiked = $post->likes()->where([
            ['authorable_id', $user_id],
            ['authorable_type', 'App\Models\User']

        ])->exists();
        if ($isAlreadyLiked) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is already liked"]);
        }
        $data = [
            "authorable_id" => $user_id,
            "authorable_type" => "App\Models\User"
        ];
        $post->likes()->create($data);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Post is liked"]);
    }

    public function unlikePost($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        $user_id = $this->authenticableService->getUser()->id;
        $isAlreadyLiked = $post->likes()->where(
            [
                ['authorable_id', $user_id],
                ['authorable_type', 'App\Models\User']
            ]
        )->exists();
        if (!$isAlreadyLiked) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not liked"]);
        }
        $post->likes()->where([
            ['authorable_id', $user_id],
            ['authorable_type', 'App\Models\User']

        ])->delete();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Post is unliked"]);
    }


    public function commentPostIndex($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        $post = Post::with([
            'comments',
            'comments.authorable',
            'comments.likes'
        ])
            ->find($id)
            ->toArray();
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        return $this->navigationManagerService->loadView('user.post.comment.index', compact('post'));
    }

    public function commentPostCreate($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        return $this->navigationManagerService->loadView('user.post.comment.create', compact('post'));
    }

    public function commentPostStore(Request $request, $id)
    {
        $request->validate([
            "content" => [
                "required",
                "string",
                "max:500",
            ],
        ]);
        $post = Post::find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        $user_id = $this->authenticableService->getUser()->id;
        $data = [
            "content" => $request->get("content"),
            "authorable_id" => $user_id,
            "authorable_type" => "App\Models\User"
        ];
        $post->comments()->create($data);
        return $this->navigationManagerService->redirectRoute('user.post.commentIndex', [$id], 302, [], false, ["success" => "Comment is created"]);
    }

    public function commentPostEdit($id, $comment_id)
    {
        $post = Post::find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }

        $comment = $post->comments()->find($comment_id);
        if (!$comment) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Comment is not found"]);
        }

        $user_id = $this->authenticableService->getUser()->id;
        if ($comment->authorable_id != $user_id || $comment->authorable_type != "App\Models\User") {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "This comment is not created by you"]);
        }
        return $this->navigationManagerService->loadView('user.post.comment.edit', compact('post', 'comment'));
    }

    public function commentPostUpdate(Request $request, $id, $comment_id)
    {
        $request->validate([
            "content" => [
                "required",
                "string",
                "max:500",
            ],
        ]);
        $post = Post::find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }

        $comment = $post->comments()->find($comment_id);
        if (!$comment) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Comment is not found"]);
        }

        $user_id = $this->authenticableService->getUser()->id;
        if ($comment->authorable_id != $user_id || $comment->authorable_type != "App\Models\User") {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "This comment is not created by you"]);
        }

        $data = [
            "content" => $request->get("content"),
        ];
        $isUpdated = $comment->update($data);
        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('user.post.commentIndex', [$id], 302, [], false, ["success" => "Comment is updated"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Comment is not updated"]);
    }

    public function commentPostDelete($id, $comment_id)
    {
        $post = Post::find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }

        $comment = $post->comments()->find($comment_id);
        if (!$comment) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Comment is not found"]);
        }

        $user_id = $this->authenticableService->getUser()->id;
        if ($comment->authorable_id != $user_id || $comment->authorable_type != "App\Models\User") {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "This comment is not created by you"]);
        }

        $isDeleted = $comment->delete();
        if ($isDeleted) {
            return $this->navigationManagerService->redirectRoute('user.post.commentIndex', $id, 302, [], false, ["success" => "Comment is deleted"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Comment is not deleted"]);
    }
}
