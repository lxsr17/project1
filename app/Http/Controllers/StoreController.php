<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;

class StoreController extends Controller
{
    // عرض المتاجر
    public function index(Request $request)
    {
        $query = Business::query()->with('reviews');

        // ✅ تصفية نوع الشهادة
        if ($request->filled('certificate')) {
            if ($request->certificate === 'gold') {
                $query->whereNotNull('commercial_registration_document');
            } elseif ($request->certificate === 'silver') {
                $query->whereNotNull('freelancer_document');
            }
        }

        // ✅ تصنيف العمل
        if ($request->filled('category')) {
            $query->where('business_type', 'LIKE', "%{$request->category}%");
        }

        // ✅ تصفية المدينة
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // ✅ فلترة حسب الموافقة
        $query->where('status', 'approved');

        // ✅ ترتيب حسب الفرز
        if ($request->filled('sort')) {
            if ($request->sort == 'rating') {
                $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');
            } elseif ($request->sort == 'reviews') {
                $query->withCount('reviews')->orderBy('reviews_count', 'desc');
            } elseif ($request->sort == 'latest') {
                $query->latest();
            }
        } else {
            $query->orderBy('id', 'asc');
        }

        $stores = $query->paginate(12);

        // ✅ التحقق من نوع المستخدم
        if (Auth::guard('store_owner')->check() || Auth::guard('web')->check()) {
            return view('main.stores_login_Marchent', compact('stores'));
        } else {
            return view('main.stores', compact('stores'));
        }
    }

    // عرض تفاصيل المتجر
    public function show($id)
    {
        $store = Business::with('reviews.user')->findOrFail($id);

        return view('main.store-details', compact('store'));
    }
    // ✅ عرض المتاجر للإدمن
public function adminIndex()
{
    $stores = \App\Models\Business::latest()->paginate(10);

    return view('admin.stores', compact('stores'));

}

}
