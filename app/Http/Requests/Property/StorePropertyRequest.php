<?php

namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRequest extends FormRequest
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
            'property_name' => 'bail|required|string|min:2|max:100',
            'property_value' => 'bail|required|string|min:1|max:250',
            'priority' => 'bail|required|integer|min:0|max:1',
            'product_id' => 'bail|required|integer|min:1|exists:products,id',
        ];
    }
}
