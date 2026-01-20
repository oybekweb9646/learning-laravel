<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    protected $fillable = [
        'file_id',
        'title_uz',
        'title_ru',
        'title_en',
        'content_uz',
        'content_ru',
        'content_en',
    ];

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function getTitle(string $locale): string
    {
        return $this->{"title_$locale"};
    }

    public function getContent(string $locale): string
    {
        return $this->{"content_$locale"};
    }
}
