<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryRequest extends FormRequest
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
            'product_category_name' => 'required|min:3|max:100|unique:product_categories,product_category_name,'.($this->id ?? " "),
            'category_id' => 'required',
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
            'required' => trans("messages.product_category.name.required"),
            'min' => trans("messages.product_category.name.min"),
            'max' => trans("messages.product_category.name.max"),
            'unique' => trans("messages.product_category.name.unique"),
            'category_id.required' => trans("messages.product_category.id.required"),
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
            'category_id' => 'Category Id',
            'product_category_name' => 'Product category name',
        ];
    }
}
