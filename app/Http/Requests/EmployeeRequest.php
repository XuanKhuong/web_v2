<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'phone' => 'required|numeric|min:10',
            'old' => 'required|numeric|min:18|max:150',
            'address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'  => 'tên là bắt buộc!',
            'name.min'  => 'tên tối thiểu gồm 3 ký tự!',
            'name.max'  => 'tên tối đa 20 ký tự!',
            'phone.required'  => 'số điện thoại là bắt buộc!',
            'phone.min'  => 'số điện thoại tối thiểu 10 số!',
            'phone.numeric'  => 'số điện thoại phải là dạng số!',
            'old.required'  => 'tuổi là bắt buộc!',
            'old.numeric'  => 'tuổi phải là dang số!',
            'old.min'  => 'tuổi nhỏ nhất là 18 tuổi!',
            'old.max'  => 'tuổi lớn nhất là 150 tuổi!',
            'address.required'  => 'địa chỉ là bắt buộc!',
        ];
    }
}
