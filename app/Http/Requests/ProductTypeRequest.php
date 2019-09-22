<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductTypeRequest extends FormRequest
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
            'product_type_name' => 'required|min:3|max:100|unique:product_types,product_type_name,'.($this->id ?? " "),
            'category_id' => 'required',
            'product_category_id' => 'required',
        ];
    }

    /**
     * Get the validation messages applied to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => trans("messages.product_type.name.required"),
            'min' => trans("messages.product_type.name.min"),
            'max' => trans("messages.product_type.name.max"),
            'unique' => trans("messages.product_type.name.unique"),
            'category_id.required' => trans("messages.product_type.category_id.required"),
            'product_category_id.required' => trans("messages.product_type.product_category_id.required"),
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'product_type_name' => 'Product type name',
        ];
    }
}
