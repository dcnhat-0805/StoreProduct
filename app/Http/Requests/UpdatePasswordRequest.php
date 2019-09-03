<?php

namespace App\Http\Requests;

use App\Rules\Admin\PasswordResetAuthKeyRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'auth_key' => ['required', new PasswordResetAuthKeyRule(request()->email)],
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
            'auth_key.required' => 'Mã bảo mật không được để trống.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => ':attribute phải từ 8 ký tự,',
            'new_password.regex' => ' phải chứa ít nhất 1 chữ hoa, 1 chữ thường, 1 chữ số và 1 ký tự đặc biệt.',
            'confirm_password.required_with' => 'Vui lòng nhập xác nhật mật khẩu mới.',
            'confirm_password.same' => 'Nhập lại mật khẩu không trùng khớp với mật khẩu mới đã nhập.',
        ];
    }
}
