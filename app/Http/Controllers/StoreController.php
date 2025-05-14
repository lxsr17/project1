<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;
use App\Models\Notification;
class StoreController extends Controller
{
    // عرض المتاجر
    public function index(Request $request)
    {
        $query = Business::query()->with('reviews');

            // ✅ البحث باسم المتجر أو رقم تحقق
    if ($request->filled('q')) {
        $query->where(function ($q) use ($request) {
            $q->where('business_name', 'like', "%{$request->q}%")
              ->orWhere('store_owner_id', 'like', "%{$request->q}%");
        });
    }

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
public function suspend($id)
{
    $store = \App\Models\Business::findOrFail($id);
    $store->status = 'suspended'; // أو 'موقوف' حسب ما تستخدم
    $store->save();

    \App\Models\Notification::create([
        'title' => 'تم إيقاف متجرك مؤقتاً',
        'message' => "تم إيقاف المتجر: {$store->business_name} مؤقتاً من قبل الإدارة.",
        'receiver_id' => $store->store_owner_id,
        'receiver_type' => 'StoreOwner',
        'type' => 'announcement',
        'target' => 'merchant', // تأكد من استخدام 'merchant'
        'date' => now(),
        'is_read' => 0,
        'link' => route('store-details', $store->id)
    ]);
    

    return redirect()->back()->with('success', 'تم إيقاف المتجر بنجاح.');
}

public function resume($id)
{
    $store = \App\Models\Business::findOrFail($id);
    $store->status = 'approved'; // أو الحالة اللي تعتبرها "مفعّل"
    $store->save();

    \App\Models\Notification::create([
        'title' => 'تم استئناف متجرك',
        'message' => "تم تفعيل المتجر مرة أخرى: {$store->business_name}",
        'receiver_id' => $store->store_owner_id,
        'receiver_type' => 'StoreOwner',
        'type' => 'announcement',
        'target' => 'merchant', // تأكد من استخدام 'merchant'
        'date' => now(),
        'is_read' => 0,
        'link' => route('store-details', $store->id)
    ]);

    return redirect()->back()->with('success', 'تم استئناف المتجر بنجاح.');
}


public function notify(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    $store = Business::findOrFail($id);

    Notification::create([
        'title' => 'إشعار من الإدارة',
        'message' => $request->input('message'),
        'receiver_id' => $store->store_owner_id,
        'receiver_type' => 'StoreOwner',
        'type' => 'announcement',
        'target' => 'merchant', 
        'date' => now(),
        'is_read' => 0,
        'link' => route('store-details', $store->id),
    ]);

    return response()->json(['success' => true]);
}


public function approve($id)
{
    $store = Business::findOrFail($id);
    $store->status = 'approved';
    $store->save();

    Notification::create([
        'receiver_id' => $store->store_owner_id,
        'receiver_type' => 'StoreOwner',
        'title' => 'تمت الموافقة على متجرك',
        'message' => 'تمت الموافقة على المتجر: ' . $store->business_name,
        'type' => 'announcement',
        'target' => 'merchant', 
        'date' => now(),
        'is_read' => 0,
        'link' => route('store-details', $store->id),
    ]);

    return redirect()->route('admin.dashboard')->with('success', 'تمت الموافقة على المتجر بنجاح.');
}


public function reject($id)
{
    $store = Business::findOrFail($id);
    $store->status = 'rejected';
    $store->save();

    Notification::create([
        'receiver_id' => $store->store_owner_id,
        'receiver_type' => 'StoreOwner',
        'title' => 'تم رفض متجرك',
        'message' => 'تم رفض المتجر: ' . $store->business_name,
'type' => 'announcement',
        'target' => 'merchant', 
        'date' => now(),
        'is_read' => 0,
        'link' => route('store-details', $store->id),
    ]);

    return redirect()->route('admin.dashboard')->with('error', 'تم رفض المتجر.');
}


public function sendNotificationAjax(Request $request)
{
    $request->validate([
        'store_id' => 'required|exists:businesses,id',
        'title' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    $store = Business::findOrFail($request->store_id);

    Notification::create([
        'receiver_id' => $store->store_owner_id,
        'receiver_type' => 'StoreOwner',
        'title' => $request->title,
        'message' => $request->message,
'type' => 'announcement',
        'target' => 'merchant',
        'is_read' => 0,
        'link' => route('store-details', $store->id),
    ]);

    return response()->json(['message' => 'تم إرسال الإشعار بنجاح.']);
}

public function destroy($id)
{
    $store = Business::findOrFail($id);
    $storeOwnerId = $store->store_owner_id;
    $storeName = $store->business_name;

    // حذف المتجر
    $store->delete();

    // إرسال إشعار إلى التاجر
    Notification::create([
        'title' => 'تم حذف متجرك',
        'message' => "تم حذف المتجر: {$storeName} من قبل الإدارة.",
        'receiver_id' => $storeOwnerId,
        'receiver_type' => 'StoreOwner',
'type' => 'announcement',
        'target' => 'merchant', 

        'date' => now(),
        'is_read' => 0,
        'link' => route('index'), // يمكنك تغييره مثلاً لصفحة المتاجر
    ]);

    return redirect()->back()->with('success', 'تم حذف المتجر بنجاح وإشعار التاجر.');
}

public function adminStores(Request $request)
{
    $query = Business::query()->with(['storeOwner', 'reviews']);

    // ✅ البحث بالاسم أو البريد الإلكتروني
    if ($request->filled('q')) {
        $q = $request->q;
        $query->where(function ($subQuery) use ($q) {
            $subQuery->where('business_name', 'like', "%$q%")
                     ->orWhereHas('storeOwner', function ($ownerQuery) use ($q) {
                         $ownerQuery->where('email', 'like', "%$q%");
                     });
        });
    }

    // ✅ التصفية حسب التصنيف
    if ($request->filled('category')) {
        $query->where('business_type', 'like', "{$request->category}%");
    }

    // ✅ التصفية حسب الحالة
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }


    $stores = $query->latest()->get(); // أو paginate() حسب الحاجة

    

    return view('admin.admin-stores', compact('stores'));
}

    
}
