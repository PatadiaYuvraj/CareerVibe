<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Services\AuthenticableService;
use App\Services\NavigationManagerService;
use App\Services\StorageManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    private NavigationManagerService $navigationManagerService;
    private AuthenticableService $authenticableService;
    private StorageManagerService $storageManagerService;
    private Post $post;
    private int $paginate;

    public function __construct(
        Post $post,
        NavigationManagerService $navigationManagerService,
        AuthenticableService $authenticableService,
        StorageManagerService $storageManagerService
    ) {
        $this->post = $post;
        $this->paginate = Config::get('constants.pagination');
        $this->navigationManagerService = $navigationManagerService;
        $this->authenticableService = $authenticableService;
        $this->storageManagerService = $storageManagerService;
    }

    public function indexPost()
    {
        $user_id = $this->authenticableService->getCompany()->id;
        $posts = $this->post
            ->where([
                ['authorable_id', $user_id],
                ['authorable_type', 'App\Models\Company']
            ])
            ->with([
                'authorable',
                'likes'
            ])
            ->paginate($this->paginate);
        //     ->get()->toArray();
        // dd($posts);
        return $this->navigationManagerService->loadView('admin_company.post.index', compact('posts'));
    }

    public function allPost()
    {
        $posts =
            $this->post->with([
                'authorable',
            ])
            ->withCount([
                'comments',
                'likes'
            ])
            ->paginate($this->paginate);
        //     ->get()->toArray();
        // dd($posts);
        return $this->navigationManagerService->loadView('admin_company.post.all-post', compact('posts'));
    }

    public function createPost()
    {
        return $this->navigationManagerService->loadView('admin_company.post.create');
    }

    public function storePost(Request $request)
    {
        $user_id = $this->authenticableService->getCompany()->id;



        switch ($request->type) {
            case 'TEXT':
                $rules = [
                    'title' => ['required', 'string', 'max:100'],
                    'content' => ['required', 'string', 'max:500'],
                    'type' => ['required', 'string', 'in:' . implode(',', array_keys(Config::get('constants.post.type'))),],
                    'file' => 'nullable',
                ];
                $messages = [
                    'title.required' => 'The title field is required.',
                    'title.string' => 'The title must be a string.',
                    'title.max' => 'The title may not be greater than 100 characters.',
                    'content.required' => 'The content field is required.',
                    'content.string' => 'The content must be a string.',
                    'content.max' => 'The content may not be greater than 500 characters.',
                    'type.required' => 'The type field is required.',
                    'type.string' => 'The type must be a string.',
                    'type.in' => 'The selected type is invalid.',
                ];
                break;
            case 'IMAGE':
                $rules = [
                    'title' => ['required', 'string', 'max:100'],
                    'content' => ['required', 'string', 'max:500'],
                    'type' => ['required', 'string', 'in:' . implode(',', array_keys(Config::get('constants.post.type'))),],
                    'file' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10240'],
                ];

                $messages = [
                    'title.required' => 'The title field is required.',
                    'title.string' => 'The title must be a string.',
                    'title.max' => 'The title may not be greater than 100 characters.',
                    'content.required' => 'The content field is required.',
                    'content.string' => 'The content must be a string.',
                    'content.max' => 'The content may not be greater than 500 characters.',
                    'type.required' => 'The type field is required.',
                    'type.string' => 'The type must be a string.',
                    'type.in' => 'The selected type is invalid.',
                    'file.required' => 'The file field is required.',
                    'file.image' => 'The file must be an image.',
                    'file.mimes' => 'The file must be a file of type: jpeg, png, jpg, gif, svg.',
                    'file.max' => 'The file may not be greater than 10240 kilobytes.',
                ];

                break;
            case 'VIDEO':
                $rules = [
                    'title' => ['required', 'string', 'max:100'],
                    'content' => ['required', 'string', 'max:500'],
                    'type' => ['required', 'string', 'in:' . implode(',', array_keys(Config::get('constants.post.type'))),],
                    'file' => ['required', 'mimes:mp4,3gp,avi,mov,flv,wmv', 'max:30720'],
                ];
                $messages = [
                    'title.required' => 'The title field is required.',
                    'title.string' => 'The title must be a string.',
                    'title.max' => 'The title may not be greater than 100 characters.',
                    'content.required' => 'The content field is required.',
                    'content.string' => 'The content must be a string.',
                    'content.max' => 'The content may not be greater than 500 characters.',
                    'type.required' => 'The type field is required.',
                    'type.string' => 'The type must be a string.',
                    'type.in' => 'The selected type is invalid.',
                    'file.required' => 'The file field is required.',
                    'file.mimes' => 'The file must be a file of type: mp4, 3gp, avi, mov, flv, wmv.',
                    'file.max' => 'The file may not be greater than 30720 kilobytes.',
                ];
                break;
            default:
                // Handle invalid type
                return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Invalid Post Type"]);
        }

        $request->validate($rules, $messages);
        // if ($request->hasFile('file')) {
        //     $file = $request->file('file');
        //     if ($request->type == "IMAGE") {
        //         $stored_path = Storage::putFile(
        //             'uploads/company-post/image',
        //             $request->file('file')
        //         );
        //     }
        //     if ($request->type == "VIDEO") {
        //         $stored_path = Storage::putFile(
        //             'uploads/company-post/video',
        //             $request->file('file')
        //         );
        //     }
        //     $data = [
        //         "title" => $request->get("title"),
        //         "content" => $request->get("content"),
        //         "type" => $request->type,
        //         "authorable_id" => $user_id,
        //         "authorable_type" => "App\Models\Company",
        //         "file" => null,
        //         "public_id" => null
        //     ];
        // } else {
        //     $data = [
        //         "title" => $request->get("title"),
        //         "content" => $request->get("content"),
        //         "type" => $request->type,
        //         "authorable_id" => $user_id,
        //         "authorable_type" => "App\Models\Company"
        //     ];
        // }

        $data = [
            "title" => $request->get("title"),
            "content" => $request->get("content"),
            "type" => $request->type,
            "authorable_id" => $user_id,
            "authorable_type" => "App\Models\Company",
            "file" => null,
            "public_id" => null
        ];



        $isCreated = $this->post->create($data);

        if ($isCreated) {

            if ($request->hasFile('file')) {
                if ($request->type == "IMAGE") {
                    $this->storageManagerService->uploadToCloudinary(
                        $request,
                        'file',
                        Config::get('constants.CLOUDINARY_FOLDER_DEMO.company-post-image'),
                        'image',
                        Post::class,
                        $isCreated->id,
                        Config::get('constants.TAGE_NAMES.company-post-image')
                    );
                }

                if ($request->type == "VIDEO") {
                    $this->storageManagerService->uploadToCloudinary(
                        $request,
                        'file',
                        Config::get('constants.CLOUDINARY_FOLDER_DEMO.company-post-video'),
                        'video',
                        Post::class,
                        $isCreated->id,
                        Config::get('constants.TAGE_NAMES.company-post-video')
                    );
                }
            }

            return $this->navigationManagerService->redirectRoute('admin_company.post.index', [], 302, [], false, ["success" => "Post Created Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post Not Created"]);
    }

    public function showPost($id)
    {
        $post = $this->post->find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        // $user_id = $this->authenticableService->getCompany()->id;
        // if ($post->authorable_type != "App\Models\Company" || $post->authorable_id != $user_id) {
        //     return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "This post is not created by you"]);
        // }
        return $this->navigationManagerService->loadView('admin_company.post.show', compact('post'));
    }

    public function editPost($id)
    {
        $post = $this->post->find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        $user_id = $this->authenticableService->getCompany()->id;
        if ($post->authorable_id != $user_id || $post->authorable_type != "App\Models\Company") {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "This post is not created by you"]);
        }
        return $this->navigationManagerService->loadView('admin_company.post.edit', compact('post'));
    }

    public function updatePost(Request $request, $id)
    {
        $post = $this->post->find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }

        $user_id = $this->authenticableService->getCompany()->id;
        if ($post->authorable_id != $user_id || $post->authorable_type != "App\Models\Company") {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "This post is not created by you"]);
        }

        if ($post->type == "TEXT") {
            $rules = [
                'title' => ['required', 'string', 'max:100'],
                'content' => ['required', 'string', 'max:500'],
                'file' => 'nullable',
            ];
            $messages = [
                'title.required' => 'The title field is required.',
                'title.string' => 'The title must be a string.',
                'title.max' => 'The title may not be greater than 100 characters.',
                'content.required' => 'The content field is required.',
                'content.string' => 'The content must be a string.',
                'content.max' => 'The content may not be greater than 500 characters.',
            ];
        } else if ($post->type == "IMAGE") {


            $rules = [
                'title' => ['required', 'string', 'max:100'],
                'content' => ['required', 'string', 'max:500'],
                'file' => [
                    'nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10240'
                ],
            ];

            $messages = [
                'title.required' => 'The title field is required.',
                'title.string' => 'The title must be a string.',
                'title.max' => 'The title may not be greater than 100 characters.',
                'content.required' => 'The content field is required.',
                'content.string' => 'The content must be a string.',
                'content.max' => 'The content may not be greater than 500 characters.',
                'file.image' => 'The file must be an image.',
                'file.mimes' => 'The file must be a file of type: jpeg, png, jpg, gif, svg.',
                'file.max' => 'The file may not be greater than 10240 kilobytes.',
            ];
        } else if ($post->type == "VIDEO") {
            $rules = [
                'title' => ['required', 'string', 'max:100'],
                'content' => ['required', 'string', 'max:500'],
                'file' => ['nullable', 'mimes:mp4,3gp,avi,mov,flv,wmv', 'max:30720'],
            ];
            $messages = [
                'title.required' => 'The title field is required.',
                'title.string' => 'The title must be a string.',
                'title.max' => 'The title may not be greater than 100 characters.',
                'content.required' => 'The content field is required.',
                'content.string' => 'The content must be a string.',
                'content.max' => 'The content may not be greater than 500 characters.',
                'file.mimes' => 'The file must be a file of type: mp4, 3gp, avi, mov, flv, wmv.',
                'file.max' => 'The file may not be greater than 30720 kilobytes.',
            ];
        } else {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Invalid Post Type"]);
        }
        $request->validate($rules, $messages);

        $data = [
            "title" => $request->get("title"),
            "content" => $request->get("content"),
        ];

        // if ($request->hasFile('file')) {
        //     $file = $request->file('file');
        //     if ($post->type == "IMAGE") {

        //         if ($post->file) {
        //             Storage::delete($post->file);
        //         }

        //         $stored_path = Storage::putFile(
        //             'uploads/company-post/image',
        //             $request->file('file')
        //         );
        //         $data['file'] = $stored_path;
        //     }
        //     if ($post->type == "VIDEO") {

        //         if ($post->file) {
        //             Storage::delete($post->file);
        //         }

        //         $stored_path = Storage::putFile(
        //             'uploads/company-post/video',
        //             $request->file('file')
        //         );
        //         $data['file'] = $stored_path;
        //     }
        // }


        $isUpdated = $post->update($data);

        if ($isUpdated) {


            if ($request->hasFile('file')) {
                if ($post->type == "IMAGE") {

                    if ($post->file) {
                        $public_id = $post->public_id;
                        $this->storageManagerService->deleteFromCloudinary($public_id);
                    }

                    $this->storageManagerService->uploadToCloudinary(
                        $request,
                        'file',
                        Config::get('constants.CLOUDINARY_FOLDER_DEMO.company-post-image'),
                        'image',
                        Post::class,
                        $post->id,
                        Config::get('constants.TAGE_NAMES.company-post-image')
                    );
                }

                if ($post->type == "VIDEO") {

                    if ($post->file) {
                        $public_id = $post->public_id;
                        $this->storageManagerService->deleteFromCloudinary($public_id);
                    }

                    $this->storageManagerService->uploadToCloudinary(
                        $request,
                        'file',
                        Config::get('constants.CLOUDINARY_FOLDER_DEMO.company-post-video'),
                        'video',
                        Post::class,
                        $post->id,
                        Config::get('constants.TAGE_NAMES.company-post-video')
                    );
                }
            }

            return $this->navigationManagerService->redirectRoute('admin_company.post.index', [], 302, [], false, ["success" => "Post Updated Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post Not Updated"]);
    }

    public function deletePost($id)
    {
        $post = $this->post->find($id);

        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        $user_id = $this->authenticableService->getCompany()->id;
        if ($post->authorable_id != $user_id || $post->authorable_type != "App\Models\Company") {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "This post is not created by you"]);
        }

        if ($post->type == "IMAGE" || $post->type == "VIDEO") {
            if ($post->file) {
                // Storage::delete($post->file);
                $public_id = $post->public_id;
                $this->storageManagerService->deleteFromCloudinary($public_id);
            }
        }
        $post->comments()->delete();
        $post->likes()->delete();

        $isDeleted = $this->authenticableService->getCompany()->posts()->where('id', $id)->delete();
        if ($isDeleted) {
            return $this->navigationManagerService->redirectRoute('admin_company.post.index', [], 302, [], false, ["success" => "Post Deleted Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post Not Deleted"]);
    }

    public function likePost($id)
    {
        $post = $this->post->find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        $user_id = $this->authenticableService->getCompany()->id;
        $isAlreadyLiked = $post->likes()->where(
            [
                ['authorable_id', $user_id],
                ['authorable_type', 'App\Models\Company']
            ]
        )->exists();
        if ($isAlreadyLiked) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is already liked"]);
        }
        $data = [
            "authorable_id" => $user_id,
            "authorable_type" => "App\Models\Company"
        ];
        $post->likes()->create($data);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Post is liked"]);
    }

    public function unlikePost($id)
    {
        $post = $this->post->find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        $user_id = $this->authenticableService->getCompany()->id;
        $isAlreadyLiked = $post->likes()->where(
            [
                ['authorable_id', $user_id],
                ['authorable_type', 'App\Models\Company']
            ]
        )->exists();
        if (!$isAlreadyLiked) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not liked"]);
        }
        $post->likes()->where(
            [
                ['authorable_id', $user_id],
                ['authorable_type', 'App\Models\Company']
            ]
        )->delete();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Post is unliked"]);
    }

    public function commentPostIndex($id)
    {
        $post = $this->post->find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        $post = $this->post->with([
            'comments',
            'comments.authorable',
            'comments.likes'
        ])
            ->find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        return $this->navigationManagerService->loadView('admin_company.post.comment.index', compact('post'));
    }

    public function commentPostCreate($id)
    {
        $post = $this->post->find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        return $this->navigationManagerService->loadView('admin_company.post.comment.create', compact('post'));
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
        $post = $this->post->find($id);
        // if (!$post) {
        //     return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        // }
        $user_id = $this->authenticableService->getCompany()->id;
        $data = [
            "content" => $request->get("content"),
            "authorable_id" => $user_id,
            "authorable_type" => "App\Models\Company"
        ];
        $isCreated = $post->comments()->create($data);

        if ($isCreated) {
            return $this->navigationManagerService->redirectRoute('admin_company.post.commentIndex', [$id], 302, [], false, ["success" => "Comment is created"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Comment is not created"]);
    }

    public function commentPostEdit($id, $comment_id)
    {
        $post = $this->post->find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }

        $comment = $post->comments()->find($comment_id);
        if (!$comment) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Comment is not found"]);
        }

        $user_id = $this->authenticableService->getCompany()->id;
        if ($comment->authorable_id != $user_id || $comment->authorable_type != "App\Models\Company") {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "This comment is not created by you"]);
        }
        return $this->navigationManagerService->loadView('admin_company.post.comment.edit', compact('post', 'comment'));
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
        $post = $this->post->find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }

        $comment = $post->comments()->find($comment_id);
        if (!$comment) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Comment is not found"]);
        }
        $user_id = $this->authenticableService->getCompany()->id;
        if ($comment->authorable_id != $user_id || $comment->authorable_type != "App\Models\Company") {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "This comment is not created by you"]);
        }

        $data = [
            "content" => $request->get("content"),
        ];
        $isUpdated = $comment->update($data);
        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('admin_company.post.commentIndex', [$id], 302, [], false, ["success" => "Comment is updated"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Comment is not updated"]);
    }

    public function commentPostDelete($id, $comment_id)
    {
        $post = $this->post->find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }


        // $comment = $post->comments()->find($comment_id);

        $comment = Comment::with('post')->where('id', $comment_id)->first();


        if (!$comment) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Comment is not found"]);
        }
        $user_id = $this->authenticableService->getCompany()->id;

        if ($comment->post->authorable_id != $user_id || $comment->post->authorable_type != "App\Models\Company") {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "This post/comment is not created by you"]);
        }

        $isDeleted = $comment->delete();
        if ($isDeleted) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Comment is deleted"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Comment is not deleted"]);
    }

    public function commentPostLike($post_id, $comment_id)
    {
        $post = $this->post->find($post_id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }

        $comment = $post->comments()->find($comment_id);
        if (!$comment) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Comment is not found"]);
        }

        $user_id = $this->authenticableService->getCompany()->id;
        $isAlreadyLiked = $comment->likes()->where(
            [
                ['authorable_id', $user_id],
                ['authorable_type', 'App\Models\Company']

            ]
        )->exists();
        if ($isAlreadyLiked) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Comment is already liked"]);
        }
        $data = [
            "authorable_id" => $user_id,
            "authorable_type" => "App\Models\Company"
        ];
        $comment->likes()->create($data);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Comment is liked"]);
    }

    public function commentPostUnlike($post_id, $comment_id)
    {
        $post = $this->post->find($post_id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }

        $comment = $post->comments()->find($comment_id);
        if (!$comment) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Comment is not found"]);
        }

        $user_id = $this->authenticableService->getCompany()->id;
        $isAlreadyLiked = $comment->likes()->where(
            [
                ['authorable_id', $user_id],
                ['authorable_type', 'App\Models\Company']
            ]
        )->exists();
        if (!$isAlreadyLiked) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Comment is not liked"]);
        }
        $comment->likes()->where([
            ['authorable_id', $user_id],
            ['authorable_type', 'App\Models\Company']

        ])->delete();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Comment is unliked"]);
    }
}
