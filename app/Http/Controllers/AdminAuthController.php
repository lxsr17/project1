<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    /**
     * عرض صفحة تسجيل الدخول للإدمن
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * تنفيذ عملية تسجيل الدخول
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }
    
        return back()->withErrors(['email' => 'بيانات الدخول غير صحيحة']);
    }
    
    

    /**
     * تسجيل الخروج
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

public function adminRegister(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:255|unique:admins',
        'email' => 'required|string|email|max:255|unique:admins',
        'password' => 'required|string|min:8|confirmed',
        'admin_name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'sex' => 'required|in:Male,Female',
    ]);

    Admin::create([
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'admin_name' => $request->admin_name,
        'phone' => $request->phone,
        'sex' => $request->sex,
    ]);

    return redirect()->route('admin.login')->with('success', 'تم إنشاء حساب الإدمن بنجاح.');
}

public function showAdminRegisterForm()
{
    return view('admin.register'); 
}

}
