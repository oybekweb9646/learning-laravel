<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'uuid',
        'original_name',
        'path',
        'disk',
        'mime_type',
        'size',
    ];
}
