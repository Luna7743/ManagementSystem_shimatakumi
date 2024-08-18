<?php

//Laravelの ユーザー登録 機能を担当するコントローラーです
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Users\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterFormRequest;
use DB;

use App\Models\Users\Subjects;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

     //ユーザーが登録フォームにアクセスするためのビューを返します
    public function registerView()
    {
        $subjects = Subjects::all();
        return view('auth.register.register', compact('subjects'));
    }

    //ユーザーの登録処理
    public function registerPost(RegisterFormRequest $request)
    {
        DB::beginTransaction();
        try{
            $old_year = $request->old_year;//ユーザーが入力した生年月日の(年)
            $old_month = $request->old_month;//ユーザーが入力した生年月日の(月)
            $old_day = $request->old_day;//ユーザーが入力した生年月日の(日)
            $data = $old_year . '-' . $old_month . '-' . $old_day;//年、月、日を結合し、strtotime 関数を使用して日時形式に変換
            $birth_day = date('Y-m-d', strtotime($data));//Y-m-d 形式の誕生日に変換
            $subjects = $request->subject;//ユーザーが選択した科目のIDが格納されます

            //ユーザーの作成:
            $user_get = User::create([
                'over_name' => $request->over_name,
                'under_name' => $request->under_name,
                'over_name_kana' => $request->over_name_kana,
                'under_name_kana' => $request->under_name_kana,
                'mail_address' => $request->mail_address,
                'sex' => $request->sex,
                'birth_day' => $birth_day,
                'role' => $request->role,
                'password' => bcrypt($request->password)
            ]);
            $user = User::findOrFail($user_get->id);
            $user->subjects()->attach($subjects);
            DB::commit();
            return view('auth.login.login');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('loginView');
        }
    }
}
