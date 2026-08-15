<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'min:3',
                'max:30',
                // Enkel letters, cijfers, streepjes en underscores: de username
                // komt in de URL van de publieke profielpagina terecht.
                'regex:/^[A-Za-z0-9_-]+$/',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'birthday' => ['nullable', 'date', 'before:today', 'after:1900-01-01'],
            'bio' => ['nullable', 'string', 'max:1000'],
            // 1536 KB blijft onder de standaard upload_max_filesize van PHP (2M),
            // zodat een te groot bestand hier een duidelijke melding oplevert in
            // plaats van door PHP zelf geweigerd te worden.
            'avatar' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:1536'],
            'remove_avatar' => ['nullable', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'naam',
            'username' => 'gebruikersnaam',
            'email' => 'e-mailadres',
            'birthday' => 'verjaardag',
            'bio' => 'over mij',
            'avatar' => 'profielfoto',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'username.regex' => 'De gebruikersnaam mag enkel letters, cijfers, koppeltekens en underscores bevatten.',
        ];
    }
}
