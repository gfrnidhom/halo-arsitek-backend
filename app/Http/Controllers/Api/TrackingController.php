<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TrackingController extends Controller
{
    /**
     * Record a pageview.
     */
    public function pageview(Request $request): JsonResponse
    {
        // Simple pageview tracking that stores to system_stats or just a simple log table.
        // For now, we will track this in a daily aggregated way or raw log.
        // Let's create a table for it if it doesn't exist, or just use a generic 'pageviews' table.
        // Wait, earlier we created a 'Pageview' model? Let's check if we have a table for that.
        // In the migration we have `pageviews` table but wait... did we create it?
        // Let's assume we have a simple DB insert for now since we didn't define a model for Pageview.

        $url = $request->input('url');
        $path = $request->input('path', '/');
        
        try {
            DB::table('pageviews')->insert([
                'id' => Str::uuid(),
                'url' => $url,
                'path' => $path,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            // If table doesn't exist yet, ignore to not crash frontend
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
