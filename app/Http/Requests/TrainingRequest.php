<?php

namespace App\Http\Requests;

use App\Models\Training;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TrainingRequest extends FormRequest
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
        $training = $this->route('training');

        return [
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'description' => ['required', 'string', 'min:30'],
            'location' => ['required', 'string', 'max:255'],
            'level' => ['required', Rule::in(['beginner', 'gevorderd', 'alle niveaus'])],
            'capacity' => ['required', 'integer', 'min:1', 'max:200'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
            'instructor_id' => ['nullable', Rule::exists(User::class, 'id')],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9-]+$/',
                Rule::unique(Training::class)->ignore($training?->id),
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'titel',
            'description' => 'omschrijving',
            'location' => 'locatie',
            'level' => 'niveau',
            'capacity' => 'maximum aantal deelnemers',
            'starts_at' => 'startmoment',
            'ends_at' => 'eindmoment',
            'instructor_id' => 'lesgever',
            'slug' => 'slug',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'ends_at.after' => 'Het eindmoment moet na het startmoment liggen.',
            'slug.regex' => 'De slug mag enkel kleine letters, cijfers en koppeltekens bevatten.',
        ];
    }
}
