<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function getValidatorInstance()
    {
        // プルダウンで選択された値(= 配列)を取得
        $old_year = $this->input('old_year');
        $old_month = $this->input('old_month');
        $old_day = $this->input('old_day');

        // 日付を作成(ex. 2020-1-20)
        $birth_day = $old_year . '-' . $old_month . '-' . $old_day;

        // rules()に渡す値を追加でセット
        //     これで、この場で作った変数にもバリデーションを設定できるようになる
        $this->merge([
            'birth_day' => $birth_day,
        ]);

        return parent::getValidatorInstance();
    }

    public function rules()
    {
        return [
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|max:30|regex:/^[ァ-ヶー]+$/u',
            'under_name_kana' => 'required|string|max:30|regex:/^[ァ-ヶー]+$/u',
            'mail_address' => 'required|unique:users|email|max:100',
            'sex' => 'required|in:1,2,3',

            // getValidatorInstance()内で作成した値にバリデーションを設定
            'birth_day' => 'required|date|after_or_equal:2000-01-01',

            'role' => 'required|in:1,2,3,4',
            'password' => 'required|confirmed|min:8|max:30|alpha_num',
        ];
    }

    public function messages()
    {
        return [
            'over_name.required' => '姓は必須項目です。',
            'over_name.max' => '10文字以内で入力してください。',

            'under_name.required' => '名は必須項目です。',
            'under_name.max' => '10文字以内で入力してください。',

            'over_name_kana.required' => 'セイは必須項目です。',
            'over_name_kana.max' => '30文字以内で入力してください。',
            'over_name_kana.regex' => 'カタカナで入力してください。',

            'under_name_kana.required' => 'メイは必須項目です。',
            'under_name_kana.max' => '30文字以内で入力してください。',
            'under_name_kana.regex' => 'カタカナで入力してください。',

            'mail_address.required' => 'メールアドレスは必須項目です。',
            'mail_address.email' => '有効な電子メール アドレスである必要があります。',
            'mail_address.unique' => '同じメールアドレスは使用できません。',

            'sex.required' => '性別は必須項目です。',

            'birth_day.required' => '年は必須項目です。',
            'birth_day.date' => '日時として認識できる文字列で入力して下さい。',
            'birth_day.after_or_equal' => '日付は2000年1月1日から今日まででなければなりません。',

            'role.required' => '役職は必須項目です。',

            'password.required' => 'パスワードは必須項目です。',
            'password.confirmed' => '確認用パスワードが一致しません。',
            'password.min' => 'パスワードは8文字以上30文字以下で入力してください。',
            'password.max' => 'パスワードは8文字以上30文字以下で入力してください。',
        ];
    }
}
