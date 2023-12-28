<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            "username" => 'required|min:8|max:255',
            "password" => 'required|min:8|max:255',
        ];
    }
    public function messages(): array
    {
        return [
            "username.required" => 'Bắt buộc phải nhập trường :attribute.',
            "username.min" => 'Nhập ít nhất :min kí tự.',
            "username.max" => 'Nhập tối đa :max kí tự.',
            "password.required" => 'Bắt buộc phải nhập trường :attribute.',
            "password.min" => 'Nhập ít nhất :min kí tự.',
            "password.max" => 'Nhập tối đa :max kí tự.',
        ];
    }
    public function attributes(): array
    {
        return [
            "username" => 'tên tài khoản',
            "password" => 'mật khẩu',
        ];
    }
}
