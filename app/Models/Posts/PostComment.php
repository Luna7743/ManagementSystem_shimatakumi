<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;

class PostComment extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'post_id',
        'user_id',
        'comment',
    ];

    // 3. 投稿（Post）モデルとのリレーション定義
    public function post(){
        return $this->belongsTo('App\Models\Posts\Post');
    }

    // 4. 特定のユーザー情報を取得するメソッド
    public function commentUser($user_id){
        return User::where('id', $user_id)->first();
    }
}
