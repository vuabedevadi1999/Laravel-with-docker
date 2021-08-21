<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
        $student = $this->route('student');
        $user = User::where('email',$student->email)->first();
        return [
            'name' => 'required',
            'content' => 'required',
            'email' => 'required|email|unique:students,email,'.$student->id .'|unique:users,email,'.$user->id,
            'phone' => 'required|regex:/(0)[0-9]{9}/',
        ];
    }
}
