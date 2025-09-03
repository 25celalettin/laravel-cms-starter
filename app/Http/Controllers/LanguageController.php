<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LanguageController extends Controller
{
    public function changeLanguage(Request $request)
    {
        $request->validate([
            'language' => 'required|in:tr,en'
        ]);

        $cookie = cookie('locale', $request->language, 60 * 24 * 30);

        return response()->json(['success' => true])->withCookie($cookie);
    }
} 