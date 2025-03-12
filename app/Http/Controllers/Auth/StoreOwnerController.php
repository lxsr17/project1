<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\StoreOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StoreOwnerController extends Controller
{
    public function create()
    {
        return view('auth.merchant-register'); // عرض صفحة تسجيل التاجر
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'username' => 'required|string|unique:store_owners|max:50',
            'email' => 'required|string|email|unique:store_owners|max:100',
            'password' => 'required|string|min:8|confirmed',
            'birthdate' => 'required|date',
            'phone' => 'required|string|max:20',
            'sex' => 'required|string|max:10',
            'street' => 'required|string|max:100',
            'neighborhood' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
        ]);

        // إنشاء سجل جديد في store_owners
        $storeOwner = StoreOwner::create([
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

        Auth::login($storeOwner);

        return redirect()->route('merchant.dashboard')->with('success', 'تم إنشاء الحساب بنجاح!');
    }
}
