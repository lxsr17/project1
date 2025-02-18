<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;

class BusinessController extends Controller
{
    // عرض جميع الأنشطة
    public function index()
    {
        $businesses = Business::all();
        return view('businesses.index', compact('businesses'));
    }

    // عرض نموذج إنشاء جديد
    public function create()
    {
        return view('businesses.create');
    }

    // حفظ نشاط جديد
    public function store(Request $request)
    {
        Business::create($request->validate([
            'name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'email' => 'required|email|unique:businesses',
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'location' => 'nullable|string',
        ]));

        return redirect()->route('businesses.index')->with('success', 'تمت إضافة النشاط بنجاح!');
    }

    // عرض تفاصيل نشاط معين
    public function show($id)
    {
        $business = Business::findOrFail($id);
        return view('businesses.show', compact('business'));
    }

    // تعديل نشاط
    public function edit($id)
    {
        $business = Business::findOrFail($id);
        return view('businesses.edit', compact('business'));
    }

    // تحديث البيانات
    public function update(Request $request, $id)
    {
        $business = Business::findOrFail($id);
        $business->update($request->validate([
            'name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'email' => 'required|email|unique:businesses,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'location' => 'nullable|string',
        ]));

        return redirect()->route('businesses.index')->with('success', 'تم تحديث النشاط بنجاح!');
    }

    // حذف نشاط
    public function destroy($id)
    {
        Business::destroy($id);
        return redirect()->route('businesses.index')->with('success', 'تم حذف النشاط بنجاح!');
    }
}
