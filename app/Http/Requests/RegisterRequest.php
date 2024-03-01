<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|unique:users|unique:admins|min:8|max:30',
            'name' => 'required|max:255',
            'password'=> 'required|max:255|min:8',
            're_password'=> 'required|max:255|min:8|same:password',
            'email' => 'required|email|unique:users|unique:admins',
        ];
    }
    public function messages(): array
    {
        return [
            'username.required' => 'Bắt buộc phải nhập trường :attribute.',
            'username.unique' => ':Attribute đã tồn tại.',
            'username.min' => 'Nhập ít nhất :min kí tự.',
            'username.max' => 'Nhập tối đã :max kí tự.',
            'name.required' => 'Bắt buộc phải nhập trường :attribute.',
            'password.required' => 'Bắt buộc phải nhập trường :attribute.',
            're_password.required' => 'Bắt buộc phải nhập trường :attribute.',
            'email.required' => 'Bắt buộc phải nhập trường :attribute.',
            'email.unique' => ':Attribute đã tồn tại.',
            'email.email' => ':Attribute không đúng định dạng.',
            'name.max' => 'Nhập tối đã :max kí tự.',
            'password.max' => 'Nhập tối đã :max kí tự.',
            're_password.max' => 'Nhập tối đã :max kí tự.',
            'password.min' => 'Nhập ít nhất :min kí tự.',
            're_password.min' => 'Nhập ít nhất :min kí tự.',
            're_password.same' => ':Attribute không đúng.',
        ];
    }

    public function attributes(){
        return [
            'username' => 'tên tài khoản',
            'name' => 'tên người dùng',
            'password' => 'mật khẩu',
            're_password' => 'mật khẩu nhập lại',
            'email' => 'địa chỉ email',
        ];
    }
}
