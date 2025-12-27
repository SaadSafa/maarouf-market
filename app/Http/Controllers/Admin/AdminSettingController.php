<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function toggleShop(Request $request): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'value' => ['required', 'boolean'],
        ]);

        $isOpen = (bool) $data['value'];

        Setting::updateOrCreate(
            ['key' => 'shop_enabled'],
            ['value' => $isOpen ? '1' : '0']
        );

        // clear cached flag immediately
        cache()->forget('settings:shop_enabled');

        $message = $isOpen ? 'Store opened' : 'Store closed';

        if ($request->expectsJson()) {
            return response()->json([
                'open' => $isOpen,
                'message' => $message,
            ]);
        }

        return redirect()->back()->with('status', $message);
    }
}
