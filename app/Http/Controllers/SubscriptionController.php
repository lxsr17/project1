<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        // التحقق من المستخدم الحالي
        $storeOwner = Auth::guard('store_owner')->user();

        if (!$storeOwner) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً.');
        }

        // تحديد بيانات الباقة بناءً على المدخل
        $plan = $request->plan; // 'premium' أو 'ultra'
        
        if ($plan === 'premium') {
            $planName = 'الباقة المميزة';
            $price = 20;
        } elseif ($plan === 'ultra') {
            $planName = 'الباقة الاحترافية';
            $price = 50;
        } else {
            return redirect()->back()->with('error', 'الباقة غير معروفة.');
        }

        // إنشاء الاشتراك في قاعدة البيانات
        Subscription::create([
            'store_owner_id' => $storeOwner->id,
            'plan_name' => $planName,
            'price' => $price,
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'status' => 'active',
        ]);

        // إعادة توجيه بعد النجاح
        return redirect()->route('subscriptions')->with('success', 'تم الاشتراك بنجاح.');
    }
}
