<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;

class ContentController extends Controller
{
    /**
     * Get published testimonials.
     */
    public function testimonials(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => Testimonial::published()->ordered()->get(),
        ]);
    }

    /**
     * Get published services.
     */
    public function services(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => Service::published()->ordered()->get(),
        ]);
    }

    /**
     * Get published team members.
     */
    public function team(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => TeamMember::published()->ordered()->get(),
        ]);
    }

    /**
     * Get project and news categories.
     */
    public function categories(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'projects' => ProjectCategory::orderBy('name')->get(),
                'news' => NewsCategory::orderBy('name')->get(),
            ],
        ]);
    }
}
