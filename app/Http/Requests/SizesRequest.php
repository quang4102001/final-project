<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SizesRequest extends FormRequest
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
            'CreateSizeName' => 'required|min:1|max:255|unique:sizes,name',
        ];
    }

    public function messages()
    {
        return [
            'CreateSizeName.required' => 'Bắt buộc phải nhập trường :attributes.',
            'CreateSizeName.min' => 'Nhập ít nhất :min kí tự.',
            'CreateSizeName.max' => 'Nhập nhiều nhất :max kí tự.',
            'CreateSizeName.unique' => 'Trùng :attributes.',
        ];
    }

    public function attributes()
    {
        return [
            'CreateSizeName' => 'tên kích thước',
        ];
    }
}
