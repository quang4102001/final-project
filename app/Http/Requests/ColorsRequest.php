<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

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
            'name' => 'required|unique:colors,name,' . $this->id . ',id,deleted_at,NULL',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Bắt buộc phải nhập trường :attribute.',
            'name.unique' => 'Trùng :attribute.',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'mã màu'
        ];
    }
}
