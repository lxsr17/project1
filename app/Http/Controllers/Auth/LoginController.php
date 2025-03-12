<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // 1️⃣ التحقق من صحة البيانات المدخلة
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 2️⃣ البحث عن المستخدم في قاعدة البيانات بناءً على البريد الإلكتروني
        $user = User::where('email', $credentials['email'])->first();

        // 3️⃣ إذا لم يتم العثور على المستخدم، إرسال رسالة خطأ
        if (!$user) {
            return back()->withErrors(['email' => '❌ هذا البريد الإلكتروني غير مسجل لدينا.']);
        }

        // 4️⃣ التحقق من صحة كلمة المرور باستخدام Hash::check
        if (!Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['password' => '❌ كلمة المرور غير صحيحة.']);
        }

        // 5️⃣ إذا كان كل شيء صحيحًا، تسجيل الدخول وإعادة توجيه المستخدم
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/dashboard'); // أو أي صفحة تريد توجيه المستخدم إليها
    }
}