<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (auth()->check())
        {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'bail|required|string|max:70',
            'phone' => 'bail|required|string|min:11|max:11',
            'address' => 'bail|required|string|min:5|max:250',
            'zip_code' => 'bail|nullable|string|min:10|max:10',
            'shipping_method' => 'bail|required|integer|min:1|exists:shipping_methods,id',
        ];
    }
}
