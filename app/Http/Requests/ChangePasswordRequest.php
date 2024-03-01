<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'old_password' => ['required'],
            'password' => ['required', 'different:old_password'],
            're_password' => ['required', 'same:password'],
        ];
    }

    public function messages() {
        return [
            'old_password.required' => 'Bắt buộc nhập :attribute.',
            'password.required' => 'Bắt buộc nhập :attribute.',
            'password.different' => ':Attribute phải khác với mật khẩu cũ',
            're_password.required' => 'Bắt buộc nhập :attribute.',
            're_password.same' => ':Attribute khác với mật khẩu mới',
        ];
    }

    public function attributes() {
        return [
            'old_password' => 'Mật khẩu cũ',
            'password' => 'Mật khẩu mới',
            're_password' => 'Mật khẩu nhập lại',
        ];
    }
}
