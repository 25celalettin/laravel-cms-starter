<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    /**
     * Get / set the specified setting value.
     *
     * @param string|array|null $key
     * @param mixed $default
     * @return mixed|Setting
     */
    function setting($key = null, $default = null)
    {
        if (is_null($key)) {
            return app(Setting::class);
        }

        if (is_array($key)) {
            return Setting::set($key[0], $key[1]);
        }

        return Setting::get($key, $default);
    }
} 