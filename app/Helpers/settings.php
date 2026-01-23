<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('shopEnabled')) {
    function shopEnabled(): bool
    {
        static $memo = null;
        if($memo !== null) return $memo;

        $memo = Cache::rememberForever('settings:shop_enabled', function () {
            $val = Setting::where('key', 'shop_enabled')->value('value');
            if ($val === null) return true; // default open
            return in_array((string) $val, ['1', 'true', 'on', 'yes'], true);
        });

        return (bool) $memo;
    }
}
