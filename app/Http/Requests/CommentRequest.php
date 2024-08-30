<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'comment' => 'required|string|max:250',
        ];
    }

    public function messages()
    {
        return [
            'comment.required' => '入力は必須です。',
            'comment.max' => '250字以内で入力して下さい。',
        ];
    }
}
