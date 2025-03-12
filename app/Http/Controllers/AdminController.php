<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        return view('admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6',
            'admin_name' => 'required',
            'phone' => 'nullable',
        ]);

        Admin::create($request->all());
        return redirect()->route('admins.index')->with('success', 'تمت إضافة المشرف بنجاح');
    }

    public function edit(Admin $admin)
    {
        return view('admins.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'admin_name' => 'required',
            'phone' => 'nullable',
        ]);

        $admin->update($request->all());
        return redirect()->route('admins.index')->with('success', 'تم تعديل بيانات المشرف بنجاح');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admins.index')->with('success', 'تم حذف المشرف بنجاح');
    }
}
