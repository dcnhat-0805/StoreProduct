<?php

namespace App\Http\Requests;

use App\Rules\FrontEnd\ExistsEmailUserRule;
use Illuminate\Foundation\Http\FormRequest;

class ForgetPasswordFrontEndRequest extends FormRequest
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
            'email' => ['required', new ExistsEmailUserRule()]
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
            'email.required' => trans('messages.admin.password_reset.email.required'),
        ];
    }
}
