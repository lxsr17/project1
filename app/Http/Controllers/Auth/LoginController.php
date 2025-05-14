<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // التحقق من صحة البيانات
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // إذا التحقق فشل، نرجع JSON فيه errors
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        // محاولة تسجيل دخول كتاجر (store_owner)
        if (Auth::guard('store_owner')->attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json([
                'redirect' => route('merchant-dashboard'),
            ]);
        }

        // محاولة تسجيل دخول كزائر (web)
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json([
                'redirect' => route('visitor-dashboard'),
            ]);
        }

        // إذا كانت البيانات صحيحة الصيغة ولكن خاطئة المحتوى
        return response()->json([
            'errors' => [
                'email' => [''],
                'password' => ['البريد الإلكتروني أو كلمة المرور غير صحيحة.'],
            ]
        ], 422);
    }

    public function logout(Request $request)
    {
        if (Auth::guard('store_owner')->check()) {
            Auth::guard('store_owner')->logout();
        } elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index');
    }
}
