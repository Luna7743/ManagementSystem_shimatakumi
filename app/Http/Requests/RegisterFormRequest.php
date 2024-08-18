<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon; // Carbon クラスをインポート

class RegisterFormRequest extends FormRequest
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
    public function rules()
    {
        return [
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|max:30|regex:/^[\p{Katakana}ー－]+$/u',
            'under_name_kana' => 'required|string|max:30|regex:/^[\p{Katakana}ー－]+$/u',
            'mail_address' => 'required|email|max:100|unique:users,mail_address',
            'sex' => 'required|in:1,2,3',
            'old_year' => 'required|integer|between:2000,' . date('Y'),
            'old_month' => 'required|integer|between:1,12',
            'old_day' => 'required|integer|between:1,31',
            'role' => 'required|in:1,2,3,4',
            'password' => 'required|string|min:8|max:30|confirmed',
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

            'old_year.required' => '年は必須項目です。',
            'old_year.integer' => '年は整数で入力してください。',
            'old_year.between' => '日付は2000年1月1日から今日まででなければなりません。',

            'old_month.required' => '月は必須項目です。',
            'old_month.integer' => '月は整数で入力してください。',


            'old_day.required' => '日は必須項目です。',
            'old_day.integer' => '日は整数で入力してください。',


            'role.required' => '役職は必須項目です。',

            'password.required' => 'パスワードは必須項目です。',
            'password.confirmed' => '確認用パスワードが一致しません。',
            'password.min' => 'パスワードは8文字以上30文字以下で入力してください。',
            'password.max' => 'パスワードは8文字以上30文字以下で入力してください。',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $year = $this->input('old_year');
            $month = $this->input('old_month');
            $day = $this->input('old_day');

            // 日付の妥当性チェック
            if (!checkdate($month, $day, $year)) {
                $validator->errors()->add('old_day', '無効な日付です。');
            }
        });
    }

}
