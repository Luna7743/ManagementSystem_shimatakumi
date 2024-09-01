<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubcategoryRequest extends FormRequest
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
            'main_category_id' => [
                'required',
                'exists:main_categories,id',
            ],

            'sub_category_name' => [
                'required',
                'string',
                'max:100',
                'unique:sub_categories,sub_category', // メインカテゴリーごとに一意であること
            ]
        ];
    }

    public function messages()
    {
        return [
            'main_category_id.required' => 'メインカテゴリーの選択は必須です。',
            'main_category_id.exists' => '選択されたメインカテゴリーは存在しません。',
            'sub_category_name.required' => 'サブカテゴリー名は必須です。',
            'sub_category_name.string' => 'サブカテゴリー名は文字列である必要があります。',
            'sub_category_name.max' => 'サブカテゴリー名は100文字以内で入力してください。',
            'sub_category_name.unique' => '同じ名前のサブカテゴリーは既に存在します。',
        ];
    }
}
