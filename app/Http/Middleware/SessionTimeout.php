<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    protected $timeout = 600; // 10 دقائق

    public function handle($request, Closure $next)
    {
        // نستخدم guard الزوار فقط
        if (Auth::guard('web')->check()) {
            $lastActivity = session('last_activity');

            if ($lastActivity && now()->diffInSeconds($lastActivity) > $this->timeout) {
                Auth::guard('web')->logout();
                session()->flush();

                return redirect()->route('login')->withErrors([
                    'message' => 'تم تسجيل الخروج تلقائيًا بسبب عدم النشاط.',
                ]);
            }

            session(['last_activity' => now()]);
        }

        return $next($request);
    }
}
