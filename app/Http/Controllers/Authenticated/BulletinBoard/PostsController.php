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
use App\Http\Requests\MaincategoryRequest;
use App\Http\Requests\SubcategoryRequest;
use Auth;

class PostsController extends Controller
{
    // //投稿の一覧を表示
    public function show(Request $request)
    {
        //投稿一覧を取得するためのクエリビルダーを初期化
        $query = Post::with(['user', 'postComments', 'subCategories']) //投稿に関連するユーザー、コメント、サブカテゴリーを一緒に取得
            ->withCount('likes'); // 各投稿に対する「いいね」の数をカウント

        //キーワード検索の処理
        //検索キーワードが入力されているか確認
        if(!empty($request->keyword)){
            //投稿が指定されたサブカテゴリーに関連付けられているかを確認
            $query->whereHas('subCategories', function ($query) use ($request){
                //サブカテゴリー名がキーワードと完全一致する投稿をフィルタリング
                $query->where('sub_category', $request->keyword);
            });

        //サブカテゴリー検索の処理
            //フォームから送信されたサブカテゴリーの検索条件
        } elseif ($request->category_word) {
            $sub_category = $request->category_word;
            //投稿が指定されたサブカテゴリーに関連付けられているかを確認
            $query->whereHas('subCategories', function ($query) use ($sub_category) {
                //サブカテゴリー名が指定された文字列と一致する投稿をフィルタリング
                $query->where('sub_category', $sub_category);
            });

        //ユーザーが「いいね」した投稿のみを表示
            //ユーザーが「いいね」した投稿を表示するかどうかを示すリクエストパラメータ
        } elseif ($request->like_posts) {
            //ログインしているユーザーが「いいね」した投稿のIDを取得
            $likes = Auth::user()->likePostId()->pluck('like_post_id');
            //投稿IDがユーザーの「いいね」リストに含まれているものをフィルタリング
            $query->whereIn('id', $likes);

        //自分の投稿の表示
            //ユーザーが自分の投稿のみを表示するかどうかを示すリクエストパラメータ
        } elseif ($request->my_posts) {
            //投稿の user_id が現在のユーザーのIDと一致するものをフィルタリング
            $query->where('user_id', Auth::id());
        }

        //上記の条件を適用した投稿の一覧をデータベースから取得
        $posts = $query->get();

        //メインカテゴリーとそれに関連するサブカテゴリーの一覧を取得
        //with('subCategories'): メインカテゴリーに関連するサブカテゴリーを一緒に取得します
        $categories = MainCategory::with('subCategories')->get();

        //取得した投稿とカテゴリーのデータをビューに渡して表示
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories'));
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

        // リクエストからサブカテゴリーIDを取得
        //投稿をどのサブカテゴリーに関連付けるかを決定するための情報を取得
        $sub_category = $request->post_category_id;

        // 投稿とサブカテゴリーを関連付け
        //サブカテゴリーと関連付ける対象の投稿をデータベースから取得
        $post_subcategory = Post::findOrFail($post->id);
        //投稿を指定されたサブカテゴリーに関連付けることで、データベース上でその投稿がどのサブカテゴリーに属しているかを記録
        $post_subcategory->subCategories()->attach($sub_category);

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
    public function mainCategoryCreate(MaincategoryRequest $request)
    {
        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }

    //新しいサブカテゴリを作成
    public function subCategoryCreate(SubcategoryRequest $request)
    {
        SubCategory::create([
            'main_category_id' => $request->main_category_id, // 選択されたメインカテゴリーのID
            'sub_category' => $request->sub_category_name, // フォームで入力されたサブカテゴリー名
        ]);

        // 投稿入力画面にリダイレクト
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
