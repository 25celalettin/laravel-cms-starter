<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;

class SettingsController extends Controller
{
    /**
     * Config'deki ayarları veritabanı ile senkronize et
     */
    private function syncSettings()
    {
        $defaultSettings = config('settings.defaults');

        foreach ($defaultSettings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']], // Arama kriteri
                $setting // Eğer bulunamazsa eklenecek veri
            );
        }
    }

    public function index(Request $request)
    {
        // Önce config'deki tüm ayarların veritabanında olduğundan emin olalım
        $this->syncSettings();

        $groupName = $request->group ?? 'general';

        $groups = config('settings.groups');

        if (!in_array($groupName, array_keys($groups))) {
            return redirect()->route('admin.settings.index')->with('error', 'Geçersiz ayar grubu.');
        }

        $settings = Setting::where('group', $groupName)->get();
        
        return view('admin.settings.index', compact('settings', 'groups', 'groupName'));
    }

    public function update(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            
            if ($setting) {
                // Resim yükleme işlemi
                if ($setting->type == 'image' && $request->hasFile($key)) {
                    // Eski resmi sil
                    if ($setting->value) {
                        Storage::disk('public')->delete($setting->value);
                    }
                    // Yeni resmi yükle
                    $value = 'storage/' . $request->file($key)->store('settings', 'public');
                }
                
                $setting->value = $value;
                $setting->save();
            }
        }

        // Cache'i temizle
        Setting::clearCache();

        $groupName = $request->group ?? 'general';

        return redirect()->route('admin.settings.index', ['group' => $groupName])
            ->with('success', 'Ayarlar başarıyla güncellendi.');
    }
}
