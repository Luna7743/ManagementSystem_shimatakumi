<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const UPDATED_AT = null;
    // const CREATED_AT = null;

    protected $fillable = ['user_id', 'post_title', 'post'];

    public function user()
    {
        return $this->belongsTo('App\Models\Users\User');
    }

    public function postComments()
    {
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    public function subCategories()
    {
        // リレーションの定義
        return $this->belongsToMany(
            'App\Models\Categories\SubCategory', // 関連付けるモデル
            'post_sub_category', // 中間テーブル名
            'post_id', // 現在のモデルの外部キー
            'sub_category_id', // 関連付けるモデルの外部キー
        );
    }

    // 指定された投稿 ($post_id) に対するコメントの数を返します
    public function commentCounts($post_id)
    {
        // return Post::with('postComments')->find($post_id)->postComments();
        return Post::withCount('postComments')->find($post_id)->post_comments_count;
    }

    //特定の投稿に対するコメントの数を返す
    public function postCommentsCount()
    {
        // return $this->hasMany('App\Models\Posts\PostComment')->count();
        return $this->postComments()->count();
    }

    // 「いいね」リレーションシップの定義
    public function likes()
    {
        return $this->hasMany('App\Models\Posts\Like', 'like_post_id');
    }
}
