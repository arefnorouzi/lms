<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreCategoryRequest extends FormRequest
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
            'name' => 'bail|required|string|min:1|max:100|unique:categories,name',
            'slug' => 'bail|required|string|min:1|max:100|unique:categories,slug',
            'meta' => 'bail|required|string|min:10|max:157',
            'home_page' => 'bail|required|bool',
            'description' => 'bail|nullable|string|min:1|max:1000',
            'parent_id' => 'bail|nullable|integer|min:1|exists:categories,id',
            'image' => 'bail|nullable|image|mimes:jpeg,png,jpg|max:1024|dimensions:min_width=100,min_height=100',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->name),
        ]);
    }
}
