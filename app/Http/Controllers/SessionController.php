<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    // عرض الجلسات الحالية للمستخدم
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([], 200);
        }

        $sessions = DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderByDesc('last_activity')
            ->get()
            ->map(function ($session) {
                return [
                    'ip_address' => $session->ip_address,
                    'user_agent' => $session->user_agent,
                    'last_activity' => date('Y-m-d H:i:s', $session->last_activity),
                ];
            });

        return response()->json($sessions);
    }

    // تسجيل الخروج من جميع الجلسات (باستثناء الجلسة الحالية)
    public function destroyAll(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '!=', Session::getId())
            ->delete();

        return response()->json(['message' => 'تم تسجيل الخروج من جميع الجلسات بنجاح.']);
    }
}
