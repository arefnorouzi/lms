<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'meta' => 'bail|nullable|string|min:2|max:250',
            'description' => 'bail|nullable|string|min:10',
            'image' => 'bail|nullable|image|mimes:jpeg,png,jpg|max:2048|dimensions:min_width=300,min_height=300',

        ];
    }
}
