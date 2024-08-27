<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];

    public function user(){
        return $this->belongsTo('App\Models\Users\User');
    }

    public function postComments(){
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    public function subCategories(){
        // リレーションの定義
        // return $this->belongsToMany('App\Models\Categories\SubCategory', 'post_sub_category', 'post_id', 'sub_category_id');
    }

    // コメント数
    public function commentCounts($post_id){
        return Post::with('postComments')->find($post_id)->postComments();
        // return Post::withCount('postComments')->find($post_id)->post_comments_count;
    }

    // 「いいね」リレーションシップの定義
    public function likes(){
        return $this->hasMany('App\Models\Posts\Like', 'like_post_id');
    }
}
