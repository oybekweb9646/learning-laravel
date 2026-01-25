<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsViewWebResource extends JsonResource
{
    public function toArray($request): array
    {
        $locale = $request->get('lang', 'uz');

        return [
            'id' => $this->id,
            'title' => $this->getTitle($locale),
            'content' => $this->getContent($locale),

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
