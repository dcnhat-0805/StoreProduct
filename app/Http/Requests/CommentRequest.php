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
            'comment_contents' => 'required'
        ];
    }

    public function messages()
    {
        return [
          'required' => ':attributes cannot be left blank.'
        ];
    }

    public function attributes()
    {
        return [
            'comment_contents' => 'Comment content'
        ];
    }
}
