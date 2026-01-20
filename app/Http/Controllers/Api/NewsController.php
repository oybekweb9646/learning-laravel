<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $news = News::with('file')
            ->latest()
            ->paginate(10);

        return NewsResource::collection($news);
    }

    public function store(StoreNewsRequest $request)
    {
        return DB::transaction(function () use ($request) {

            $news = News::create($request->validated());

            return new NewsResource($news);
        });
    }

    public function show(News $news)
    {
        $news->load('file');
        return new NewsResource($news);
    }

    public function update(UpdateNewsRequest $request, News $news)
    {
        return DB::transaction(function () use ($request, $news) {
            $news->update($request->validated());
            return new NewsResource($news);
        });
    }

    public function destroy(News $news)
    {
        $news->delete();

        return response()->json([
            'message' => 'News deleted successfully'
        ]);
    }
}
