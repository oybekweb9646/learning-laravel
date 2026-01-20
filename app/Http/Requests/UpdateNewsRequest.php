<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file_id' => ['nullable', 'integer'],

            'title_uz' => ['sometimes', 'string', 'max:255'],
            'title_ru' => ['sometimes', 'string', 'max:255'],
            'title_en' => ['sometimes', 'string', 'max:255'],

            'content_uz' => ['sometimes', 'string'],
            'content_ru' => ['sometimes', 'string'],
            'content_en' => ['sometimes', 'string'],
        ];
    }
}
