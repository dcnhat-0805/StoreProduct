<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditEmailRequest extends FormRequest
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
            'email' => "required|email|unique:users,name," . ($this->id ?? ""),
        ];
    }
    public function messages()
    {
        return [
            'required' => trans("messages.users.name.required"),
            'email' => trans("messages.users.email.email_format"),
            'min' => trans("messages.users.name.min"),
            'max' => trans("messages.users.name.max"),
            'unique' => trans("messages.users.name.unique"),
            'password_user.min' => trans("messages.users.password.min"),
            'password_user.regex' => trans("messages.users.password.regex"),
            'same' => trans("messages.users.confirm_password.same"),
            'phone.regex' => trans("messages.users.phone.regex"),
            'phone.max' => trans("messages.users.phone.max"),
        ];
    }
    public function attributes()
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'password_user' => 'Password',
            'confirm_password' => 'Confirm Password',
            'phone' => 'Phone number',
        ];
    }
}
