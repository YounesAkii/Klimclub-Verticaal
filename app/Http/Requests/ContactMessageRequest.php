<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ContactMessageRequest extends FormRequest
{
    /**
     * Het contactformulier staat open voor alle bezoekers, ook zonder account.
     */
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
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'subject' => ['required', 'string', 'min:3', 'max:255'],
            'message' => ['required', 'string', 'min:20', 'max:5000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'naam',
            'email' => 'e-mailadres',
            'subject' => 'onderwerp',
            'message' => 'bericht',
        ];
    }
}
