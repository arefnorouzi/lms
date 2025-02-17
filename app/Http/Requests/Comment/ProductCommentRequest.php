<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class ProductCommentRequest extends FormRequest
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
            'product_id' => 'bail|required|integer|min:1|exists:products,id',
            'parent_id' => 'bail|nullable|integer|min:1|exists:comments,id',
            'description' => 'bail|required|string|min:2|max:255',
        ];
    }

    protected function prepareForValidation(): void
    {
        if($this->parent_id == 0)
        {
            $this->parent_id = null;
        }
        $this->merge([
            'parent_id' => $this->parent_id
        ]);
    }
}
