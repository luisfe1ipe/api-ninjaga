<?php

namespace App\Http\Requests;

use App\Enums\StatusProjectEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectIndexRequest extends FormRequest
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
            'genres' => ['array', 'nullable'],
            'genres.*' => ['integer', Rule::exists('genres', 'id')],
            'authors' => ['array', 'nullable'],
            'authors.*' => ['integer', Rule::exists('authors', 'id')],
            'artists' => ['array', 'nullable'],
            'artists.*' => ['integer', Rule::exists('artists', 'id')],
            'status' => [Rule::enum(StatusProjectEnum::class)],
            'published_at' => ['numeric']
        ];
    }
}
