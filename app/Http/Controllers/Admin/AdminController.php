<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use App\Models\Report;
use App\Models\Notification;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

   public function dashboard()
    {
        $storesCount = Store::count();
        $pendingStores = Store::where('status', 'pending')->count();

        $usersCount = User::count();
        $merchantCount = User::where('role', 'merchant')->count();
        $visitorCount = User::where('role', 'visitor')->count();

        $reportsCount = Report::count();
        $pendingReports = Report::where('status', 'new')->count();

        $pendingApprovals = Store::where('status', 'pending')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'storesCount', 'pendingStores',
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
            'title' => 'تم الموافقة على متجرك',
            'message' => "تم الموافقة على متجر {$store->business_name_ar}",
            'type' => 'admin',
            'target' => 'specific',
            'user_id' => $store->owner_id,
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
            'message' => "تم رفض متجر {$store->business_name_ar}",
            'type' => 'admin',
            'target' => 'specific',
            'user_id' => $store->owner_id,
        ]);

        return response()->json(['success' => true, 'message' => 'تم رفض المتجر']);
    }
}
