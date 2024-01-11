<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SizesStoreRequest extends FormRequest
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
            'name' => 'required|min:1|max:255|unique:sizes,name',
            'minHeight' => 'required|numeric|min:1',
            'maxHeight' => 'required|numeric|min:1',
            'minWeight' => 'required|numeric|min:1',
            'maxWeight' => 'required|numeric|min:1',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Bắt buộc phải nhập trường :attributes.',
            'name.min' => 'Nhập ít nhất :min kí tự.',
            'name.max' => 'Nhập nhiều nhất :max kí tự.',
            'name.unique' => 'Trùng :attributes.',
            'minHeight.required' => 'Bắt buộc phải nhập trường :attributes.',
            'minHeight.min' => ':Attributes phải lớn hơn :min.',
            'minHeight.numeric' => ':Attributes phải là chữ số.',
            'maxHeight.required' => 'Bắt buộc phải nhập trường :attributes.',
            'maxHeight.min' => ':Attributes phải lớn hơn :min.',
            'maxHeight.numeric' => ':Attributes phải là chữ số.',
            'minWeight.required' => 'Bắt buộc phải nhập trường :attributes.',
            'minWeight.min' => ':Attributes phải lớn hơn :min.',
            'minWeight.numeric' => ':Attributes phải là chữ số.',
            'maxWeight.required' => 'Bắt buộc phải nhập trường :attributes.',
            'maxWeight.min' => ':Attributes phải lớn hơn :min.',
            'maxWeight.numeric' => ':Attributes phải là chữ số.',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'tên kích thước',
            'minHeight' => 'chiều cao tối thiểu',
            'maxHeight' => 'chiều cao tối đa',
            'minWeight' => 'cân nặng tối thiểu',
            'maxWeight' => 'cân nặng tối đa',
        ];
    }
}
