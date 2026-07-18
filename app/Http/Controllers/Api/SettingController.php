<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    /**
     * Get global website settings.
     */
    public function index(): JsonResponse
    {
        $settings = SiteSetting::all()->mapWithKeys(function ($item) {
            $val = match ($item->type) {
                'NUMBER' => (float) $item->value,
                'BOOLEAN' => filter_var($item->value, FILTER_VALIDATE_BOOLEAN),
                'JSON' => json_decode($item->value, true),
                default => $item->value,
            };
            return [$item->key => $val];
        });

        return response()->json([
            'success' => true,
            'data' => $settings,
        ]);
    }
}
