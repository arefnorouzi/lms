<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'bail|required|string|min:3|max:100',
            'subtitle' => 'bail|nullable|string|min:3|max:100',
            'category_id' => 'bail|required|integer|min:1|exists:categories,id',
            'price' => 'bail|required|integer|min:5000',
            'meta' => 'bail|nullable|string|min:2|max:250',
            'description' => 'bail|nullable|string|min:10',
            'stock' => 'bail|required|integer|min:1',
            'offer_price' => 'bail|nullable|integer|min:1000|lt:price',
            'offer_end_date' => 'bail|nullable|date|after:today',
            'image' => 'bail|nullable|image|mimes:jpeg,png,jpg|max:2048|dimensions:min_width=300,min_height=300',

        ];
    }
}
