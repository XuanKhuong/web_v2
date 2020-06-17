<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComponentRequest extends FormRequest
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
            'name' => 'required',
            'description' =>'max:500'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'bạn chưa nhập tên sản phẩm!',
            'description.max' => 'mô tả tối đa 500 ký tự!'
        ];
    }
}
