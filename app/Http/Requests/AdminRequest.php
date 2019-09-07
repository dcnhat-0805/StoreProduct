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
            'password' => ($this->id ? 'nullable' : 'required').'|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'confirm_password' => ($this->id ? 'nullable' : 'required').'|same:password',
        ];
    }
    public function messages()
    {
        return [
            'required' => trans("messages.admin.name.required"),
            'email' => trans("messages.admin.email.email_format"),
            'min' => trans("messages.admin.name.min"),
            'max' => trans("messages.admin.name.max"),
            'unique' => trans("messages.admin.name.unique"),
            'password.min' => trans("messages.admin.password.min"),
            'password.regex' => trans("messages.admin.password.regex"),
            'same' => trans("messages.admin.confirm_password.same"),
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
