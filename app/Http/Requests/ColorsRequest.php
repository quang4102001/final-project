<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ColorsRequest extends FormRequest
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
            'CreateColorName' => 'required|unique:colors,name',
        ];
    }

    public function messages()
    {
        return [
            'CreateColorName.required' => 'Bắt buộc phải nhập trường :attributes.',
            'CreateColorName.unique' => 'Trùng :attributes.',
        ];
    }

    public function attributes(){
        return [
            'CreateColorName' => 'mã màu'
        ];
    }
}
