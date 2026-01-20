<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'max:102400', // 100 MB (KB da)
                'mimes:jpg,png,pdf,docx',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'Fayl yuborilishi majburiy.',
            'file.file'     => 'Yuborilgan obyekt fayl bo‘lishi kerak.',
            'file.max'      => 'Fayl hajmi 100 MB dan oshmasligi kerak.',
            'file.mimes'    => 'Ruxsat etilgan formatlar: jpg, png, pdf, docx.',
        ];
    }
}
