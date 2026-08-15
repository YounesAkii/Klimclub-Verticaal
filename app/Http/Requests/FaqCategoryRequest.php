<?php

namespace App\Http\Requests;

use App\Models\FaqCategory;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FaqCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $category = $this->route('faqCategory');

        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique(FaqCategory::class, 'name')->ignore($category?->id),
            ],
            'description' => ['nullable', 'string', 'max:500'],
            'position' => ['required', 'integer', 'min:0', 'max:999'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'naam',
            'description' => 'omschrijving',
            'position' => 'volgorde',
        ];
    }
}
