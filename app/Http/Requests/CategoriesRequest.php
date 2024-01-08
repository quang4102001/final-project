<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesRequest extends FormRequest
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
            'CreateCategoryName' => 'required|min:3|max:255|unique:categories,name',
        ];
    }

    public function messages()
    {
        return [
            'CreateCategoryName.required' => 'Bắt buộc phải nhập trường "attributes.',
            'CreateCategoryName.min' => 'Nhập ít nhất :min kí tự.',
            'CreateCategoryName.max' => 'Nhập nhiều nhất :max kí tự.',
            'CreateCategoryName.unique' => 'Trùng "attributes.',
        ];
    }

    public function attributes()
    {
        return [
            'CreateCategoryName' => 'tên danh mục',
        ];
    }
}
