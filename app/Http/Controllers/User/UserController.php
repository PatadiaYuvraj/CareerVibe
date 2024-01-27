<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Follow;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Services\NavigationManagerService;
use App\Services\StorageManagerService;
use App\Services\SendMailService;
use App\Services\SendNotificationService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    private User $user;
    private StorageManagerService $StorageManagerService;
    private SendNotificationService $sendNotificationService;
    private SendMailService $sendMailService;
    private int $paginate;
    private NavigationManagerService $navigationManagerService;

    public function __construct(
        User $user,
        SendNotificationService $sendNotificationService,
        SendMailService $sendMailService,
        StorageManagerService $StorageManagerService,
        NavigationManagerService $navigationManagerService,
    ) {
        $this->user = $user;
        $this->sendNotificationService = $sendNotificationService;
        $this->sendMailService = $sendMailService;
        $this->StorageManagerService = $StorageManagerService;
        $this->paginate = env('PAGINATEVALUE');
        $this->navigationManagerService = $navigationManagerService;
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
                    $user = $this->user->where('email', $value)->first();
                    if (!$user) {
                        return $fail(__('The email is not registered.'));
                    }
                }
            ],
            "password" => [
                "required",
                "min:6",
                "max:20",
                function ($attribute, $value, $fail) {
                    $user = $this->user->where('email', request()->get('email'))->first();
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

        if (auth()->guard('user')->attempt($data, true)) {
            return $this->navigationManagerService->redirectRoute('user.dashboard', [], 302, [], false, ["success" => "You're Logged In"]);
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
                function ($attribute, $value, $fail) {
                    $isExist = $this->user->where('name', $value)->get()->ToArray();
                    if ($isExist) {
                        $fail($attribute . ' is already exist.');
                    }
                },
            ],
            "email" => [
                "required",
                "email",
                function ($attribute, $value, $fail) {
                    $isExist = $this->user->where('email', $value)->get()->ToArray();
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
                    $name = $this->user->where('name', request()->get('name'))->first();
                    $email = $this->user->where('email', request()->get('email'))->first();
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

        $isCreated = $this->user->create($data);

        if ($isCreated) {
            $isAuth = auth()->guard('user')->attempt([
                "email" => $request->get("email"),
                "password" => $request->get("password")
            ]);

            if ($isAuth) {
                return $this->navigationManagerService->redirectRoute('user.dashboard', [], 302, [], false, ["success" => "You're Logged In"]);
            }
            return $this->navigationManagerService->redirectRoute('user.login', [], 302, [], false, ["success" => "User Created Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User Not Created"]);
    }

    public function logout()
    {
        auth()->guard('user')->logout();
        Session::flush();
        return $this->navigationManagerService->redirectRoute('user.login', [], 302, [], false, ["success" => "You're Logged Out"]);
    }

    public function changePassword()
    {
        return $this->navigationManagerService->loadView('user.auth.change-password');
    }

    public function doChangePassword(Request $request)
    {
        if (!auth()->guard('user')->check()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $id = auth()->guard('user')->user()->id;

        $request->validate([
            "currentPassword" => [
                "required",
                function ($attribute, $value, $fail) use ($id) {
                    $user = $this->user->find($id);
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
                    $user = $this->user->find($id);
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

        $isUpdated = $this->user->where('id', $id)->update($data);

        $user = $this->user->find(auth()->guard('user')->user()->id);
        $details = [
            'title' => 'Password Changed',
            'body' => 'Your password is changed'
        ];
        $this->sendNotificationService->sendNotification($user, $details['body']);
        $this->sendMailService->sendMail($user->email, $details);

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
        if (!auth()->guard('user')->check()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $id = auth()->guard('user')->user()->id;

        $request->validate([
            "name" => [
                "required",
                "string",
                "max:100",
                function ($attribute, $value, $fail) use ($id) {
                    $isExist = $this->user->where('id', '!=', $id)->where('name', $value)->get()->ToArray();
                    if ($isExist) {
                        $fail($attribute . ' is already exist.');
                    }
                },
            ],
            "email" => [
                "required",
                "email",
                function ($attribute, $value, $fail) use ($id) {
                    $isExist = $this->user->where('id', '!=', $id)->where('email', $value)->get()->ToArray();
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

        $isUpdated = $this->user->where('id', $id)->update($data);

        if ($isUpdated) {

            $user = $this->user->find(auth()->guard('user')->user()->id);
            $details = [
                'title' => 'Profile Updated',
                'body' => 'Your profile is updated'
            ];
            $this->sendNotificationService->sendNotification($user, $details['body']);
            $this->sendMailService->sendMail($user->email, $details);
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
        if (!auth()->guard('user')->check()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $id = auth()->guard('user')->user()->id;

        $request->validate([
            "profile_image_url" => [
                "required",
                "image",
                "mimes:jpeg,png,jpg",
                "max:2048",
            ],
        ]);

        $user = $this->user->find($id);

        if (!$user) {
            return redirect()->back()->with("warning", "User is not found");
        }

        if ($user->profile_image_url) {
            $public_ids = $user->profile_image_public_id;
            $this->StorageManagerService->deleteFromCloudinary($public_ids);
        }

        $this->StorageManagerService->uploadToCloudinary($request, "USER", $user->id);

        $data = [
            "profile_image_public_id" => null,
            "profile_image_url" => null,
        ];

        $isUpdated = $this->user->where('id', $id)->update($data);
        if ($isUpdated) {

            $user = $this->user->find(auth()->guard('user')->user()->id);
            $details = [
                'title' => 'Profile Image Updated',
                'body' => 'Your profile image is updated'
            ];
            $this->sendNotificationService->sendNotification($user, $details['body']);
            $this->sendMailService->sendMail($user->email, $details);
            return $this->navigationManagerService->redirectRoute('user.dashboard', [], 302, [], false, ["success" => "Profile Image Updated Successfully"]);
        }

        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Image Not Updated"]);
    }

    public function deleteProfileImage()
    {
        if (!auth()->guard('user')->check()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $id = auth()->guard('user')->user()->id;

        $user = $this->user->find($id);

        if (!$user) {
            return redirect()->back()->with("warning", "User is not found");
        }

        if ($user->profile_image_url) {
            $public_ids = $user->profile_image_public_id;
            $this->StorageManagerService->deleteFromCloudinary($public_ids);
        }

        $data = [
            "profile_image_public_id" => null,
            "profile_image_url" => null,
        ];

        $isUpdated = $this->user->where('id', $id)->update($data);

        if ($isUpdated) {

            $user = $this->user->find(auth()->guard('user')->user()->id);
            $details = [
                'title' => 'Profile Image Deleted',
                'body' => 'Your profile image is deleted'
            ];
            $this->sendNotificationService->sendNotification($user, $details['body']);
            $this->sendMailService->sendMail($user->email, $details);
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
        if (!auth()->guard('user')->check()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $id = auth()->guard('user')->user()->id;

        $request->validate([
            "resume_pdf_url" => [
                "required",
                "mimes:pdf",
                "max:2048",
            ],
        ]);
        $user = $this->user->find($id);
        if (!$user) {
            return redirect()->back()->with("warning", "User is not found");
        }
        if ($user->resume_pdf_url) {
            $this->StorageManagerService->deleteFromLocal($user->resume_pdf_url);
        }
        $stored_path = $this->StorageManagerService->uploadToLocal($request, "resume_pdf_url");
        $data = [
            "resume_pdf_url" => $stored_path,
        ];
        $isUpdated = $this->user->where('id', $id)->update($data);
        if ($isUpdated) {

            $user = $this->user->find(auth()->guard('user')->user()->id);
            $details = [
                'title' => 'Resume Updated',
                'body' => 'Your resume is updated'
            ];
            // UNCOMMENT: To send notification
            $this->sendNotificationService->sendNotification($user, $details['body']);
            // UNCOMMENT: To send mail
            $this->sendMailService->sendMail($user->email, $details);
            return $this->navigationManagerService->redirectRoute('user.dashboard', [], 302, [], false, ["success" => "User resume is updated"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User resume is not updated"]);
    }

    public function deleteResumePdf()
    {
        if (!auth()->guard('user')->check()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $id = auth()->guard('user')->user()->id;

        $user = $this->user->find($id);

        if (!$user) {
            return redirect()->back()->with("warning", "User is not found");
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

            $user = $this->user->find(auth()->guard('user')->user()->id);
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
        $current_user_id = auth()->guard('user')->user()->id;
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
        $current_user_id = auth()->guard('user')->user()->id;
        $user = $this->user->find($id);

        if (!$user || $current_user_id == $id) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }

        $isAlreadyFollowed = $user->followers()->where('user_id', $current_user_id)->exists();

        if ($isAlreadyFollowed) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is already followed"]);
        }

        $user->followers()->syncWithoutDetaching($current_user_id);
        $msg = auth()->guard('user')->user()->name . " is started following you";
        $this->sendNotificationService->sendNotification($user, $msg);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "User is followed"]);
    }

    public function unfollow($id)
    {
        $current_user_id = auth()->guard('user')->user()->id;
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
        $current_user_id = auth()->guard('user')->user()->id;
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
        $user_id = auth()->guard('user')->user()->id;
        $users = Follow::where('user_id', $user_id)
            ->with('followable')
            ->paginate($this->paginate);
        return $this->navigationManagerService->loadView('user.dashboard.following', compact('users'));
    }

    public function followers()
    {
        $id = auth()->guard('user')->user()->id;
        $user = $this->user->find($id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }

        $users = $user->followers()->paginate($this->paginate);
        return $this->navigationManagerService->loadView('user.dashboard.followers', compact('users'));
    }

    public function notifications()
    {
        $user_id = auth()->guard('user')->user()->id;
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
        $user_id = auth()->guard('user')->user()->id;
        $user = $this->user->find($user_id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $user->notifications()->where('id', $id)->update(['read_at' => now()]);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Notification is marked as read"]);
    }

    public function markAllAsRead()
    {
        $user_id = auth()->guard('user')->user()->id;
        $user = $this->user->find($user_id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $user->unreadNotifications->markAsRead();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "All notifications are marked as read"]);
    }

    public function markAsUnread($id)
    {
        $user_id = auth()->guard('user')->user()->id;
        $user = $this->user->find($user_id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $user->notifications()->where('id', $id)->update(['read_at' => null]);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Notification is marked as unread"]);
    }

    public function deleteNotification($id)
    {
        $user_id = auth()->guard('user')->user()->id;
        $user = $this->user->find($user_id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $user->notifications()->where('id', $id)->delete();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Notification is deleted"]);
    }

    public function deleteAllNotification()
    {
        $user_id = auth()->guard('user')->user()->id;
        $user = $this->user->find($user_id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $user->notifications()->delete();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "All notifications are deleted"]);
    }

    public function indexPost()
    {
        $user_id = auth()->guard('user')->user()->id;
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
        $user_id = auth()->guard('user')->user()->id;
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

        $user_id = auth()->guard('user')->user()->id;

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
        $user_id = auth()->guard('user')->user()->id;
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
        $user_id = auth()->guard('user')->user()->id;
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
        $user_id = auth()->guard('user')->user()->id;
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
        $user_id = auth()->guard('user')->user()->id;
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
        $user_id = auth()->guard('user')->user()->id;
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
        $user_id = auth()->guard('user')->user()->id;
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
        $user_id = auth()->guard('user')->user()->id;
        $data = [
            "content" => $request->get("content"),
            "authorable_id" => $user_id,
            "authorable_type" => "App\Models\User"
        ];
        $post->comments()->create($data);
        return $this->navigationManagerService->redirectRoute('user.post.commentIndex', $id, 302, [], false, ["success" => "Comment is created"]);
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

        $user_id = auth()->guard('user')->user()->id;
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

        $user_id = auth()->guard('user')->user()->id;
        if ($comment->authorable_id != $user_id || $comment->authorable_type != "App\Models\User") {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "This comment is not created by you"]);
        }

        $data = [
            "content" => $request->get("content"),
        ];
        $isUpdated = $comment->update($data);
        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('user.post.commentIndex', $id, 302, [], false, ["success" => "Comment is updated"]);
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

        $user_id = auth()->guard('user')->user()->id;
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
