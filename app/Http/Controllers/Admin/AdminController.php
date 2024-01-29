<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\MailableService;
use App\Services\NavigationManagerService;
use App\Services\NotifiableService;
use App\Services\StorageManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    private Admin $admin;
    private int $paginate;
    private MailableService $mailableService;
    private NotifiableService $notifiableService;
    private StorageManagerService $storageManagerService;
    private NavigationManagerService $navigationManagerService;

    public function __construct(
        Admin $admin,
        MailableService $mailableService,
        NotifiableService $notifiableService,
        StorageManagerService $storageManagerService,
        NavigationManagerService $navigationManagerService,
    ) {
        $this->paginate = Config::get('constants.pagination');
        $this->admin = $admin;
        $this->mailableService = $mailableService;
        $this->notifiableService = $notifiableService;
        $this->storageManagerService = $storageManagerService;
        $this->navigationManagerService = $navigationManagerService;
    }

    public function dashboard()
    {
        // return $this->navigationManagerService->loadView('view-name');
        // return $this->navigationManagerService->redirectRoute('view-name', [], 302, [], false, ["success" => "message"]);
        // return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "message"]);
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
                    $user = $this->admin->where('email', $value)->first();
                    if (!$user) {
                        return $fail(__('The email is incorrect.'));
                    }
                }
            ],
            "password" => [
                "required",
                "min:6",
                "max:20",
                function ($attribute, $value, $fail) {
                    $user = $this->admin->where('email', request()->get('email'))->first();
                    if ($user && !Hash::check($value, $user->password)) {
                        return $fail(__('The password is incorrect.'));
                    }
                }
            ]
        ]);
        $data = [
            "email" => $request->get("email"),
            "password" => $request->get("password")
        ];

        if (auth()->guard('admin')->attempt($data, true)) {
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
                function ($attribute, $value, $fail) {
                    $isExist = $this->admin->where('name', $value)->get()->ToArray();
                    if ($isExist) {
                        $fail($attribute . ' is already exist.');
                    }
                },
            ],
            "email" => [
                "required",
                "email",
                function ($attribute, $value, $fail) {
                    $isExist = $this->admin->where('email', $value)->get()->ToArray();
                    if ($isExist) {
                        $fail($attribute . ' is already exist.');
                    }
                },
            ],
            "password" => [
                "required",
                "min:6",
                "max:20",
                function ($attribute, $value, $fail) {
                    $name = $this->admin->where('name', request()->get('name'))->first();
                    $email = $this->admin->where('email', request()->get('email'))->first();
                    if ($name && Hash::check($value, $name->password)) {
                        return $fail(__('The password should not be same as name.'));
                    }
                    if ($email && Hash::check($value, $email->password)) {
                        return $fail(__('The password should not be same as email.'));
                    }
                }
            ],
            "confirm_password" => "required|min:6|max:20|same:password"
        ]);

        $data = [
            "name" => $request->get("name"),
            "email" => $request->get("email"),
            "password" => Hash::make($request->get("password"))
        ];

        $isCreated = $this->admin->create($data);

        // MAIL: when admin is created then send mail to other admins that new admin is created

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


        if ($isCreated) {
            $isAuth = auth()->guard('admin')->attempt([
                "email" => $request->get("email"),
                "password" => $request->get("password")
            ]);

            if ($isAuth) {
                return $this->navigationManagerService->redirectRoute('admin.dashboard', [], 302, [], false, ["success" => "You're Logged In"]);
            }
            return $this->navigationManagerService->redirectRoute('admin.login', [], 302, [], false, ["success" => "Admin Created Successfully"]);
        }
        return $this->navigationManagerService->redirectRoute('admin.login', [], 302, [], false, ["warning" => "Admin Not Created"]);
    }

    public function logout()
    {
        auth()->guard('admin')->logout();
        Session::flush();
        return $this->navigationManagerService->redirectRoute('admin.login', [], 302, [], false, ["success" => "You're Logged Out"]);
    }

    public function changePassword()
    {
        return $this->navigationManagerService->loadView('admin.auth.change-password');
    }

    public function doChangePassword(Request $request)
    {

        // currentPassword newPassword confirmPassword

        if (!auth()->guard('admin')->check()) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You are not authorized"]);
        }

        $id = auth()->guard('admin')->user()->id;

        $request->validate([
            "currentPassword" => [
                "required",
                function ($attribute, $value, $fail) use ($id) {
                    $user = $this->admin->find($id);
                    if (!Hash::check($value, $user->password)) {
                        return $fail(__('The current password is incorrect.'));
                    }
                },
            ],
            "newPassword" => [
                "required",
                "min:6",
                "max:20",
                function ($attribute, $value, $fail) use ($id) {
                    $user = $this->admin->find($id);
                    if (Hash::check($value, $user->password)) {
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
            "password" => Hash::make($request->get("newPassword"))
        ];

        $isUpdated = $this->admin->where('id', $id)->update($data);

        $admin = $this->admin->find(auth()->guard('admin')->user()->id);
        $details = [
            'title' => 'Password Changed',
            'body' => "Your password has been changed successfully"
        ];
        // UNCOMMENT: To send notification
        $this->notifiableService->sendNotification($admin, $details['body']);
        // UNCOMMENT: To send mail
        $this->mailableService->sendMail($admin->email, $details);


        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('admin.dashboard', [], 302, [], false, ["success" => "Password Updated Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Password Not Updated"]);
    }

    public function editProfile()
    {
        return $this->navigationManagerService->loadView('admin.auth.edit-profile');
    }

    public function updateProfile(Request $request)
    {
        if (!auth()->guard('admin')->check()) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You are not authorized"]);
        }

        $id = auth()->guard('admin')->user()->id;

        $request->validate([
            "name" => [
                "required",
                "string",
                "max:100",
                function ($attribute, $value, $fail) use ($id) {
                    $isExist = $this->admin->where('id', '!=', $id)->where('name', $value)->get()->ToArray();
                    if ($isExist) {
                        $fail($attribute . ' is already exist.');
                    }
                },
            ],
            "email" => [
                "required",
                "email",
                function ($attribute, $value, $fail) use ($id) {
                    $isExist = $this->admin->where('id', '!=', $id)->where('email', $value)->get()->ToArray();
                    if ($isExist) {
                        $fail($attribute . ' is already exist.');
                    }
                },
            ]
        ]);

        $data = [
            "name" => $request->get("name"),
            "email" => $request->get("email")
        ];

        $isUpdated = $this->admin->where('id', $id)->update($data);

        if ($isUpdated) {
            $admin = $this->admin->find(auth()->guard('admin')->user()->id);

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
        if (!auth()->guard('admin')->check()) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You are not authorized"]);
        }

        $id = auth()->guard('admin')->user()->id;

        $request->validate([
            "profile_image_url" => [
                "required",
                "image",
                "mimes:jpeg,png,jpg",
                "max:2048",
            ],
        ]);

        $user = $this->admin->find($id);

        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }

        if ($user->profile_image_url) {
            $public_ids = $user->profile_image_public_id;
            $this->storageManagerService->deleteFromCloudinary($public_ids);
            $this->storageManagerService->uploadToCloudinary($request, "ADMIN", $user->id);
        }




        $data = [
            "profile_image_public_id" => null,
            "profile_image_url" => null,
        ];

        $isUpdated = $this->admin->where('id', $id)->update($data);
        if ($isUpdated) {
            $admin = $this->admin->find(auth()->guard('admin')->user()->id);
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
        if (!auth()->guard('admin')->check()) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You are not authorized"]);
        }

        $id = auth()->guard('admin')->user()->id;

        $user = $this->admin->find($id);

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

        $isUpdated = $this->admin->where('id', $id)->update($data);

        if ($isUpdated) {
            $admin = $this->admin->find(auth()->guard('admin')->user()->id);
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
        $admin_id = auth()->guard('admin')->user()->id;
        $admin = $this->admin->find($admin_id);
        if (!$admin) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Admin is not found"]);
        }
        $notifications = $admin->notifications()->paginate($this->paginate);
        $notifications = $notifications->unique('data');
        return $this->navigationManagerService->loadView('admin.dashboard.notifications', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $admin_id = auth()->guard('admin')->user()->id;
        $admin = $this->admin->find($admin_id);
        if (!$admin) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Admin is not found"]);
        }
        $admin->notifications()->where('id', $id)->update(['read_at' => now()]);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Notification is marked as read"]);
    }

    public function markAllAsRead()
    {
        $admin_id = auth()->guard('admin')->user()->id;
        $admin = $this->admin->find($admin_id);
        if (!$admin) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Admin is not found"]);
        }
        $admin->unreadNotifications->markAsRead();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "All notifications are marked as read"]);
    }

    public function markAsUnread($id)
    {
        $admin_id = auth()->guard('admin')->user()->id;
        $admin = $this->admin->find($admin_id);
        if (!$admin) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Admin is not found"]);
        }
        $admin->notifications()->where('id', $id)->update(['read_at' => null]);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Notification is marked as unread"]);
    }

    public function deleteNotification($id)
    {
        $admin_id = auth()->guard('admin')->user()->id;
        $admin = $this->admin->find($admin_id);
        if (!$admin) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Admin is not found"]);
        }
        $admin->notifications()->where('id', $id)->delete();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Notification is deleted"]);
    }

    public function deleteAllNotification()
    {
        $admin_id = auth()->guard('admin')->user()->id;
        $admin = $this->admin->find($admin_id);
        if (!$admin) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Admin is not found"]);
        }
        $admin->notifications()->delete();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "All notifications are deleted"]);
    }
}
