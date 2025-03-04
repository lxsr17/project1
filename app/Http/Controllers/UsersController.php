<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    // ✅ عرض جميع المستخدمين
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    // ✅ عرض مستخدم واحد بالتفصيل
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user);
    }

    // ✅ إنشاء مستخدم جديد
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'username' => 'required|unique:users|max:50',
            'email' => 'required|email|unique:users|max:100',
            'password' => 'required|min:6',
            'birthdate' => 'required|date',
            'phone' => 'nullable|max:20',
            'sex' => 'required|in:Male,Female',
            'address' => 'required',
            'street' => 'required|max:100',
            'neighborhood' => 'required|max:100',
            'city' => 'required|max:50',
            'state' => 'required|max:50',
        ]);

        // ✅ حفظ البيانات في قاعدة البيانات
        $user = User::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'birthdate' => $validatedData['birthdate'],
            'phone' => $validatedData['phone'],
            'sex' => $validatedData['sex'],
            'address' => $validatedData['address'],
            'street' => $validatedData['street'],
            'neighborhood' => $validatedData['neighborhood'],
            'city' => $validatedData['city'],
            'state' => $validatedData['state'],
        ]);

        return response()->json(['message' => 'User registered successfully!', 'user' => $user], 201);
    }

    // ✅ تحديث بيانات المستخدم
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validatedData = $request->validate([
            'first_name' => 'sometimes|string|max:50',
            'last_name' => 'sometimes|string|max:50',
            'username' => 'sometimes|string|max:50|unique:users,username,' . $id,
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'sometimes|min:6',
            'birthdate' => 'sometimes|date',
            'phone' => 'nullable|string|max:20',
            'sex' => 'sometimes|in:Male,Female',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:50',
            'state' => 'nullable|string|max:50',
            'street' => 'nullable|string|max:100',
            'neighborhood' => 'nullable|string|max:100',
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']); // تشفير كلمة المرور الجديدة
        }

        $user->update($validatedData);

        return response()->json(['message' => 'User updated successfully!', 'user' => $user]);
    }

    // ✅ حذف مستخدم
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully!']);
    }
}

