<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (auth()->check() && auth()->user()->is_admin)
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
            'customer_name' => 'bail|required|string|max:70',
            'customer_phone' => 'bail|required|string|min:11|max:11',
            'customer_address' => 'bail|required|string|min:5|max:250',
            'post_tracking_code' => 'bail|nullable|string|min:5|max:250',
            'customer_zip_code' => 'bail|nullable|string|min:10|max:10',
            'status' => 'bail|required|string',
            'shipped_at' => 'bail|nullable|date',
            'shipping_method_id' => 'bail|required|integer|min:1|exists:shipping_methods,id',
        ];
    }
}
