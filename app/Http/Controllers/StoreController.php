<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    // عرض جميع المتاجر
    public function index()
    {
        $stores = Store::all();
        return view('stores.index', compact('stores'));
    }

    // عرض نموذج إنشاء متجر جديد
    public function create()
    {
        return view('stores.create');
    }

    // حفظ متجر جديد
    public function store(Request $request)
    {
        Store::create($request->validate([
            'owner_id' => 'required|exists:store_owners,id',
            'store_name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'verification_status' => 'in:Pending,Verified,Rejected',
            'email' => 'required|email|unique:stores',
            'phone' => 'nullable|string|max:20',
        ]));

        return redirect()->route('stores.index')->with('success', 'تمت إضافة المتجر بنجاح!');
    }

    // عرض تفاصيل متجر معين
    public function show($id)
    {
        $store = Store::findOrFail($id);
        return view('stores.show', compact('store'));
    }

    // تعديل بيانات متجر
    public function edit($id)
    {
        $store = Store::findOrFail($id);
        return view('stores.edit', compact('store'));
    }

    // تحديث بيانات متجر
    public function update(Request $request, $id)
    {
        $store = Store::findOrFail($id);
        $store->update($request->validate([
            'owner_id' => 'required|exists:store_owners,id',
            'store_name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'verification_status' => 'in:Pending,Verified,Rejected',
            'email' => 'required|email|unique:stores,email,' . $id,
            'phone' => 'nullable|string|max:20',
        ]));

        return redirect()->route('stores.index')->with('success', 'تم تحديث المتجر بنجاح!');
    }

    // حذف متجر
    public function destroy($id)
    {
        Store::destroy($id);
        return redirect()->route('stores.index')->with('success', 'تم حذف المتجر بنجاح!');
    }
}
