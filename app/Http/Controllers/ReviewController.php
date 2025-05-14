<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'store_id' => 'required|exists:businesses,id',
        'comment' => 'nullable|string',
        'rating' => 'nullable|integer|min:1|max:5',
    ]);

    if (!Auth::guard('web')->check()) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // ✅ التحقق من أن المتجر حالته approved فقط
    $store = \App\Models\Business::find($request->store_id);
    if (!$store || $store->status !== 'approved') {
        return redirect()->back()->with('error', 'لا يمكن التقييم إلا للمتاجر المعتمدة فقط.');
    }

    if ($request->filled('comment') && !$request->filled('rating')) {
        return back()->withErrors(['rating' => 'يرجى تحديد عدد النجوم إذا كتبت تعليقًا.'])->withInput();
    }
    
    $rating = $request->filled('rating') ? $request->rating : 5;
    
    \App\Models\Review::create([
        'store_id' => $request->store_id,
        'user_id' => Auth::guard('web')->id(),
        'comment' => trim($request->comment) !== '' ? $request->comment : ' ',
        'rating' => $rating,
        'review_date' => now(),
    ]);
    $storeOwner = $store->storeOwner;

    // ✅ إرسال إشعار للتاجر
    \App\Models\Notification::create([
        'title' => 'تعليق جديد',
        'message' => 'قام ' . Auth::guard('web')->user()->username . ' بكتابة تعليق على متجرك "'  . $store->business_name . '"',
        'type' => 'alert',
        'target' => 'merchant',
        'target_id' => $store->id,
        'receiver_id' => $storeOwner->id,                 // ✅ مهم
        'receiver_type' => 'StoreOwner',                  // ✅ مهم جداً لمطابقة الدالة
        'is_read' => false,
    ]);
    


    return redirect()->back()->with('success', 'تم إرسال التقييم بنجاح');
}


public function recentReviews()
{
    if (!Auth::guard('web')->check()) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $userId = Auth::guard('web')->id();

    $reviews = \App\Models\Review::with(['store', 'user'])
        ->where('user_id', $userId)
        ->whereHas('store', function ($query) {
            $query->where('status', 'approved');
        })
        ->latest('review_date')
        ->take(10)
        ->get()
        ->map(function ($review) {
            return [
                'review_id' => $review->id, // ✅ أضف هذا
                'store_id' => $review->store_id,
                'store_name' => $review->store->business_name ?? 'غير معروف',
                'rating' => $review->rating,
                'comment' => $review->comment,
                'review_date' => $review->review_date,
                'reviewer' => $review->user->name ?? 'مستخدم',
            ];
            
        });

    return response()->json($reviews);
}

public function destroy($id)
{
    $review = \App\Models\Review::findOrFail($id);

    if (auth('web')->id() !== $review->user_id) {
        return response()->json(['message' => 'غير مصرح'], 403);
    }

    $review->delete();

    return response()->json(['message' => 'تم الحذف بنجاح']);
}


}