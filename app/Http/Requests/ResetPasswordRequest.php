<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'password' => 'required|max:255|min:8',
            'rePassword' => 'required|max:255|min:8|same:password',
        ];
    }
    public function messages(): array
    {
        return [
            'email.required' => 'Bắt buộc phải nhập trường :attribute.',
            'email.email' => ':Attribute không đúng định dạng.',
            'email.exists' => ':Attribute không tồn tại.',
            'password.required' => 'Bắt buộc phải nhập trường :attribute.',
            'rePassword.required' => 'Bắt buộc phải nhập trường :attribute.',
            'password.max' => 'Nhập tối đã :max kí tự.',
            'rePassword.max' => 'Nhập tối đã :max kí tự.',
            'password.min' => 'Nhập ít nhất :min kí tự.',
            'rePassword.min' => 'Nhập ít nhất :min kí tự.',
            'rePassword.same' => ':Attribute không đúng.',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'địa chỉ email',
            'password' => 'mật khẩu',
            'rePassword' => 'mật khẩu nhập lại',
        ];
    }
}
