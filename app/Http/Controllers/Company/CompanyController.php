<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Jobs\DeleteFromCloudinary;
use App\Models\Admin;
use App\Models\Company;
use App\Models\Post;
use App\Models\User;
use App\Services\SendMailService;
use App\Services\SendNotificationService;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    private string $folder = 'career-vibe/companies/profile_image';

    private SendNotificationService $sendNotificationService;
    private SendMailService $sendMailService;
    private Company $company;
    private $current_company;
    private int $paginate;

    public function __construct(Company $company, SendNotificationService $sendNotificationService, SendMailService $sendMailService)
    {
        $this->middleware(function ($request, $next) {
            if (auth()->guard('company')->check()) {
                $this->current_company = auth()->guard('company')->user();
            }
            return $next($request);
        });
        $this->company = $company;
        $this->paginate = env('PAGINATEVALUE');
        $this->sendNotificationService = $sendNotificationService;
        $this->sendMailService = $sendMailService;
    }

    public function login()
    {
        // dd(auth()->guard('company')->check());
        return view('company.auth.login');
    }

    public function register()
    {
        return view('company.auth.register');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            "email" => [
                "required",
                "email",
                function ($attribute, $value, $fail) {
                    $company = Company::where("email", $value)->first();
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
                    $company = Company::where("email", $request->get("email"))->first();
                    if ($company && !Hash::check($value, $company->password)) {
                        $fail("Invalid Credentials");
                    }
                }
            ]
        ]);
        $data = [
            "email" => $request->get("email"),
            "password" => $request->get("password")
        ];
        if (auth()->guard('company')->attempt($data, true)) {
            auth()->login(auth()->guard('company')->user(), true);
            return redirect()->route('company.dashboard')->with("success", "You're Logged In");
        }
        return redirect()->back()->with("warning", "Invalid Credentials");
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
            "password" => Hash::make($request->get("password"))
        ];

        $isCreated = $this->company->create($data);

        if ($isCreated) {

            $company = $this->company->find($isCreated->id);
            $companyName = $isCreated->name;

            $details = [
                'title' => 'Account Created',
                'body' => "Your account is created successfully."
            ];
            // UNCOMMENT: To send notification
            $this->sendNotificationService->sendNotification($company, $details['body']);
            // UNCOMMENT: To send mail
            $this->sendMailService->sendMail($company->email, $details);


            $admins = Admin::all();
            $details = [
                'title' => 'New Company Registered',
                'body' => "New company $companyName is registered. Please verify it."
            ];
            foreach ($admins as $admin) {
                // UNCOMMENT: To send notification
                $this->sendNotificationService->sendNotification($admin, $details['body']);
                // UNCOMMENT: To send mail
                $this->sendMailService->sendMail($admin->email, $details);
            }

            $isAuth = auth()->guard('company')->attempt([
                "email" => $request->get("email"),
                "password" => $request->get("password")
            ]);

            if ($isAuth) {
                return redirect()->route('company.dashboard')->with("success", "You're Logged In");
            }
            return redirect()->back()->with("warning", "Invalid Credentials");
        }
        return redirect()->back()->with("warning", "Something went wrong");
    }

    public function logout()
    {
        auth()->guard('company')->logout();
        session()->flush();
        return redirect()->route('company.login')->with("success", "You're Logged Out");
    }

    public function dashboard()
    {
        return view('company.dashboard.index');
    }

    public function changePassword()
    {
        return view('company.auth.change-password');
    }

    public function doChangePassword(Request $request)
    {

        // currentPassword newPassword confirmPassword

        if (!auth()->guard('company')->check()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $id = $this->current_company->id;

        $request->validate([
            "currentPassword" => [
                "required",
                function ($attribute, $value, $fail) use ($id) {
                    $user = $this->company->find($id);
                    if (!Hash::check($value, $user->password)) {
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

        $isUpdated = $this->company->where('id', $id)->update($data);

        if ($isUpdated) {
            $company = $this->company->find(auth()->guard('company')->user()->id);
            $details = [
                'title' => 'Password Changed',
                'body' => "Your password has been changed successfully"
            ];
            // UNCOMMENT: To send notification
            $this->sendNotificationService->sendNotification($company, $details['body']);
            // UNCOMMENT: To send mail
            $this->sendMailService->sendMail($company->email, $details);
            return redirect()->route('company.dashboard')->with("success", "Password Updated Successfully");
        }

        return redirect()->back()->with("warning", "Password Not Updated");
    }

    public function editProfile()
    {
        return view('company.auth.edit-profile');
    }

    public function updateProfile(Request $request)
    {
        $id = $this->current_company->id;
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
            $company = $this->company->find(auth()->guard('company')->user()->id);
            $details = [
                'title' => 'Profile Updated',
                'body' => "Your profile has been updated successfully"
            ];
            $this->sendNotificationService->sendNotification($company, $details['body']);
            // UNCOMMENT: To send mail
            $this->sendMailService->sendMail($company->email, $details);

            return redirect()->route('company.dashboard')->with("success", "Profile Updated Successfully");
        }

        return redirect()->back()->with("warning", "Profile Not Updated");
    }

    public function editProfileImage()
    {
        return view('company.auth.edit-profile-image');
    }

    public function updateProfileImage(Request $request)
    {
        $id = $this->current_company->id;

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
            return redirect()->back()->with("warning", "User is not found");
        }

        if ($user->profile_image_url) {
            $public_ids = $user->profile_image_public_id;
            DeleteFromCloudinary::dispatch($public_ids);
        }

        // delete local file after uploading to cloudinary

        $stored_path = Storage::putFile('temp', $request->file('profile_image_url'));
        $obj = (new UploadApi())->upload(
            $stored_path,
            [
                'folder' => $this->folder,
                'resource_type' => 'image'
            ]
        );

        Storage::delete($stored_path);


        $data = [
            "profile_image_public_id" => $obj['public_id'],
            "profile_image_url" => $obj['secure_url'],
        ];

        $isUpdated = $this->company->where('id', $id)->update($data);
        if ($isUpdated) {

            $company = $this->company->find(auth()->guard('company')->user()->id);
            $details = [
                'title' => 'Profile Image Updated',
                'body' => "Your profile image has been updated successfully"
            ];
            // UNCOMMENT: To send notification
            $this->sendNotificationService->sendNotification($company, $details['body']);
            // UNCOMMENT: To send mail
            $this->sendMailService->sendMail($company->email, $details);

            return redirect()->route('company.dashboard')->with("success", "Profile Image Updated Successfully");
        }

        return redirect()->back()->with("warning", "Profile Image Not Updated");
    }

    public function deleteProfileImage()
    {
        $id = $this->current_company->id;

        $user = $this->company->find($id);

        if (!$user) {
            return redirect()->back()->with("warning", "User is not found");
        }

        if ($user->profile_image_url) {
            $public_ids = $user->profile_image_public_id;
            DeleteFromCloudinary::dispatch($public_ids);
        }

        $data = [
            "profile_image_public_id" => null,
            "profile_image_url" => null,
        ];

        $isUpdated = $this->company->where('id', $id)->update($data);

        if ($isUpdated) {
            $company = $this->company->find(auth()->guard('company')->user()->id);
            $details = [
                'title' => 'Profile Image Deleted',
                'body' => "Your profile image has been deleted successfully"
            ];
            // UNCOMMENT: To send notification
            $this->sendNotificationService->sendNotification($company, $details['body']);
            // UNCOMMENT: To send mail
            $this->sendMailService->sendMail($company->email, $details);
            return redirect()->route('company.dashboard')->with("success", "Profile Image Deleted Successfully");
        }

        return redirect()->back()->with("warning", "Profile Image Not Deleted");
    }

    public function notifications()
    {
        $company_id = auth()->guard('company')->user()->id;
        $company = $this->company->find($company_id);
        if (!$company) {
            return redirect()->back()->with("warning", "Company is not found");
        }
        $notifications = $company->notifications()->paginate($this->paginate);

        $notifications = $notifications->unique('data');

        return view('company.dashboard.notifications', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $company_id = auth()->guard('company')->user()->id;
        $company = $this->company->find($company_id);
        if (!$company) {
            return redirect()->back()->with("warning", "Company is not found");
        }
        $company->notifications()->where('id', $id)->update(['read_at' => now()]);
        return redirect()->back()->with("success", "Notification is marked as read");
    }

    public function markAllAsRead()
    {
        $company_id = auth()->guard('company')->user()->id;
        $company = $this->company->find($company_id);
        if (!$company) {
            return redirect()->back()->with("warning", "Company is not found");
        }
        $company->unreadNotifications->markAsRead();
        return redirect()->back()->with("success", "All notifications are marked as read");
    }

    public function markAsUnread($id)
    {
        $company_id = auth()->guard('company')->user()->id;
        $company = $this->company->find($company_id);
        if (!$company) {
            return redirect()->back()->with("warning", "Company is not found");
        }
        $company->notifications()->where('id', $id)->update(['read_at' => null]);
        return redirect()->back()->with("success", "Notification is marked as unread");
    }

    public function deleteNotification($id)
    {
        $company_id = auth()->guard('company')->user()->id;
        $company = $this->company->find($company_id);
        if (!$company) {
            return redirect()->back()->with("warning", "Company is not found");
        }
        $company->notifications()->where('id', $id)->delete();
        return redirect()->back()->with("success", "Notification is deleted");
    }

    public function deleteAllNotification()
    {
        $company_id = auth()->guard('company')->user()->id;
        $company = $this->company->find($company_id);
        if (!$company) {
            return redirect()->back()->with("warning", "Company is not found");
        }
        $company->notifications()->delete();
        return redirect()->back()->with("success", "All notifications are deleted");
    }

    public function followers()
    {
        $company_id = auth()->guard('company')->user()->id;
        $company = $this->company->find($company_id);
        if (!$company) {
            return redirect()->back()->with("warning", "Company is not found");
        }
        $followers = $company->followers()->paginate($this->paginate);
        return view('company.dashboard.followers', compact('followers'));
    }

    public function removeFollower($id)
    {
        $company_id = auth()->guard('company')->user()->id;
        $company = $this->company->find($company_id);
        if (!$company) {
            return redirect()->back()->with("warning", "Company is not found");
        }
        $isAlreadyFollowed = $company->followers()->where('user_id', $id)->exists();
        if (!$isAlreadyFollowed) {
            return redirect()->back()->with("warning", "User is not followed");
        }
        $company->followers()->detach($id);
        return redirect()->back()->with("success", "User is unfollowed");
    }

    public function allUsers()
    {
        $company_id = auth()->guard('company')->user()->id;
        $company = $this->company->find($company_id);
        if (!$company) {
            return redirect()->back()->with("warning", "Company is not found");
        }
        $users = User::with([
            'followers',
            'following',
            'followingCompanies'
        ])->paginate($this->paginate);
        return view('company.dashboard.all-users', compact('users'));
    }

    public function indexPost()
    {
        $user_id = auth()->guard('company')->user()->id;
        $posts = Post::where([
            ['authorable_id', $user_id],
            ['authorable_type', 'App\Models\Company']
        ])
            ->with([
                'authorable',
                // 'comments',
                // 'likes'
            ])
            ->paginate($this->paginate);
        return view('company.post.index', compact('posts'));
    }

    public function allPost()
    {
        $user_id = auth()->guard('company')->user()->id;
        $posts =
            Post::with([
                'authorable',
            ])
            ->withCount([
                'comments',
                'likes'
            ])
            // ->get()->toArray();
            ->paginate($this->paginate);
        // dd($posts);
        return view('company.post.all-post', compact('posts'));
    }

    public function createPost()
    {
        return view('company.post.create');
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

        $user_id = auth()->guard('company')->user()->id;

        $data = [
            "title" => $request->get("title"),
            "content" => $request->get("content"),
            "authorable_id" => $user_id,
            "authorable_type" => "App\Models\Company"
        ];

        $isCreated = Post::create($data);

        if ($isCreated) {
            return redirect()->route('company.post.index')->with("success", "Post Created Successfully");
        }

        return redirect()->back()->with("warning", "Post Not Created");
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
            return redirect()->back()->with("warning", "Post is not found");
        }
        // $user_id = auth()->guard('company')->user()->id;
        // if ($post->authorable_type != "App\Models\Company" || $post->authorable_id != $user_id) {
        //     return redirect()->back()->with("warning", "This post is not created by you");
        // }
        return view('company.post.show', compact('post'));
    }

    public function editPost($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return redirect()->back()->with("warning", "Post is not found");
        }
        $user_id = auth()->guard('company')->user()->id;
        if ($post->authorable_id != $user_id) {
            return redirect()->back()->with("warning", "This post is not created by you");
        }
        return view('company.post.edit', compact('post'));
    }
    // not done
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
            return redirect()->back()->with("warning", "Post is not found");
        }
        $user_id = auth()->guard('user')->user()->id;
        if ($post->authorable_id != $user_id) {
            return redirect()->back()->with("warning", "This post is not created by you");
        }
        $data = [
            "title" => $request->get("title"),
            "content" => $request->get("content"),
        ];
        $isUpdated = $post->update($data);
        if ($isUpdated) {
            return redirect()->route('user.post.index')->with("success", "Post Updated Successfully");
        }
        return redirect()->back()->with("warning", "Post Not Updated");
    }
    // not done
    public function deletePost($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return redirect()->back()->with("warning", "Post is not found");
        }
        $user_id = auth()->guard('company')->user()->id;
        if ($post->authorable_id != $user_id) {
            return redirect()->back()->with("warning", "This post is not created by you");
        }
        $post->comments()->detach();
        $post->likes()->detach();
        $isDeleted = $post->delete();
        if ($isDeleted) {
            return redirect()->route('company.post.index')->with("success", "Post Deleted Successfully");
        }
        return redirect()->back()->with("warning", "Post Not Deleted");
    }
    // not done
    public function likePost($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return redirect()->back()->with("warning", "Post is not found");
        }
        $user_id = auth()->guard('user')->user()->id;
        $isAlreadyLiked = $post->likes()->where('authorable_id', $user_id)->exists();
        if ($isAlreadyLiked) {
            return redirect()->back()->with("warning", "Post is already liked");
        }
        $data = [
            "authorable_id" => $user_id,
            "authorable_type" => "App\Models\User"
        ];
        $post->likes()->create($data);
        return redirect()->back()->with("success", "Post is liked");
    }
    // not done
    public function unlikePost($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return redirect()->back()->with("warning", "Post is not found");
        }
        $user_id = auth()->guard('user')->user()->id;
        $isAlreadyLiked = $post->likes()->where('authorable_id', $user_id)->exists();
        if (!$isAlreadyLiked) {
            return redirect()->back()->with("warning", "Post is not liked");
        }
        $post->likes()->where('authorable_id', $user_id)->delete();
        return redirect()->back()->with("success", "Post is unliked");
    }
}
