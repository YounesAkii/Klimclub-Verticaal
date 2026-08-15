<?php

namespace App\Http\Requests;

use App\Models\FaqCategory;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FaqRequest extends FormRequest
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
        return [
            'faq_category_id' => ['required', Rule::exists(FaqCategory::class, 'id')],
            'question' => ['required', 'string', 'min:10', 'max:255'],
            'answer' => ['required', 'string', 'min:10', 'max:5000'],
            'position' => ['required', 'integer', 'min:0', 'max:999'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'faq_category_id' => 'categorie',
            'question' => 'vraag',
            'answer' => 'antwoord',
            'position' => 'volgorde',
        ];
    }
}
