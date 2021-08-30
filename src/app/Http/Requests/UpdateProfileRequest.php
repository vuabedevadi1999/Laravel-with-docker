<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
    // public function messages()
    // {
    //     return [
    //         'email.required' => 'Địa chỉ email không được để trống',
    //         'email.email' => 'Địa chỉ email không hợp lệ',
    //         'email.unique' => 'Email này đã có người sử dụng',
    //         'password.required' => 'Mật khẩu không được để trống',
    //         'password.min' => "Mật khẩu phải có ít nhất 6 ký tự",
    //         'password.max' => 'Mật khẩu không được quá 12 ký tự',
    //         'oldPassword.password' => 'Mật khẩu cũ không chính xác',
    //         'oldPassword.required' => 'Mật khẩu cũ không được để trống',
    //         'oldPassword.min' => "Mật khẩu cũ phải có ít nhất 6 ký tự",
    //         'oldPassword.max' => 'Mật khẩu cũ không được quá 12 ký tự',
    //         'password.different' => 'Mật khẩu mới phải khác với mật khẩu cũ',
    //         'password.confirmed' => "Mật khẩu không trùng khớp",
    //         'password_confirmation.required' => 'Mật khẩu không được để trống',
    //         'password_confirmation.min' => "Mật khẩu phải có ít nhất 6 ký tự",
    //         'password_confirmation.max' => 'Mật khẩu không được quá 12 ký tự',
    //         'file.image'=>'Vui lòng chọn hình ảnh 11',
    //         'file.mimes'=>'Vui lòng chọn ảnh có dạng jpeg,png,jpg',
    //         'file.mimetypes'=>'Vui lòng chọn hình ảnh',
    //         'file.max'=>'ảnh chỉ được nhỏ hơn 10MB',
    //     ];
    // }
    public function rules()
    {
        $id = auth()->id();
        return [
            'name' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg|mimetypes:image/jpeg,image/png|max:10000',
            'email' => 'required|email|unique:users,email,'.$id,
            'oldPassword' => 'required|max:12|min:6|password',
            'birthday' => "required|date_format:Y-m-d|before:today", 
            'password' => 'required|max:12|min:6|different:oldPassword|confirmed',
            'password_confirmation' => 'required|max:12|min:6'
        ];
    }
}
