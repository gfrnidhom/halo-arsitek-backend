<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Get paginated list of published news.
     */
    public function index(Request $request): JsonResponse
    {
        $query = News::with('category:id,name,slug')
            ->published()
            ->when($request->category, function ($q, $categorySlug) {
                $q->whereHas('category', fn($c) => $c->where('slug', $categorySlug));
            })
            ->when($request->search, function ($q, $search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->orderByDesc('created_at');

        $limit = $request->integer('limit', 10);
        $newsList = $query->paginate($limit);

        return response()->json([
            'success' => true,
            'data' => $newsList->items(),
            'meta' => [
                'current_page' => $newsList->currentPage(),
                'last_page' => $newsList->lastPage(),
                'per_page' => $newsList->perPage(),
                'total' => $newsList->total(),
            ],
        ]);
    }

    /**
     * Get single article by slug.
     */
    public function show(string $slug): JsonResponse
    {
        $news = News::with('category:id,name,slug')
            ->published()
            ->where('slug', $slug)
            ->first();

        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'Article not found.',
            ], 404);
        }

        $recent = News::with('category:id,name,slug')
            ->published()
            ->where('id', '!=', $news->id)
            ->orderByDesc('created_at')
            ->limit(4)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'article' => $news,
                'recent' => $recent,
            ],
        ]);
    }
}
