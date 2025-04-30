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
        'rating' => 'required|integer|min:1|max:5',
    ]);

    if (!Auth::guard('web')->check()) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    \App\Models\Review::create([
        'store_id' => $request->store_id,
        'user_id' => Auth::guard('web')->id(),
        'comment' => $request->comment,
        'rating' => $request->rating,
        'review_date' => now(),
    ]);

    return redirect()->back()->with('success', 'تم إرسال التقييم بنجاح');
}

}