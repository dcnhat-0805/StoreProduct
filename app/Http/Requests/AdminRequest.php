<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'name' => "required|min:5|max:50|unique:admins,name,".($this->id ?? " "),
            'email' => 'required|email|unique:admins,email,'.($this->id ?? " "),
            'password' => ($this->id ? 'nullable' : 'required').'|min:8',
            'confirm_password' => ($this->id ? 'nullable' : 'required').'|same:password',
            'confirm_password' => ($this->id ? 'nullable' : 'required').'|same:password',
        ];
    }
    public function messages()
    {
        return [
            'required' => ':attribute không được để trống.',
            'email' => ':attribute không đúng định dạng email.',
            'min' => ':attribute phải từ 5 - 50 ký tự.',
            'max' => ':attribute phải từ 5 - 50 ký tự.',
            'password.min' => ':attribute phải từ 8 ký tự',
            'unique' => ':attribute đã được sử dụng.',
            'same' => ':attribute không trùng khớp với mật khẩu đã nhập.'
        ];
    }
    public function attributes()
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'confirm_password' => 'Confirm Password'
        ];
    }
}
