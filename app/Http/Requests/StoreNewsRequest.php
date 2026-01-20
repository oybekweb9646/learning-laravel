<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // FILE → files table
            'file_id' => ['required', 'integer'],

            'title_uz' => ['required', 'string', 'max:255'],
            'title_ru' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],

            'content_uz' => ['required', 'string'],
            'content_ru' => ['required', 'string'],
            'content_en' => ['required', 'string'],
        ];
    }
}

