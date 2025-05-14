<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use App\Models\Report;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\StoreOwner;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function dashboard()
{
    // ✅ عدد جميع المستخدمين (تجار + زوار)
    $usersCount = User::count();

    // ✅ عدد التجار من جدول store_owners
    $merchantCount = StoreOwner::count();

    // ✅ عدد الزوار = عدد المستخدمين - عدد التجار
    $visitorCount = $usersCount - $merchantCount;

    // ✅ عدد جميع المتاجر
    $storesCount = Business::count();

    // ✅ عدد المتاجر غير الموافق عليها
    $pendingStores = Business::where('status', 'pending')->count();

    // ✅ عدد المتاجر الموقوفة
    $suspendedStores = Business::where('status', 'suspended')->count();

    // ✅ عدد البلاغات
    $reportsCount = Report::count();
    $pendingReports = Report::where('status', 'new')->count();

    // ✅ جلب المتاجر التي في حالة "انتظار الموافقة" أو "مسودة"
    $pendingApprovals = Business::with('storeOwner')
        ->whereIn('status', ['pending', 'draft'])
        ->latest()
        ->get();

    return view('admin.admin-dashboard', compact(
        'storesCount', 'pendingStores', 'suspendedStores',
        'usersCount', 'merchantCount', 'visitorCount',
        'reportsCount', 'pendingReports', 'pendingApprovals'
    ));
}

    
    

    public function showLicense($id)
    {
        $store = Store::with('owner')->findOrFail($id);
        return response()->json($store);
    }

    public function approveLicense($id)
    {
        $store = Store::with('owner')->findOrFail($id);
        $store->status = 'active';
        $store->save();

        Notification::create([
            'title' => 'تمت الموافقة على متجرك',
            'message' => "تمت الموافقة على المتجر: {$business->business_name}",
            'receiver_id' => $owner->id,
            'receiver_type' => 'StoreOwner',
            'type' => 'admin',
            'link' => route('store-details', $business->id),
            'date' => now(),
            'is_read' => 0,
        ]);
        

        return response()->json(['success' => true, 'message' => 'تم الموافقة على المتجر بنجاح']);
    }

    public function rejectLicense($id)
    {
        $store = Store::with('owner')->findOrFail($id);
        $store->status = 'rejected';
        $store->save();

        Notification::create([
            'title' => 'تم رفض متجرك',
            'message' => "تم رفض المتجر: {$business->business_name}",
            'receiver_id' => $owner->id,
            'receiver_type' => 'StoreOwner',
            'type' => 'admin',
            'link' => route('store-details', $business->id),
            'date' => now(),
            'is_read' => 0,
        ]);

        return response()->json(['success' => true, 'message' => 'تم رفض المتجر']);
    }

    public function viewStore($id)
    {
        $store = \App\Models\Business::with('storeOwner')->findOrFail($id);
        return response()->json($store);
    }

     

    public function showStoreDetails($id)
    {
        $store = \App\Models\Business::with('storeOwner')->findOrFail($id);
        return view('admin.admin-storeDetails', compact('store'));
    }

    public function approveStore($id)
    {
        $store = Business::findOrFail($id);
        $store->status = 'approved'; // أو confirmed حسب ما تستخدم
        $store->save();

        return redirect()->route('admin.dashboard')->with('success', 'تم تأكيد المتجر بنجاح.');
    }


    public function deleteStore($id)
    {
        $store = Business::findOrFail($id);
        $store->delete();

        return redirect()->route('admin.dashboard')->with('success', 'تم حذف المتجر بنجاح.');
    }

    public function manageUsers(Request $request)
{
    $visitors = User::query();
    $merchants = StoreOwner::query();

    // البحث
    if ($request->filled('q')) {
        $visitors->where(function ($q) use ($request) {
            $q->where('username', 'like', "%{$request->q}%")
              ->orWhere('email', 'like', "%{$request->q}%");
        });

        $merchants->where(function ($q) use ($request) {
            $q->where('username', 'like', "%{$request->q}%")
              ->orWhere('email', 'like', "%{$request->q}%");
        });
    }

    // تصفية الحالة
    if ($request->filled('status')) {
        $visitors->where('status', $request->status);
        $merchants->where('status', $request->status);
    }

    // تصفية النوع
    if ($request->filled('type')) {
        if ($request->type === 'visitor') {
            $merchants = collect(); // فارغ
        } elseif ($request->type === 'merchant') {
            $visitors = collect(); // فارغ
        }
    }

    return view('admin.admin-users', [
        'visitors' => $visitors instanceof \Illuminate\Database\Eloquent\Builder ? $visitors->latest()->get() : $visitors,
        'merchants' => $merchants instanceof \Illuminate\Database\Eloquent\Builder ? $merchants->latest()->get() : $merchants,
    ]);
}


public function suspendUser(Request $request, $id)
{
    try {
        $type = $request->input('type');

        // تحديد نوع المستخدم: تاجر أو زائر
        if ($type === 'merchant') {
            $user = StoreOwner::find($id);
        } else {
            $user = User::find($id);
        }

        if ($user) {
            // تحديث حالة المستخدم إلى "موقوف"
            $user->status = 'suspended';
            $user->save();

            return redirect()->back()->with('success', 'تم إيقاف الحساب بنجاح');
        }

        return redirect()->back()->with('error', 'لم يتم العثور على المستخدم');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'حدث خطأ أثناء إيقاف الحساب');
    }
}




public function resumeUser(Request $request, $id)
{
    try {
        $type = $request->input('type');

        // تحديد نوع المستخدم: تاجر أو زائر
        if ($type === 'merchant') {
            $user = StoreOwner::find($id);
        } else {
            $user = User::find($id);
        }

        if ($user) {
            // تحديث حالة المستخدم إلى "نشط"
            $user->status = 'active';
            $user->save();

            return redirect()->back()->with('success', 'تم استئناف الحساب بنجاح');
        }

        return redirect()->back()->with('error', 'لم يتم العثور على المستخدم');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'حدث خطأ أثناء استئناف الحساب');
    }
}



   public function deleteUser($id)
{
    try {
        // البحث في كلا الجداول
        $user = StoreOwner::find($id) ?: User::find($id);

        if ($user) {
            $user->delete();
            return redirect()->back()->with('success', 'تم حذف الحساب بنجاح');
        }

        return redirect()->back()->with('error', 'لم يتم العثور على المستخدم');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'حدث خطأ أثناء حذف الحساب');
    }
}



}
