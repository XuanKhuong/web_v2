<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmailReqest extends FormRequest
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
            'email' => 'required|email|unique:users',
            'name' => 'required|max:20|min:3',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'email là bắt buộc!',
            'email.email'  => 'email không đúng định dạng!',
            'email.unique'  => 'email không được trùng!',
            'name.required'  => 'tên là bắt buộc!',
            'name.min'  => 'tên tối thiểu gồm 3 ký tự!',
            'name.max'  => 'tên tối đa 20 ký tự!',
        ];
    }
}
