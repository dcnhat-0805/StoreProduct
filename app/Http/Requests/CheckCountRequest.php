<?php

namespace App\Http\Requests;

use App\Rules\FrontEnd\CheckAddressRules;
use Illuminate\Foundation\Http\FormRequest;

class CheckCountRequest extends FormRequest
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
            'name' => "required|min:5|max:50",
            'email' => 'required|email',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|max:10',
            'city' => 'required',
            'district' => 'required',
            'wards' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'required' => trans("messages.check_count.name.required"),
            'city.required' => trans("messages.check_count.address.required"),
            'district.required' => trans("messages.check_count.address.required"),
            'wards.required' => trans("messages.check_count.address.required"),
            'email' => trans("messages.check_count.email.email_format"),
            'min' => trans("messages.check_count.name.min"),
            'max' => trans("messages.check_count.name.max"),
            'phone.regex' => trans("messages.check_count.phone.regex"),
            'phone.max' => trans("messages.check_count.phone.max"),
        ];
    }
    public function attributes()
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone number',
        ];
    }
}
