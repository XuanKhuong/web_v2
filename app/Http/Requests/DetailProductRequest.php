<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetailProductRequest extends FormRequest
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
            'name' => 'required|max:255|min:3',
            'qty' => 'required|numeric|min:10',
            'price' => 'required|integer|min:4',
            'sale_price' => 'required|integer|min:4',
            'slug' => 'required',
            'description' => 'max:500'
        ];
    }

    public function messages()
    {
        return [
            'name.required'  => 'tên là bắt buộc!',
            'name.min'  => 'tên tối thiểu gồm 3 ký tự!',
            'name.max'  => 'tên tối đa 255 ký tự!',
            'qty.required'  => 'số điện thoại là bắt buộc!',
            'qty.min'  => 'số điện thoại tối thiểu 10 số!',
            'qty.numeric'  => 'số điện thoại phải là dạng số!',
            'price.required'  => 'giá là bắt buộc!',
            'price.integer'  => 'giá phải là dang số!',
            'price.min'  => 'giá nhỏ nhất là 4 số!',
            'sale_price.required'  => 'giá là bắt buộc!',
            'sale_price.integer'  => 'giá phải là dang số!',
            'sale_price.min'  => 'giá nhỏ nhất là 4 số!',
            'slug.required'  => 'đường dẫn là bắt buộc!',
            'description.max'  => 'mô tả tối đa là 500 ký tự!',
        ];
    }
}
