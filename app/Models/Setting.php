<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'type', 'title', 'description', 'is_translatable'];

    /**
     * Ayarı getir
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        $setting = Cache::rememberForever('setting.' . $key, function () use ($key) {
            return self::where('key', $key)->first();
        });

        return $setting ? $setting->value : $default;
    }

    /**
     * Ayarı güncelle
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public static function set($key, $value)
    {
        $setting = self::where('key', $key)->first();

        if ($setting) {
            if ($setting->type == 'image') {
                $value = 'storage/' . $value;
            }
            $setting->value = $value;
            $setting->save();
            Cache::forget('setting.' . $key);
            return true;
        }

        return false;
    }

    /**
     * Grup bazlı ayarları getir
     *
     * @param string $group
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function group($group)
    {
        return Cache::rememberForever('settings.group.' . $group, function () use ($group) {
            return self::where('group', $group)->get();
        });
    }

    /**
     * Tüm ayarları getir
     *
     * @return array
     */
    public static function getAllSettings()
    {
        return Cache::rememberForever('settings.all', function () {
            return self::all()->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Cache'i temizle
     */
    public static function clearCache()
    {
        Cache::forget('settings.all');
        $keys = self::pluck('key')->toArray();
        foreach ($keys as $key) {
            Cache::forget('setting.' . $key);
        }
        $groups = self::distinct()->pluck('group')->toArray();
        foreach ($groups as $group) {
            Cache::forget('settings.group.' . $group);
        }
    }
}
