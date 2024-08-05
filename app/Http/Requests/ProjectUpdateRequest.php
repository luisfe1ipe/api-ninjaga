<?php

namespace App\Http\Requests;

use App\Enums\StatusProjectEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'synopsis' => ['nullable', 'string'],
            'image' => ['nullable', 'image'],
            'published_at' => ['nullable', 'numeric'],
            'status' => ['sometimes', Rule::enum(StatusProjectEnum::class)],
            'type_id' => ['sometimes', Rule::exists('types', 'id')],
            'genres' => ['nullable', 'array', 'min:1'],
            'genres.*' => ['integer', Rule::exists('genres', 'id')],
            'authors' => ['nullable', 'array', 'min:1'],
            'authors.*' => ['integer', Rule::exists('authors', 'id')],
            'artists' => ['nullable', 'array', 'min:1'],
            'artists.*' => ['integer', Rule::exists('artists', 'id')],
        ];
    }

    public function messages(): array
    {
        return [
            'genres.required' => 'Selecione pelo menos um gênero.',
            'genres.array' => 'Os gêneros devem ser um array.',
            'genres.min' => 'Selecione pelo menos um gênero.',
            'genres.*.exists' => 'Um dos gêneros selecionados não é válido.',
            'authors.required' => 'Selecione pelo menos um autor.',
            'authors.array' => 'Os autores devem ser um array.',
            'authors.min' => 'Selecione pelo menos um autor.',
            'authors.*.exists' => 'Um dos autores selecionados não é válido.',
            'artists.required' => 'Selecione pelo menos um artista.',
            'artists.array' => 'Os artistas devem ser um array.',
            'artists.min' => 'Selecione pelo menos um artista.',
            'artists.*.exists' => 'Um dos artistas selecionados não é válido.',
            'status.enum' => 'O status deve ser um dos seguintes: Em andamento, Concluído, Cancelado, Hiato.',
        ];
    }
}
