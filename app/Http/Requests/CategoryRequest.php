<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'category_name' => 'required|min:3|max:100|unique:categories,category_name,'.($this->id ?? " "),
            'category_order' => 'required|min:0|numeric|unique:categories,category_order,'.($this->id ?? " "),
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
            'required' => ':attribute '.trans("messages.category.name.required"),
            'min' => ':attribute '.trans("messages.category.name.min"),
            'max' => ':attribute '.trans("messages.category.name.max"),
            'unique' => ':attribute '.trans("messages.category.name.unique"),
            'numeric' => ':attribute '.trans("messages.category.name.numeric"),
            'category_order.min' => ':attribute '.trans("messages.category.order.min"),
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
            'category_name' => 'Category name',
            'category_order' => 'Category order',
        ];
    }
}
