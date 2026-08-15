<?php

namespace App\Http\Requests;

use App\Models\NewsItem;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsItemRequest extends FormRequest
{
    /**
     * De 'admin' middleware bewaakt deze routes al; hier is geen extra
     * autorisatie nodig.
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
        $newsItem = $this->route('newsItem');

        return [
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'excerpt' => ['required', 'string', 'min:20', 'max:500'],
            'content' => ['required', 'string', 'min:50'],
            'published_at' => ['required', 'date'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9-]+$/',
                Rule::unique(NewsItem::class)->ignore($newsItem?->id),
            ],
            // Bij het aanmaken is een afbeelding verplicht; bij het bewerken mag
            // de bestaande afbeelding blijven staan.
            // Zie ProfileUpdateRequest: 1536 KB blijft onder de standaard
            // upload_max_filesize van PHP (2M).
            'image' => [$newsItem ? 'nullable' : 'required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:1536'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'titel',
            'excerpt' => 'samenvatting',
            'content' => 'inhoud',
            'published_at' => 'publicatiedatum',
            'slug' => 'slug',
            'image' => 'afbeelding',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'slug.regex' => 'De slug mag enkel kleine letters, cijfers en koppeltekens bevatten.',
        ];
    }
}
