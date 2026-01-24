<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsViewResource extends JsonResource
{
    public function toArray($request): array
    {
        $locale = $request->get('lang', 'uz');

        return [
            'id' => $this->id,
            'title_uz' => $this->title_uz,
            'title_ru' => $this->title_ru,
            'title_en' => $this->title_en,
            'content_uz' => $this->content_uz,
            'content_ru' => $this->content_ru,
            'content_en' => $this->content_en,

            'file' => $this->file ? [
                'uuid' => $this->file->uuid,
                'id' => $this->file->id,
                'file_path'=> $this->file->path,
                'download_url' => route('files.download', $this->file->uuid),
            ] : null,

            'created_at' => $this->created_at,
        ];
    }
}
