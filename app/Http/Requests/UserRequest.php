<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 * Validatie voor het handmatig aanmaken en bewerken van gebruikers door een
 * admin. Bij het bewerken is een nieuw wachtwoord optioneel.
 */
class UserRequest extends FormRequest
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
        $user = $this->route('user');

        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'min:3',
                'max:30',
                'regex:/^[A-Za-z0-9_-]+$/',
                Rule::unique(User::class)->ignore($user?->id),
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user?->id),
            ],
            'password' => [$user ? 'nullable' : 'required', 'confirmed', Password::defaults()],
            'birthday' => ['nullable', 'date', 'before:today', 'after:1900-01-01'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'is_admin' => ['nullable', 'boolean'],
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
            'password' => 'wachtwoord',
            'birthday' => 'verjaardag',
            'bio' => 'over mij',
            'is_admin' => 'beheerder',
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
