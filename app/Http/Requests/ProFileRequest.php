<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class ProFileRequest extends FormRequest
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
            'email' => 'required|email',
            'name' => 'required|max:20|min:3',
            'phone' => 'required|numeric|digits_between:9,11',
            'old' => 'required|numeric|min:18|max:150',
            'address' => 'required',
            'stall_name' => 'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'email là bắt buộc!',
            'email.email'  => 'email không đúng định dạng!',
            'name.required'  => 'tên là bắt buộc!',
            'name.min'  => 'tên tối thiểu gồm 3 ký tự!',
            'name.max'  => 'tên tối đa 20 ký tự!',
            'phone.required'  => 'số điện thoại là bắt buộc!',
            'phone.digits_between'  => 'số điện thoại tối thiểu 10, tối đa 11 số!',
            'phone.numeric'  => 'số điện thoại phải là dạng số!',
            'old.required'  => 'tuổi là bắt buộc!',
            'old.numeric'  => 'tuổi phải là dang số!',
            'old.min'  => 'tuổi nhỏ nhất là 18 tuổi!',
            'old.max'  => 'tuổi lớn nhất là 150 tuổi!',
            'address.required'  => 'địa chỉ là bắt buộc!',
            'stall_name.required' => 'Tên gian hàng là trường bắt buộc!',
            'stall_name.max' => 'Tên gian hàng không được quá 255 ký tự!',
        ];
    }
}
