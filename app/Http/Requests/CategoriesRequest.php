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
            'name' => 'required|min:3|max:255|unique:categories,name,' . $this->id . ',id,deleted_at,NULL',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Bắt buộc phải nhập trường :attribute.',
            'name.min' => 'Nhập ít nhất :min kí tự.',
            'name.max' => 'Nhập nhiều nhất :max kí tự.',
            'name.unique' => 'Trùng :attribute.',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'tên danh mục',
        ];
    }
}
