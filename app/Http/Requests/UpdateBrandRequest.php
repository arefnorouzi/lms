<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
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
            'name' => 'bail|required|string|min:1|max:100|unique:brands,name,' . $this->brand->id,
            'slug' => 'bail|required|string|min:1|max:100|unique:brands,slug,' . $this->brand->id,
            'meta' => 'bail|required|string|min:10|max:157',
            'description' => 'bail|required|string|min:1|max:1000',
            'image' => 'bail|nullable|image|mimes:jpeg,png,jpg|max:1024|dimensions:min_width=100,min_height=100',
        ];
    }

    protected function prepareForValidation(): void
    {
        $slug = str_replace(".", " ", $this->slug);
        $slug = rtrim($slug);
        $slug = ltrim($slug);
        $slug = str_replace("  ", " ", $slug);
        $slug = str_replace(" ", "-", $slug);
        $this->merge([
            'slug' => $slug,
        ]);
    }
}
