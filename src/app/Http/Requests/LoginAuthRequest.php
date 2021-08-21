<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginAuthRequest extends FormRequest
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
    public function messages()
    {
        return [
            'email.required' => 'Địa chỉ email không được để trống',
            'email.email' => 'Địa chỉ email không hợp lệ',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => "Mật khẩu phải có ít nhất 6 ký tự",
            'password.max' => 'Mật khẩu không được quá 12 ký tự'
        ];
    }
    public function rules()
    {
        return [
            'password' => 'required|min:6|max:12',
            'email' => 'required|email',
        ];
    }
}
