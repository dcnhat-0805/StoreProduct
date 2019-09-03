<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được để trống.',
            'email' => ':attribute không đúng định dạng email.',
            'password.min' => ':attribute phải từ 8 ký tự',
            'password.regex' => ':attribute phải chứa ít nhất 1 chữ hoa, 1 chữ thường, 1 chữ số và 1 ký tự đặc biệt.'
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email',
            'password' => 'Password',
        ];
    }
}
