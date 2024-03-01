<?php

namespace App\Http\Requests;

use App\Rules\ExistsMailInAdminOrUser;
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
            'email' => ['required', 'email', new ExistsMailInAdminOrUser],
            'password' => 'required|max:255|min:8',
            're_password' => 'required|max:255|min:8|same:password',
        ];
    }
    public function messages(): array
    {
        return [
            'email.required' => 'Bắt buộc phải nhập trường :attribute.',
            'email.email' => ':Attribute không đúng định dạng.',
            'password.required' => 'Bắt buộc phải nhập trường :attribute.',
            're_password.required' => 'Bắt buộc phải nhập trường :attribute.',
            'password.max' => 'Nhập tối đã :max kí tự.',
            're_password.max' => 'Nhập tối đã :max kí tự.',
            'password.min' => 'Nhập ít nhất :min kí tự.',
            're_password.min' => 'Nhập ít nhất :min kí tự.',
            're_password.same' => ':Attribute không đúng.',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'địa chỉ email',
            'password' => 'mật khẩu',
            're_password' => 'mật khẩu nhập lại',
        ];
    }
}
