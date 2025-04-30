<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class StoreOwnerAuth
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('store_owner')->check()) {
            return redirect('/login'); // أو تقدر تخصص صفحة للتاجر
        }

        return $next($request);
    }
}
