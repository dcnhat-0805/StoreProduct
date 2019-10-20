<?php

namespace App\Http\Requests;

use App\Rules\Admin\CheckPriceProduct;
use App\Rules\Admin\CheckPromotionalProduct;
use App\Rules\Admin\MaxLengthTextArea;
use App\Rules\Admin\MinLengthTextArea;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'product_name' => 'required|min:5|max:255|unique:products,product_name,'.($this->id ?? ""),
            'category_id' => 'required',
            'product_category_id' => 'required',
            'product_description' => ['required', new MinLengthTextArea(20, trans("messages.product.product_description.min")),
                                        'unique:products,product_description,' . ($this->id ?? ""),
                                        new MaxLengthTextArea(255, trans("messages.product.product_description.max")),
                                    ],
            'product_content' => ['required', new MinLengthTextArea(50, trans("messages.product.product_content.min")),
                                    'unique:products,product_content,' . ($this->id ?? ""),
                                ],
            'product_price' => ['required', 'integer', new CheckPriceProduct(request()->product_price, request()->product_promotional)],
            'product_promotional' => ['required', 'integer', new CheckPromotionalProduct(request()->product_price, request()->product_promotional)],
            'product_image' => ($this->id ? 'nullable' : 'required'),
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
            'required' => trans("messages.product.name.required"),
            'min' => trans("messages.product.name.min"),
            'max' => trans("messages.product.name.max"),
            'unique' => trans("messages.product.name.unique"),
            'category_id.required' => trans("messages.product.category_id.required"),
            'product_category_id.required' => trans("messages.product.product_category_id.required"),
            'product_type_id.required' => trans("messages.product.product_type_id.required"),
            'product_content.min' => trans("messages.product.product_content.min"),
            'product_description.min' => trans("messages.product.product_description.min"),
            'product_description.max' => trans("messages.product.product_description.max"),
            'numeric' => trans("messages.product.numeric"),
            'image' => trans("messages.product.image"),
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
            'product_name' => 'Product name',
            'product_description' => 'Product description',
            'product_content' => 'Product content',
            'product_price' => 'Product price',
            'product_promotional' => 'Product promotional',
            'product_image' => 'Product image',
        ];
    }
}
