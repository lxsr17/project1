<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    try {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'username' => 'required|string|unique:users|max:50',
            'email' => 'required|string|email|unique:users|max:100',
            'password' => 'required|string|min:8|confirmed',
            'birthdate' => 'required|date',
            'phone' => 'required|string|max:20',
            'sex' => 'required|string|max:10',
            'street' => 'required|string|max:100',
            'neighborhood' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
        ]);

        // ✅ محاولة حفظ البيانات في قاعدة البيانات
        $user = User::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), 
            'birthdate' => $validatedData['birthdate'],
            'phone' => $validatedData['phone'],
            'sex' => $validatedData['sex'],
            'street' => $validatedData['street'],
            'neighborhood' => $validatedData['neighborhood'],
            'city' => $validatedData['city'],
            'state' => $validatedData['state'],
        ]);

       // return redirect()->route('home')->with('success', 'تم إنشاء الحساب بنجاح!');
    } catch (\Exception $e) {
        dd($e->getMessage()); // 🔥 عرض الخطأ الحقيقي
    }
}

} 