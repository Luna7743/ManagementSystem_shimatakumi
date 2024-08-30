<?php

//Laravelのコントローラーで掲示板機能に関連するさまざまなアクションを管理しています
namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use App\Http\Requests\BulletinBoard\PostEditRequest;
use App\Http\Requests\CommentRequest;
use Auth;

class PostsController extends Controller
{
    //投稿の一覧を表示
    public function show(Request $request)
    {
        $posts = Post::with(['user', 'postComments'])
            ->withCount('likes')
            ->get();
        $categories = MainCategory::get();
        $like = new Like();
        $post_comment = new Post();

        // キーワード検索の処理
        if (!empty($request->keyword)) {
            $posts = Post::with(['user', 'postComments'])
                ->withCount('likes')
                ->where('post_title', 'like', '%' . $request->keyword . '%')
                ->orWhere('post', 'like', '%' . $request->keyword . '%')
                ->get();

            // カテゴリー検索の処理
        } elseif ($request->category_word) {
            $sub_category = $request->category_word;
            $posts = Post::with(['user', 'postComments'])
                ->withCount('likes')
                ->get();

            // いいねした投稿の表示
        } elseif ($request->like_posts) {
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with(['user', 'postComments'])
                ->withCount('likes')
                ->whereIn('id', $likes)
                ->get();

            // 自分の投稿の表示
        } elseif ($request->my_posts) {
            $posts = Post::with(['user', 'postComments'])
                ->withCount('likes')
                ->where('user_id', Auth::id())
                ->get();
        }
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment'));
    }

    //指定されたIDの投稿の詳細を表示
    public function postDetail($post_id)
    {
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    //新しい投稿を作成するためのフォームを表示
    public function postInput()
    {
        // $main_categories = MainCategory::get();
        $main_categories = MainCategory::with('subCategories')->get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories'));
    }

    //新しい投稿を作成
    public function postCreate(PostFormRequest $request)
    {
        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.show');
    }

    //既存の投稿を更新
    public function postEdit(PostEditRequest $request)
    {
        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    //指定された投稿を削除
    public function postDelete($id)
    {
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }

    //新しいメインカテゴリを作成
    public function mainCategoryCreate(Request $request)
    {
        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }

    //投稿に新しいコメントを追加
    public function commentCreate(CommentRequest $request)
    {
        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    //認証されたユーザーが作成した投稿を表示
    public function myBulletinBoard()
    {
        $posts = Auth::user()->posts()->get();
        $like = new Like();
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    //認証されたユーザーがいいねした投稿を表示
    public function likeBulletinBoard()
    {
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like();
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    //投稿にいいねをつける処理
    public function postLike(Request $request)
    {
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like();

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json(['success' => true]);
    }

    //投稿のいいねを解除する処理
    public function postUnLike(Request $request)
    {
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like();

        $like->where('like_user_id', $user_id)->where('like_post_id', $post_id)->delete();

        return response()->json(['success' => true]);
    }

    // 投稿のいいね数を取得する処理
    public function getLikeCount($post_id)
    {
        $post = Post::withCount('likes')->find($post_id);
        return response()->json(['like_count' => $post->likes_count]);
    }
}
