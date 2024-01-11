<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'min:6'],
            'sku' => ['required', 'max:255', 'min:3'],
            'price' => ['required', 'numeric', 'min:1'],
            'discounted_price' => ['required', 'numeric', 'min:1'],
            'category_id' => ['required', 'max:255'],
            'colors' => ['required'],
            'images' => ['required'],
            'sizes' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Trường :attribute là bắt buộc.",
            'name.min' => "Trường :attribute không được ít hơn :min kí tự.",
            'name.max' => "Trường :attribute không được nhiều hơn :max kí tự.",
            'sku.max' => "Trường :attribute không được nhiều hơn :max kí tự.",
            'sku.min' => "Trường :attribute không được ít hơn :min kí tự.",
            'sku.required' => "Trường :attribute là bắt buộc.",
            'price.required' => "Trường :attribute là bắt buộc.",
            'price.numeric' => "Trường :attribute phải là một số.",
            'price.min' => "Trường :attribute phải lớn hơn :min.",
            'discounted_price.required' => "Trường :attribute là bắt buộc.",
            'discounted_price.numeric' => "Trường :attribute phải là một số.",
            'discounted_price.min' => "Trường :attribute phải lớn hơn :min.",
            'category_id.required' => "Trường :attribute là bắt buộc.",
            'category_id.max' => "Trường :attribute không được nhiều hơn :max kí tự.",
            'colors.required' => "Trường :attribute là bắt buộc.",
            'images.required' => "Trường :attribute là bắt buộc.",
            'sizes.required' => "Trường :attribute là bắt buộc.",
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'tên sản phẩm',
            'sku' => 'mã sản phẩm',
            'price' => 'giá sản phẩm',
            'discounted_price' => 'giá sản phẩm đã giảm',
            'category_id' => 'loại sản phẩm',
            'colors' => 'các màu của sản phẩm',
            'images' => 'ảnh của sản phẩm',
            'sizes' => 'các kích cỡ của sản phẩm',
        ];
    }
}
