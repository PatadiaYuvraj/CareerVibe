<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\AuthenticableService;
use App\Services\MailableService;
use App\Services\NavigationManagerService;
use App\Services\NotifiableService;
use App\Services\StorageManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class AuthController extends Controller
{
    private Admin $admin;
    private int $paginate;
    private MailableService $mailableService;
    private NotifiableService $notifiableService;
    private StorageManagerService $storageManagerService;
    private NavigationManagerService $navigationManagerService;
    private AuthenticableService $authenticableService;

    public function __construct(
        Admin $admin,
        MailableService $mailableService,
        NotifiableService $notifiableService,
        StorageManagerService $storageManagerService,
        NavigationManagerService $navigationManagerService,
        AuthenticableService $authenticableService,
    ) {
        $this->paginate = Config::get('constants.pagination');
        $this->admin = $admin;
        $this->mailableService = $mailableService;
        $this->notifiableService = $notifiableService;
        $this->storageManagerService = $storageManagerService;
        $this->navigationManagerService = $navigationManagerService;
        $this->authenticableService = $authenticableService;
    }

    public function dashboard()
    {
        return $this->navigationManagerService->loadView('admin.dashboard.index');
    }

    public function login()
    {
        return $this->navigationManagerService->loadView('admin.auth.login');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            "email" => [
                "required",
                "email",
                function ($attribute, $value, $fail) {
                    $user = $this->authenticableService->getAdminByEmail($value);
                    if (!$user) {
                        return $fail(__('The email is incorrect.'));
                    }
                },
                // check email verification
                function ($attribute, $value, $fail) {
                    $user = $this->authenticableService->getAdminByEmail($value);
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
                    $user = $this->authenticableService->getAdminByEmail(request()->get('email'));
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
        $user = $this->authenticableService->getAdminByEmail($data['email']);
        if ($user && !$user->is_email_verified) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Email is not verified"]);
        }

        if ($this->authenticableService->loginAdmin($data)) {
            return $this->navigationManagerService->redirectRoute('admin.dashboard', [], 302, [], false, ["success" => "You're Logged In"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Invalid Credentials"]);
    }

    public function register()
    {
        return $this->navigationManagerService->loadView('admin.auth.register');
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
                    $isExist = $this->authenticableService->getAdminByEmail($value);
                    if ($isExist) {
                        return $fail($attribute . ' is already exist.');
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
                "same:password"
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
            'url' => $this->authenticableService->generateAdminEmailVerificationLink('admin.verifyEmail', $token),
        ];

        // send mail
        $this->mailableService->emailVerificationMail($data['email'], $details);

        $isCreated = $this->authenticableService->registerAdmin($data);

        // MAIL: when admin is created then send mail to other admins that new admin is created




        if ($isCreated) {
            $admins = $this->admin->where('id', '!=', $isCreated->id)->get();
            if (count($admins) > 0) {
                $details = [
                    'title' => 'New Admin Created',
                    'body' => 'New Admin Created with name ' . $isCreated->name . ' and email ' . $isCreated->email,
                ];
                foreach ($admins as $admin) {
                    $email = $admin->email;
                    // UNCOMMENT: To send notification
                    $this->notifiableService->sendNotification($admin, $details['body']);
                    // UNCOMMENT: To send mail
                    $this->mailableService->sendMail($email, $details);
                }
            }
            return $this->navigationManagerService->redirectRoute('admin.login', [], 302, [], false, ["success" => "Verification Link Sent Successfully"]);
        }
        return $this->navigationManagerService->redirectRoute('admin.login', [], 302, [], false, ["warning" => "Admin Not Created"]);
    }


    public function verifyEmail($token)
    {
        $user = $this->admin->where('email_verification_token', $token)->first();
        if (!$user) {
            return $this->navigationManagerService->redirectRoute('admin.login', [], 302, [], false, ["warning" => "Invalid Token"]);
        }
        $data = [
            "is_email_verified" => true,
            "email_verification_token" => null,
            "email_verified_at" => now(),
        ];
        $isUpdated = $this->admin->where('id', $user->id)->update($data);
        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('admin.login', [], 302, [], false, ["success" => "Email Verified Successfully"]);
        }
        return $this->navigationManagerService->redirectRoute('admin.login', [], 302, [], false, ["warning" => "Email Not Verified"]);
    }

    // fogot password
    public function forgotPassword()
    {
        return $this->navigationManagerService->loadView('admin.auth.forgot-password');
    }

    public function doForgotPassword(Request $request)
    {
        $request->validate([
            "email" => [
                "required",
                "email",
                function ($attribute, $value, $fail) {
                    $user = $this->authenticableService->getAdminByEmail($value);
                    if (!$user) {
                        return $fail(__('The email is not registered.'));
                    }
                },
                function ($attribute, $value, $fail) {
                    $user = $this->authenticableService->getAdminByEmail($value);
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
            'url' => $this->authenticableService->generateAdminPasswordResetLink('admin.resetPassword', $token),
        ];

        // send mail
        $this->mailableService->passwordResetMail($data['email'], $details);

        $isUpdated = $this->admin->where('email', $data['email'])->update($data);

        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('admin.login', [], 302, [], false, ["success" => "Reset Password Link Sent Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Reset Password Link Not Sent"]);
    }

    public function resetPassword($token)
    {
        $user = $this->admin->where('password_reset_token', $token)->first();
        if (!$user) {
            return $this->navigationManagerService->redirectRoute('admin.login', [], 302, [], false, ["warning" => "Invalid Token"]);
        }
        return $this->navigationManagerService->loadView('admin.auth.reset-password', compact('token'));
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

        $user = $this->admin->where('password_reset_token', $token)->first();
        if (!$user) {
            return $this->navigationManagerService->redirectRoute('admin.login', [], 302, [], false, ["warning" => "Invalid Token"]);
        }

        $data = [
            "password" => $this->authenticableService->passwordHash($request->get("password")),
            "password_reset_token" => null,
        ];

        $isUpdated = $this->admin->where('id', $user->id)->update($data);

        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('admin.login', [], 302, [], false, ["success" => "Password Reset Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Password Not Reset"]);
    }

    public function logout()
    {
        $this->authenticableService->logoutAdmin();
        return $this->navigationManagerService->redirectRoute('admin.login', [], 302, [], false, ["success" => "You're Logged Out"]);
    }

    public function changePassword()
    {
        return $this->navigationManagerService->loadView('admin.auth.change-password');
    }

    public function doChangePassword(Request $request)
    {

        // currentPassword newPassword confirmPassword

        if (!$this->authenticableService->isAdmin()) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You are not authorized"]);
        }

        $admin = $this->authenticableService->getAdmin();

        $request->validate([
            "currentPassword" => [
                "required",
                function ($attribute, $value, $fail) use ($admin) {
                    if (!$this->authenticableService->verifyPassword($value, $admin->password)) {
                        return $fail(__('The current password is incorrect.'));
                    }
                },
            ],
            "newPassword" => [
                "required",
                "min:6",
                "max:20",
                function ($attribute, $value, $fail) use ($admin) {
                    if ($this->authenticableService->verifyPassword($value, $admin->password)) {
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
            "password" => $this->authenticableService->passwordHash($request->get("newPassword"))
        ];

        $isUpdated = $this->admin->find($admin->id)->update($data);
        $details = [
            'title' => 'Password Changed',
            'body' => "Your password has been changed successfully"
        ];
        // UNCOMMENT: To send notification
        $this->notifiableService->sendNotification($admin, $details['body']);
        // UNCOMMENT: To send mail
        $this->mailableService->sendMail($admin->email, $details);


        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute(
                'admin.dashboard',
                [],
                302,
                [],
                false,
                [
                    "success" => "Password Updated Successfully"
                ]
            );
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Password Not Updated"]);
    }

    public function editProfile()
    {
        return $this->navigationManagerService->loadView('admin.auth.edit-profile');
    }

    public function updateProfile(Request $request)
    {
        if (!$this->authenticableService->isAdmin()) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You are not authorized"]);
        }

        $admin = $this->authenticableService->getAdmin();

        $request->validate([
            "name" => [
                "required",
                "string",
                'min:3',
                "max:20",
            ],
            // "email" => [
            //     "required",
            //     "email",
            //     function ($attribute, $value, $fail) use ($admin) {
            //         if ($value != $admin->email) {
            //             $isExist = $this->admin->where('email', $value)->get()->ToArray();
            //             if ($isExist) {
            //                 return $fail($attribute . ' is already exist.');
            //             }
            //         }
            //     },
            // ]
        ]);

        if ($admin->name == $request->get("name")) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "No changes found"]);
        }

        $data = [
            "name" => $request->get("name"),
            // "email" => $request->get("email")
        ];

        $isUpdated = $this->admin->find($admin->id)->update($data);

        if ($isUpdated) {

            $details = [
                'title' => 'Profile Updated',
                'body' => "Your profile has been updated successfully"
            ];

            // UNCOMMENT: To send notification
            $this->notifiableService->sendNotification($admin, $details['body']);
            // UNCOMMENT: To send mail
            $this->mailableService->sendMail($admin->email, $details);

            return $this->navigationManagerService->redirectRoute('admin.dashboard', [], 302, [], false, ["success" => "Profile Updated Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Not Updated"]);
    }

    public function editProfileImage()
    {
        return $this->navigationManagerService->loadView('admin.auth.edit-profile-image');
    }

    public function updateProfileImage(Request $request)
    {
        // if (!$this->authenticableService->isAdmin()) {
        //     return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You are not authorized"]);
        // }

        $admin = $this->authenticableService->getAdmin();

        $request->validate([
            "profile_image_url" => [
                "required",
                "image",
                "mimes:jpeg,png,jpg",
                "max:2048",
            ],
        ]);

        if ($admin->profile_image_url) {
            $public_ids = $admin->profile_image_public_id;
            $this->storageManagerService->deleteFromCloudinary($public_ids);
        }
        // $this->storageManagerService->uploadToCloudinary($request, Config::get('constants.USER_TYPE.admin'), $admin->id);

        $this->storageManagerService->uploadToCloudinary(
            $request,
            'profile_image_url',
            Config::get('constants.CLOUDINARY_FOLDER_DEMO.admin-profile-image'),
            'image',
            Admin::class,
            $admin->id,
            Config::get('constants.TAGE_NAMES.admin-profile-image')
        );


        $data = [
            "profile_image_public_id" => null,
            "profile_image_url" => null,
        ];

        $isUpdated = $this->admin->find($admin->id)->update($data);
        if ($isUpdated) {
            $details = [
                'title' => 'Profile Image Updated',
                'body' => "Your profile image has been updated successfully"
            ];
            // UNCOMMENT: To send notification
            $this->notifiableService->sendNotification($admin, $details['body']);
            // UNCOMMENT: To send mail
            $this->mailableService->sendMail($admin->email, $details);
            return $this->navigationManagerService->redirectRoute('admin.dashboard', [], 302, [], false, ["success" => "Profile Image Updated Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Image Not Updated"]);
    }

    public function deleteProfileImage()
    {

        $admin = $this->authenticableService->getAdmin();

        if (!$admin) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }

        if ($admin->profile_image_url) {
            $public_ids = $admin->profile_image_public_id;
            $this->storageManagerService->deleteFromCloudinary($public_ids);
        }


        $data = [
            "profile_image_public_id" => null,
            "profile_image_url" => null,
        ];

        $isUpdated = $this->admin->where('id', $admin->id)->update($data);

        if ($isUpdated) {
            $details = [
                'title' => 'Profile Image Deleted',
                'body' => "Your profile image has been deleted successfully"
            ];
            // UNCOMMENT: To send notification
            $this->notifiableService->sendNotification($admin, $details['body']);
            // UNCOMMENT: To send mail
            $this->mailableService->sendMail($admin->email, $details);

            return $this->navigationManagerService->redirectRoute('admin.dashboard', [], 302, [], false, ["success" => "Profile Image Deleted Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Image Not Deleted"]);
    }

    public function notifications()
    {
        $admin = $this->authenticableService->getAdmin();
        if (!$admin) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Admin is not found"]);
        }
        $notifications = $admin->notifications()->paginate($this->paginate);
        $notifications = $notifications->unique('data');
        return $this->navigationManagerService->loadView('admin.dashboard.notifications', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $admin = $this->authenticableService->getAdmin();
        if (!$admin) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Admin is not found"]);
        }
        $admin->notifications()->where('id', $id)->update(['read_at' => now()]);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Notification is marked as read"]);
    }

    public function markAllAsRead()
    {
        $admin = $this->authenticableService->getAdmin();
        if (!$admin) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Admin is not found"]);
        }
        $admin->unreadNotifications->markAsRead();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "All notifications are marked as read"]);
    }

    public function markAsUnread($id)
    {
        $admin = $this->authenticableService->getAdmin();
        if (!$admin) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Admin is not found"]);
        }
        $admin->notifications()->where('id', $id)->update(['read_at' => null]);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Notification is marked as unread"]);
    }

    public function deleteNotification($id)
    {
        $admin = $this->authenticableService->getAdmin();
        if (!$admin) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Admin is not found"]);
        }
        $admin->notifications()->where('id', $id)->delete();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Notification is deleted"]);
    }

    public function deleteAllNotification()
    {
        $admin = $this->authenticableService->getAdmin();
        if (!$admin) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Admin is not found"]);
        }
        $admin->notifications()->delete();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "All notifications are deleted"]);
    }
}
