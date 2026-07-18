<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Get paginated list of published projects.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Project::with('category:id,name,slug')
            ->published()
            ->when($request->category, function ($q, $categorySlug) {
                $q->whereHas('category', fn($c) => $c->where('slug', $categorySlug));
            })
            ->when($request->search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('title', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%");
                });
            })
            ->when($request->year, fn($q, $year) => $q->where('year', $year))
            ->ordered();

        $limit = $request->integer('limit', 12);
        $projects = $query->paginate($limit);

        return response()->json([
            'success' => true,
            'data' => $projects->items(),
            'meta' => [
                'current_page' => $projects->currentPage(),
                'last_page' => $projects->lastPage(),
                'per_page' => $projects->perPage(),
                'total' => $projects->total(),
            ],
        ]);
    }

    /**
     * Get headliner projects for homepage banner/carousel.
     */
    public function headliners(): JsonResponse
    {
        $projects = Project::with('category:id,name,slug')
            ->published()
            ->headliner()
            ->ordered()
            ->limit(6)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $projects,
        ]);
    }

    /**
     * Get single project by slug.
     */
    public function show(string $slug): JsonResponse
    {
        $project = Project::with('category:id,name,slug')
            ->published()
            ->where('slug', $slug)
            ->first();

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found.',
            ], 404);
        }

        // Related projects in the same category
        $related = Project::with('category:id,name,slug')
            ->published()
            ->where('category_id', $project->category_id)
            ->where('id', '!=', $project->id)
            ->ordered()
            ->limit(3)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'project' => $project,
                'related' => $related,
            ],
        ]);
    }
}
