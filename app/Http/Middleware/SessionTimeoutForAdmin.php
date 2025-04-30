<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SessionTimeoutForAdmin
{
    protected $timeout = 600; // 10 دقائق

    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->check()) {
            $lastActivity = session('last_activity');

            if ($lastActivity && now()->diffInSeconds($lastActivity) > $this->timeout) {
                Auth::guard('admin')->logout();
                session()->flush();

                return redirect()->route('admin.login')->withErrors([
                    'message' => 'تم تسجيل الخروج تلقائيًا بسبب عدم النشاط.',
                ]);
            }

            session(['last_activity' => now()]);
        }

        return $next($request);
    }
}
