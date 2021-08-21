<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class StoreStudentRequest extends FormRequest
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
    //         'name.required' => 'Trường tên không được để trống',
    //         'email.required' => 'Trường email không được để trống',
    //         'email.unique' => 'Email này đã có người sử dụng',
    //         'email.email' => 'Đại chỉ email không hợp lệ',
    //         'phone.required' => 'Số điện thoại không được để trống',
    //         'phone.regex' => 'Số điện thoại phải bao gồm 10 chữ số và bắt đầu bằng số 0',
    //     ];
    // }
    public function rules()
    {
        return [
            'name'=> 'required',
            'content' => 'required',
            'email' => 'required|unique:students|email|unique:users,email',
            'phone' => 'required|regex:/(0)[0-9]{9}/'
        ];
    }
}
