<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Company;
use App\Models\Post;
use App\Models\User;
use App\Services\AuthenticableService;
use App\Services\MailableService;
use App\Services\NavigationManagerService;
use App\Services\NotifiableService;
use App\Services\StorageManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class CompanyController extends Controller
{
    private StorageManagerService $storageManagerService;
    private NotifiableService $notifiableService;
    private MailableService $mailableService;
    private NavigationManagerService $navigationManagerService;
    private AuthenticableService $authenticableService;
    private Company $company;
    private int $paginate;

    public function __construct(
        Company $company,
        NotifiableService $notifiableService,
        MailableService $mailableService,
        StorageManagerService $storageManagerService,
        NavigationManagerService $navigationManagerService,
        AuthenticableService $authenticableService,
    ) {
        $this->company = $company;
        $this->paginate = Config::get('constants.pagination');
        $this->notifiableService = $notifiableService;
        $this->mailableService = $mailableService;
        $this->storageManagerService = $storageManagerService;
        $this->navigationManagerService = $navigationManagerService;
        $this->authenticableService = $authenticableService;
    }

    public function login()
    {
        return $this->navigationManagerService->loadView('company.auth.login');
    }

    public function register()
    {
        return $this->navigationManagerService->loadView('company.auth.register');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            "email" => [
                "required",
                "email",
                function ($attribute, $value, $fail) {
                    $company = $this->authenticableService->getCompanyByEmail($value);
                    if (!$company) {
                        $fail("Email does not exist");
                    }
                }
            ],
            "password" => [
                "required",
                "min:8",
                "max:20",
                function ($attribute, $value, $fail) use ($request) {
                    $company = $this->authenticableService->getCompanyByEmail($request->get("email"));
                    if (!$this->authenticableService->verifyPassword($value, $company->password)) {
                        $fail("Password is incorrect");
                    }
                }
            ]
        ]);
        $data = [
            "email" => $request->get("email"),
            "password" => $request->get("password")
        ];
        if ($this->authenticableService->loginCompany($data)) {
            return $this->navigationManagerService->redirectRoute('company.dashboard', [], 302, [], false, ["success" => "You're Logged In"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Invalid Credentials"]);
    }

    public function doRegister(Request $request)
    {
        $request->validate([
            "name" => [
                "required",
                "min:3",
                "max:50",
            ],
            "email" => [
                "required",
                "email",
                "unique:companies,email"
            ],
            "password" => [
                "required",
                "min:8",
                "max:20",
            ],
            "confirm_password" => [
                "required",
                "same:password"
            ]
        ]);

        $data = [
            "name" => $request->get("name"),
            "email" => $request->get("email"),
            "password" => $request->get("password")
        ];

        $isCreated = $this->authenticableService->registerCompany($data);

        if ($isCreated) {

            $isAuth = $this->authenticableService->loginCompany($data);

            if ($isAuth) {

                $company = $this->authenticableService->getCompany();

                $details = [
                    'title' => 'Account Created',
                    'body' => "Your account is created successfully."
                ];
                // UNCOMMENT: To send notification
                $this->notifiableService->sendNotification($company, $details['body']);
                // UNCOMMENT: To send mail
                $this->mailableService->sendMail($company->email, $details);


                $admins = Admin::all();
                $details = [
                    'title' => 'New Company Registered',
                    'body' => "New company $company->name is registered. Please verify it."
                ];
                foreach ($admins as $admin) {
                    // UNCOMMENT: To send notification
                    $this->notifiableService->sendNotification($admin, $details['body']);
                    // UNCOMMENT: To send mail
                    $this->mailableService->sendMail($admin->email, $details);
                }
                return $this->navigationManagerService->redirectRoute('company.dashboard', [], 302, [], false, ["success" => "You're Logged In"]);
            }
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Invalid Credentials"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Something went wrong"]);
    }

    public function logout()
    {
        $this->authenticableService->logoutCompany();
        return $this->navigationManagerService->redirectRoute('company.login', [], 302, [], false, ["success" => "You're Logged Out"]);
    }

    public function dashboard()
    {
        return $this->navigationManagerService->loadView('company.dashboard.index');
    }

    public function changePassword()
    {
        return $this->navigationManagerService->loadView('company.auth.change-password');
    }

    public function doChangePassword(Request $request)
    {

        if (!$this->authenticableService->isCompany()) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You are not authorized"]);
        }

        $id = $this->authenticableService->getCompany()->id;

        $request->validate([
            "currentPassword" => [
                "required",
                function ($attribute, $value, $fail) use ($id) {
                    $user = $this->company->find($id);
                    if (!$this->authenticableService->verifyPassword($value, $user->password)) {
                        return $fail(__('The current password is incorrect.'));
                    }
                }

            ],
            "newPassword" => [
                "required",
                "min:6",
                "max:20",
                function ($attribute, $value, $fail) use ($id) {
                    $user = $this->company->find($id);
                    if ($this->authenticableService->verifyPassword($value, $user->password)) {
                        return $fail(__('The new password cannot be same as current password.'));
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

        $isUpdated = $this->company->where('id', $id)->update($data);

        if ($isUpdated) {
            $company = $this->authenticableService->getCompany();
            $details = [
                'title' => 'Password Changed',
                'body' => "Your password has been changed successfully"
            ];
            // UNCOMMENT: To send notification
            $this->notifiableService->sendNotification($company, $details['body']);
            // UNCOMMENT: To send mail
            $this->mailableService->sendMail($company->email, $details);
            return $this->navigationManagerService->redirectRoute('company.dashboard', [], 302, [], false, ["success" => "Password Updated Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Password Not Updated"]);
    }

    public function editProfile()
    {
        return $this->navigationManagerService->loadView('company.auth.edit-profile');
    }

    public function updateProfile(Request $request)
    {
        $id = $this->authenticableService->getCompany()->id;
        $request->validate([
            "name" => [
                "required",
                "min:3",
                "max:50",
                function ($attribute, $value, $fail) use ($id) {
                    $user = $this->company->where("name", $value)->where("id", "!=", $id)->first();
                    if ($user) {
                        $fail("Name already exist");
                    }
                }
            ],
            "email" => [
                "required",
                "email",
                function ($attribute, $value, $fail) use ($id) {
                    $user = $this->company->where("email", $value)->where("id", "!=", $id)->first();
                    if ($user) {
                        $fail("Email already exist");
                    }
                }
            ]
        ]);

        $data = [
            "name" => $request->get("name"),
            "email" => $request->get("email")
        ];

        $data["website"] = $data["city"] = $data["address"] = $data["linkedin"] = $data["description"] = null;

        if ($request->get("website")) {
            $request->validate([
                "website" => [
                    "required",
                    "url",
                    "max:255",
                    function ($attribute, $value, $fail) {
                        $url = parse_url($value);
                        if (!isset($url['scheme'])) {
                            return $fail("The website format is invalid.");
                        }
                        if (!in_array($url['scheme'], ['http', 'https'])) {
                            return $fail("The website format is invalid.");
                        }
                    }

                ]
            ]);
            $data["website"] = $request->get("website");
        }

        if ($request->get("city")) {
            $request->validate([
                "city" => [
                    "required",
                    "string",
                    "max:255",
                ]
            ]);
            $data["city"] = $request->get("city");
        }

        if ($request->get("address")) {
            $request->validate([
                "address" => [
                    "required",
                    "string",
                    "max:255",
                ]
            ]);
            $data["address"] = $request->get("address");
        }

        if ($request->get("linkedin")) {
            $request->validate([
                "linkedin" => [
                    "required",
                    "url",
                    "max:255",
                    function ($attribute, $value, $fail) {
                        $url = parse_url($value);
                        if (!isset($url['scheme'])) {
                            return $fail("The linkedin format is invalid.");
                        }
                        if (!in_array($url['scheme'], ['http', 'https'])) {
                            return $fail("The linkedin format is invalid.");
                        }
                    }

                ]
            ]);
            $data["linkedin"] = $request->get("linkedin");
        }

        if ($request->get("description")) {
            $request->validate([
                "description" => [
                    "required",
                    "string",
                ]
            ]);
            $data["description"] = $request->get("description");
        }

        $isUpdated = $this->company->where('id', $id)->update($data);

        if ($isUpdated) {
            $company = $this->authenticableService->getCompany();
            $details = [
                'title' => 'Profile Updated',
                'body' => "Your profile has been updated successfully"
            ];
            $this->notifiableService->sendNotification($company, $details['body']);
            // UNCOMMENT: To send mail
            $this->mailableService->sendMail($company->email, $details);
            return $this->navigationManagerService->redirectRoute('company.dashboard', [], 302, [], false, ["success" => "Profile Updated Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Not Updated"]);
    }

    public function editProfileImage()
    {
        return $this->navigationManagerService->loadView('company.auth.edit-profile-image');
    }

    public function updateProfileImage(Request $request)
    {
        $id = $this->authenticableService->getCompany()->id;

        $request->validate([
            "profile_image_url" => [
                "required",
                "image",
                "mimes:jpeg,png,jpg",
                "max:2048",
            ],
        ]);

        $user = $this->company->find($id);

        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }

        if ($user->profile_image_url) {
            $public_ids = $user->profile_image_public_id;
            $this->storageManagerService->deleteFromCloudinary($public_ids);
        }

        $this->storageManagerService->uploadToCloudinary($request, "COMPANY", $user->id);

        $data = [
            "profile_image_public_id" => null,
            "profile_image_url" => null,
        ];

        $isUpdated = $this->company->where('id', $id)->update($data);
        if ($isUpdated) {

            $company = $this->authenticableService->getCompany();
            $details = [
                'title' => 'Profile Image Updated',
                'body' => "Your profile image has been updated successfully"
            ];
            // UNCOMMENT: To send notification
            $this->notifiableService->sendNotification($company, $details['body']);
            // UNCOMMENT: To send mail
            $this->mailableService->sendMail($company->email, $details);

            return $this->navigationManagerService->redirectRoute('company.dashboard', [], 302, [], false, ["success" => "Profile Image Updated Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Image Not Updated"]);
    }

    public function deleteProfileImage()
    {
        $id = $this->authenticableService->getCompany()->id;

        $user = $this->company->find($id);

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

        $isUpdated = $this->company->where('id', $id)->update($data);

        if ($isUpdated) {
            $company = $this->authenticableService->getCompany();
            $details = [
                'title' => 'Profile Image Deleted',
                'body' => "Your profile image has been deleted successfully"
            ];
            // UNCOMMENT: To send notification
            $this->notifiableService->sendNotification($company, $details['body']);
            // UNCOMMENT: To send mail
            $this->mailableService->sendMail($company->email, $details);
            return $this->navigationManagerService->redirectRoute('company.dashboard', [], 302, [], false, ["success" => "Profile Image Deleted Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Image Not Deleted"]);
    }

    public function notifications()
    {
        $company = $this->authenticableService->getCompany();
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        $notifications = $company->notifications()->paginate($this->paginate);

        $notifications = $notifications->unique('data');
        return $this->navigationManagerService->loadView('company.dashboard.notifications', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $company = $this->authenticableService->getCompany();
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        $company->notifications()->where('id', $id)->update(['read_at' => now()]);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Notification is marked as read"]);
    }

    public function markAllAsRead()
    {
        $company = $this->authenticableService->getCompany();
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        $company->unreadNotifications->markAsRead();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "All notifications are marked as read"]);
    }

    public function markAsUnread($id)
    {
        $company = $this->authenticableService->getCompany();
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        $company->notifications()->where('id', $id)->update(['read_at' => null]);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Notification is marked as unread"]);
    }

    public function deleteNotification($id)
    {
        $company = $this->authenticableService->getCompany();
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        $company->notifications()->where('id', $id)->delete();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Notification is deleted"]);
    }

    public function deleteAllNotification()
    {
        $company = $this->authenticableService->getCompany();
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        $company->notifications()->delete();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "All notifications are deleted"]);
    }

    public function followers()
    {
        $company = $this->authenticableService->getCompany();
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        $followers = $company->followers()->paginate($this->paginate);
        return $this->navigationManagerService->loadView('company.dashboard.followers', compact('followers'));
    }

    public function removeFollower($id)
    {
        $company = $this->authenticableService->getCompany();
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        $isAlreadyFollowed = $company->followers()->where('user_id', $id)->exists();
        if (!$isAlreadyFollowed) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not followed"]);
        }
        $company->followers()->detach($id);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "User is unfollowed"]);
    }

    public function allUsers()
    {
        $company = $this->authenticableService->getCompany();
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        $users = User::with([
            'followers',
            'following',
            'followingCompanies'
        ])->paginate($this->paginate);
        return $this->navigationManagerService->loadView('company.dashboard.all-users', compact('users'));
    }

    public function indexPost()
    {
        $id = $this->authenticableService->getCompany()->id;
        $posts = Post::where([
            ['authorable_id', $id],
            ['authorable_type', 'App\Models\Company']
        ])
            ->with([
                'authorable',
            ])
            ->paginate($this->paginate);
        return $this->navigationManagerService->loadView('company.post.index', compact('posts'));
    }

    public function allPost()
    {
        // $id = $this->authenticableService->getCompany()->id;
        $posts =
            Post::with([
                'authorable',
            ])
            ->withCount([
                'comments',
                'likes'
            ])
            ->paginate($this->paginate);
        return $this->navigationManagerService->loadView('company.post.all-post', compact('posts'));
    }

    public function createPost()
    {
        return $this->navigationManagerService->loadView('company.post.create');
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

        $data = [
            "title" => $request->get("title"),
            "content" => $request->get("content"),
            "authorable_id" => $this->authenticableService->getCompany()->id,
            "authorable_type" => "App\Models\Company"
        ];

        $isCreated = Post::create($data);

        if ($isCreated) {
            return $this->navigationManagerService->redirectRoute('company.post.index', [], 302, [], false, ["success" => "Post Created Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post Not Created"]);
    }

    public function showPost($id)
    {
        $post = Post::with([
            'authorable',
            'comments' => function ($query) {
                $query->with([
                    'authorable'
                ]);
            },
            'likes' => function ($query) {
                $query->with([
                    'authorable'
                ]);
            }
        ])->find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        // $id = $this->authenticableService->getCompany()->id;
        // if ($post->authorable_type != "App\Models\Company" || $post->authorable_id != $id) {
        //     return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "This post is not created by you"]);
        // }
        return $this->navigationManagerService->loadView('company.post.show', compact('post'));
    }

    public function editPost($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        $id = $this->authenticableService->getCompany()->id;
        if ($post->authorable_id != $id || $post->authorable_type != "App\Models\Company") {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "This post is not created by you"]);
        }
        return $this->navigationManagerService->loadView('company.post.edit', compact('post'));
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
        $id = $this->authenticableService->getCompany()->id;
        if ($post->authorable_id != $id || $post->authorable_type != "App\Models\Company") {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "This post is not created by you"]);
        }
        $data = [
            "title" => $request->get("title"),
            "content" => $request->get("content"),
        ];
        $isUpdated = $post->update($data);
        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('company.post.index', [], 302, [], false, ["success" => "Post Updated Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post Not Updated"]);
    }

    public function deletePost($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        $id = $this->authenticableService->getCompany()->id;
        if ($post->authorable_id != $id || $post->authorable_type != "App\Models\Company") {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "This post is not created by you"]);
        }
        $post->comments()->detach();
        $post->likes()->detach();
        $isDeleted = $post->delete();
        if ($isDeleted) {
            return $this->navigationManagerService->redirectRoute('company.post.index', [], 302, [], false, ["success" => "Post Deleted Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post Not Deleted"]);
    }

    public function likePost($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        $id = $this->authenticableService->getCompany()->id;
        $isAlreadyLiked = $post->likes()->where(
            [
                ['authorable_id', $id],
                ['authorable_type', 'App\Models\Company']
            ]
        )->exists();
        if ($isAlreadyLiked) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is already liked"]);
        }
        $data = [
            "authorable_id" => $id,
            "authorable_type" => "App\Models\Company"
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
        $id = $this->authenticableService->getCompany()->id;
        $isAlreadyLiked = $post->likes()->where(
            [
                ['authorable_id', $id],
                ['authorable_type', 'App\Models\Company']
            ]
        )->exists();
        if (!$isAlreadyLiked) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not liked"]);
        }
        $post->likes()->where(
            [
                ['authorable_id', $id],
                ['authorable_type', 'App\Models\Company']
            ]
        )->delete();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Post is unliked"]);
    }
}
