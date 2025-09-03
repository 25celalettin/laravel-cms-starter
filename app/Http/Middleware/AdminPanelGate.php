<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;

class AdminPanelGate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User $authUser */
        $authUser = Auth::user();

        if ($authUser->role !== UserRole::ADMIN && $authUser->role !== UserRole::SUPERADMIN) {
            return abort(403, 'Bu sayfaya erişim izniniz bulunmamaktadır.');
        }

        return $next($request);
    }
}
