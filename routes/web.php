<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//ゲストユーザー向けのルート
Route::group(['middleware' => ['guest']], function(){
    Route::namespace('Auth')->group(function(){
        //登録ページを表示するルート
        Route::get('/register', 'RegisterController@registerView')->name('registerView');
        //ユーザー登録のフォームを処理するルート
        Route::post('/register/post', 'RegisterController@registerPost')->name('registerPost');
        //ログインページを表示するルート
        Route::get('/login', 'LoginController@loginView')->name('loginView');
        //ログインフォームを処理するルート
        Route::post('/login/post', 'LoginController@loginPost')->name('loginPost');
    });
});

//認証済みユーザー向けのルート
Route::group(['middleware' => 'auth'], function(){
    Route::namespace('Authenticated')->group(function(){
        //トップページ関連のルートを扱います
        Route::namespace('Top')->group(function(){
            //ユーザーのログアウトを処理するルート
            Route::get('/logout', 'TopsController@logout');
            //トップページを表示するルート
            Route::get('/top', 'TopsController@show')->name('top.show');
        });

        //カレンダー機能のルート
        Route::namespace('Calendar')->group(function(){
            //一般ユーザー向け
            Route::namespace('General')->group(function(){
                //指定されたユーザーIDのカレンダーを表示
                Route::get('/calendar/{user_id}', 'CalendarsController@show')->name('calendar.general.show');
                //カレンダーに新しい予約を作成
                Route::post('/reserve/calendar', 'CalendarsController@reserve')->name('reserveParts');
                //カレンダーから予約を削除
                Route::post('/delete/calendar', 'CalendarsController@delete')->name('deleteParts');
            });
            //管理者向け
            Route::namespace('Admin')->group(function(){
                //特定のユーザーIDに対応する管理者用カレンダー表示ページを提供するルート
                Route::get('/calendar/{user_id}/admin', 'CalendarsController@show')->name('calendar.admin.show');
                //特定の日付とパートに対応する予約詳細ページを提供するルート
                Route::get('/calendar/{date}/{part}', 'CalendarsController@reserveDetail')->name('calendar.admin.detail');
                //特定のユーザーIDに対応するカレンダー設定ページを提供するルート
                Route::get('/setting/{user_id}/admin', 'CalendarsController@reserveSettings')->name('calendar.admin.setting');
                //管理者によるカレンダー設定の更新を処理するルート
                Route::post('/setting/update/admin', 'CalendarsController@updateSettings')->name('calendar.admin.update');
            });
        });

        //掲示板（Bulletin Board）機能のルート
        Route::namespace('BulletinBoard')->group(function(){
            //掲示板の投稿を表示するルート
            Route::get('/bulletin_board/posts/{keyword?}', 'PostsController@show')->name('post.show');
            //新しい掲示板の投稿を作成するための入力ページを表示するルート
            Route::get('/bulletin_board/input', 'PostsController@postInput')->name('post.input');
            //ユーザーが「いいね」をした掲示板の投稿を表示するルート
            Route::get('/bulletin_board/like', 'PostsController@likeBulletinBoard')->name('like.bulletin.board');
            //ログインユーザーが投稿した自分の掲示板の投稿を表示するルート
            Route::get('/bulletin_board/my_post', 'PostsController@myBulletinBoard')->name('my.bulletin.board');
            //新しい掲示板の投稿をデータベースに作成するルート
            Route::post('/bulletin_board/create', 'PostsController@postCreate')->name('post.create');
            //掲示板のメインカテゴリを作成するルート
            Route::post('/create/main_category', 'PostsController@mainCategoryCreate')->name('main.category.create');
            //掲示板のサブカテゴリを作成するルート
            Route::post('/create/sub_category', 'PostsController@subCategoryCreate')->name('sub.category.create');
            //特定の投稿の詳細を表示するルート
            Route::get('/bulletin_board/post/{id}', 'PostsController@postDetail')->name('post.detail');
            //掲示板の投稿を編集するルート
            Route::post('/bulletin_board/edit', 'PostsController@postEdit')->name('post.edit');
            //特定の投稿を削除するルート
            Route::get('/bulletin_board/delete/{id}', 'PostsController@postDelete')->name('post.delete');
            //掲示板の投稿に対するコメントを作成するルート
            Route::post('/comment/create', 'PostsController@commentCreate')->name('comment.create');
            //特定の投稿に「いいね」を追加するルート
            Route::post('/like/post/{id}', 'PostsController@postLike')->name('post.like');
            //特定の投稿の「いいね」を取り消すルート
            Route::post('/unlike/post/{id}', 'PostsController@postUnLike')->name('post.unlike');
            // いいねの数を取得する
            Route::get('/get-like-count/{post_id}', 'PostsController@getLikeCount')->name('getLikeCount');
        });

        //ユーザー管理のルート
        Route::namespace('Users')->group(function(){
            //全ユーザーを表示
            Route::get('/show/users', 'UsersController@showUsers')->name('user.show');
            //指定されたIDのユーザープロフィールを表示
            Route::get('/user/profile/{id}', 'UsersController@userProfile')->name('user.profile');
            //ユーザープロフィールを編集
            Route::post('/user/profile/edit', 'UsersController@userEdit')->name('user.edit');
        });
    });
});
