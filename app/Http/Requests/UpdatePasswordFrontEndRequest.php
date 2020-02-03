<?php

namespace App\Http\Requests;

use App\Rules\Admin\PasswordResetAuthKeyRule;
use App\Rules\FrontEnd\PasswordResetAuthFrontEndKeyRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordFrontEndRequest extends FormRequest
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
            'auth_key' => ['required', new PasswordResetAuthFrontEndKeyRule(request()->email)],
            'new_password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'confirm_password' => 'required_with:new_password|same:new_password',
        ];
    }

    /**
     * Messages of validate errors
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => trans('messages.users.password_reset.required'),
            'min' => trans('messages.users.password_reset.password.min'),
            'regex' => trans('messages.users.password_reset.password.regex'),
            'required_with' => trans('messages.users.password_reset.confirm_password.required_with'),
            'same' => trans('messages.users.password_reset.confirm_password.same'),
        ];
    }

    public function attributes()
    {
        return [
            'auth_key' => 'The verification code',
            'new_password' => 'New password',
            'confirm_password' => 'Confirm password',
        ];
    }
}
