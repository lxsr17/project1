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
     * عرض صفحة التسجيل.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * تخزين بيانات التسجيل للزائر.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:50', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'birthdate' => ['required', 'date'],
            'phone' => ['required', 'regex:/^05[0-9]{8}$/'],
            'sex' => ['required', 'in:Male,Female'],
            'city' => ['required', 'string', 'max:50'],
            'street' => ['required', 'string', 'max:100'],
            'neighborhood' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:50'],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birthdate' => $request->birthdate,
            'phone' => $request->phone,
            'sex' => $request->sex,
            'city' => $request->city,
            'street' => $request->street,
            'neighborhood' => $request->neighborhood,
            'state' => $request->state,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('visitor-dashboard');
    }
}
