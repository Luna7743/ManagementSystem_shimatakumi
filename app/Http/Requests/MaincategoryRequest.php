<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaincategoryRequest extends FormRequest
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
            'main_category_name' => [
                'required',       // 必須項目
                'string',         // 文字列型
                'max:100',        // 100文字以内
                'unique:main_categories,main_category' // 一意であること
            ]
        ];
    }

    public function messages()
    {
        return [
            'main_category_name.required' => 'メインカテゴリー名は必須です。',
            'main_category_name.string' => 'メインカテゴリー名は文字列である必要があります。',
            'main_category_name.max' => 'メインカテゴリー名は100文字以内で入力してください。',
            'main_category_name.unique' => '同じ名前のメインカテゴリーは既に存在します。',
        ];
    }
}




