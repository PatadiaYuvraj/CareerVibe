<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\AuthenticableService;
use App\Services\NavigationManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class PostsController extends Controller
{
    private NavigationManagerService $navigationManagerService;
    private AuthenticableService $authenticableService;
    private Post $post;
    private int $paginate;

    public function __construct(
        Post $post,
        NavigationManagerService $navigationManagerService,
        AuthenticableService $authenticableService,
    ) {
        $this->post = $post;
        $this->paginate = Config::get('constants.pagination');
        $this->navigationManagerService = $navigationManagerService;
        $this->authenticableService = $authenticableService;
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
        return $this->navigationManagerService->loadView('company.post.index', compact('posts'));
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

        $user_id = $this->authenticableService->getCompany()->id;

        $data = [
            "title" => $request->get("title"),
            "content" => $request->get("content"),
            "authorable_id" => $user_id,
            "authorable_type" => "App\Models\Company"
        ];

        $isCreated = $this->post->create($data);

        if ($isCreated) {
            return $this->navigationManagerService->redirectRoute('company.post.index', [], 302, [], false, ["success" => "Post Created Successfully"]);
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
        return $this->navigationManagerService->loadView('company.post.show', compact('post'));
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
        $post = $this->post->find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        $user_id = $this->authenticableService->getCompany()->id;
        if ($post->authorable_id != $user_id || $post->authorable_type != "App\Models\Company") {
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
        $post = $this->post->find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        $user_id = $this->authenticableService->getCompany()->id;
        if ($post->authorable_id != $user_id || $post->authorable_type != "App\Models\Company") {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "This post is not created by you"]);
        }


        $isDeleted = $post->delete();
        if ($isDeleted) {
            return $this->navigationManagerService->redirectRoute('company.post.index', [], 302, [], false, ["success" => "Post Deleted Successfully"]);
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
        return $this->navigationManagerService->loadView('company.post.comment.index', compact('post'));
    }

    public function commentPostCreate($id)
    {
        $post = $this->post->find($id);
        if (!$post) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Post is not found"]);
        }
        return $this->navigationManagerService->loadView('company.post.comment.create', compact('post'));
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
            return $this->navigationManagerService->redirectRoute('company.post.commentIndex', [$id], 302, [], false, ["success" => "Comment is created"]);
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
        return $this->navigationManagerService->loadView('company.post.comment.edit', compact('post', 'comment'));
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
            return $this->navigationManagerService->redirectRoute('company.post.commentIndex', [$id], 302, [], false, ["success" => "Comment is updated"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Comment is not updated"]);
    }

    public function commentPostDelete($id, $comment_id)
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
