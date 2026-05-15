<?php

namespace App\Helpers;

use App\Models\Setting;

class SettingHelper
{
    protected static $settings = null;

    public static function getSetting($key)
    {
        if (self::$settings === null) {
            self::$settings = Setting::pluck('value', 'title')->toArray();
        }

        return self::$settings[$key] ?? null;
    }
}
