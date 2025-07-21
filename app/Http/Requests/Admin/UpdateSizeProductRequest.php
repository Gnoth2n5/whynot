<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSizeProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'quantity' => 'required|integer|min:1',
            'price_sell' => 'nullable|numeric|min:0',
            'price_import' => 'nullable|numeric|min:0',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'quantity.required' => __('message.required', ['attribute' => 'Số lượng']),
            'price_sell.numeric' => 'Giá bán phải là số',
            'price_sell.min' => 'Giá bán phải lớn hơn hoặc bằng 0',
            'price_import.numeric' => 'Giá nhập phải là số',
            'price_import.min' => 'Giá nhập phải lớn hơn hoặc bằng 0',
        ];
    }
}
