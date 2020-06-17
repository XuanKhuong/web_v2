<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|max:20|min:3',
        ];
    }

    public function messages()
    {
        return [
            'name.required'  => 'tên là bắt buộc!',
            'name.min'  => 'tên tối thiểu gồm 3 ký tự!',
            'name.max'  => 'tên tối đa 20 ký tự!',
        ];
    }
}
