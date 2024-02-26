<?php

namespace App\Http\Requests;

use App\Rules\ExistsMailInAdminOrUser;
use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
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
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Bắt buộc phải nhập trường :attribute.',
            'email.email' => ':Attribute không đúng định dạng.',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'địa chỉ email',
        ];
    }
}
