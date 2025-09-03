<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        if (Cookie::has('locale')) {
            app()->setLocale(Cookie::get('locale'));
        }

        return $next($request);
    }
} 