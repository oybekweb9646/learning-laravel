<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFileRequest;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function store(StoreFileRequest $request)
    {
        $file = $request->file('file');

        $uuid = Str::uuid()->toString();
        $path = $file->store('uploads/' . now()->format('Y/m'), 'public');

        $model = File::create([
            'uuid' => $uuid,
            'original_name' => $file->getClientOriginalName(),
            'path' => $path,
            'disk' => 'public',
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]);

        return response()->json([
            'uuid' => $model->uuid,
            'file_id' => $model->id,
            'name' => $model->original_name,
            'size' => $model->size,
            'mime_type' => $model->mime_type,
            'url' => Storage::disk('public')->url($path), // To'g'ridan-to'g'ri ochish uchun
            'download_url' => route('files.download', $model->uuid), // Yuklab olish uchun
        ], 201);
    }

    public function download(string $uuid)
    {
        $file = File::where('uuid', $uuid)->firstOrFail();

        if (!Storage::disk($file->disk)->exists($file->path)) {
            abort(404, 'File not found');
        }

        return Storage::disk($file->disk)->download(
            $file->path,
            $file->original_name,
            [
                'Content-Type' => $file->mime_type,
            ]
        );
    }

    // Qo'shimcha: Faylni browserda ko'rish uchun (download qilmasdan)
    public function show(string $uuid)
    {
        $file = File::where('uuid', $uuid)->firstOrFail();

        if (!Storage::disk($file->disk)->exists($file->path)) {
            abort(404, 'File not found');
        }

        return Storage::disk($file->disk)->response(
            $file->path,
            $file->original_name,
            [
                'Content-Type' => $file->mime_type,
                'Content-Disposition' => 'inline', // Browserda ochish
            ]
        );
    }
}
