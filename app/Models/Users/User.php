<?php

//Laravelフレームワークにおけるユーザー情報を管理するためのモデルで、多くの機能とリレーションを持っています。
namespace App\Models\Users;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Posts\Like;
use Auth;

class User extends Authenticatable
{
    use Notifiable;
    use softDeletes;

    const CREATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'over_name',
        'under_name',
        'over_name_kana',
        'under_name_kana',
        'mail_address',
        'sex',
        'birth_day',
        'role',
        'password'
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //関係性: ユーザーは複数の投稿を持つことができます。
    //用途: あるユーザーが作成したすべての投稿を取得する際に使用します。
    public function posts(){
        return $this->hasMany('App\Models\Posts\Post');
    }

    //関係性: ユーザーは複数のカレンダーに属し、カレンダーも複数のユーザーを持つ（多対多関係）。
    //中間テーブル: calendar_usersテーブルを通じて関係を管理。
    //withPivot:中間テーブルの追加のカラム（user_id, id）も取得することができます。
    public function calendars(){
        return $this->belongsToMany('App\Models\Calendars\Calendar', 'calendar_users', 'user_id', 'calendar_id')->withPivot('user_id', 'id');
    }

    //関係性: ユーザーは複数の予約設定に関連付けられる（多対多関係）。
    //中間テーブル: reserve_setting_usersテーブルを通じて関係を管理。
    //withPivot:中間テーブルのidカラムも取得します。
    public function reserveSettings(){
        return $this->belongsToMany('App\Models\Calendars\ReserveSettings', 'reserve_setting_users', 'user_id', 'reserve_setting_id')->withPivot('id');
    }

    //関係性: ユーザーは複数の科目を持ち、科目も複数のユーザーに関連付けられる（多対多関係）。
    //中間テーブル: subject_usersテーブルを通じて関係を管理。
    public function subjects(){
        // リレーションの定義
        return $this->belongsToMany('App\Models\Users\Subjects', 'subject_users', 'user_id', 'subject_id');
    }

    // いいねしているかどうか
    //機能: 指定された投稿IDに対して、現在のユーザーが「いいね」しているかをチェックします。
    //動作:Likeモデルを使って、like_user_idが現在のユーザーIDで、like_post_idが指定された投稿IDのレコードを検索します。
    //レコードが存在すれば、そのlikes.idを返し、存在しなければnullを返します。
    public function is_Like($post_id){
        return Like::where('like_user_id', Auth::id())->where('like_post_id', $post_id)->first(['likes.id']);
    }

    //機能: 現在のユーザーが「いいね」したすべての投稿を取得します。
    //動作:Likeモデルを使って、like_user_idが現在のユーザーIDのすべてのレコードを取得します。
    public function likePostId(){
        return Like::where('like_user_id', Auth::id());
    }
}
