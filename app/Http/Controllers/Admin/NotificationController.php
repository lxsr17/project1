<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Notification;
use App\Models\User;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the notifications.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $query = Notification::query();

        // Search Filter
        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%")
                  ->orWhere('message', 'like', "%{$request->search}%");
        }

        // Target Filter
        if ($request->filled('target')) {
            $query->where('target', $request->target);
        }

        // Type Filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Date Filter
        if ($request->filled('date')) {
            if ($request->date == 'today') {
                $query->whereDate('created_at', today());
            } elseif ($request->date == 'week') {
                $query->whereBetween('created_at', [now()->subWeek(), now()]);
            } elseif ($request->date == 'month') {
                $query->whereBetween('created_at', [now()->subMonth(), now()]);
            }
        }

        $notifications = $query->latest()->paginate(10);
        $users = User::select('id', 'first_name', 'last_name', 'email')->get();

        return view('admin.admin-notifications', compact('notifications', 'users'));
    }

    /**
     * Store a newly created notification.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'target' => 'required|string',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'userId' => 'nullable|integer',
        ]);
    
        try {
            Notification::create([
                'type' => $request->type,
                'target' => $request->target,
                'title' => $request->title,
                'message' => $request->message,
                'receiver_id' => $request->userId,
                'receiver_type' => $request->target === 'merchant' ? 'StoreOwner' : 'User',
                'sender_admin_id' => auth()->id(),
                'date' => now(),
                'is_read' => 0,
            ]);
    
            return redirect()->back()->with('success', 'تم إرسال الإشعار بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء إرسال الإشعار');
        }
    }
    


    
    public function userNotifications()
    {
        $notifications = Notification::latest()->get(); // جلب جميع الإشعارات مرتبة تنازلياً
        return view('main.notifications', compact('notifications'));
    }
    
    
    
    /**
     * Fetch notifications for the logged-in user.
     */
    public function fetch(Request $request)
    {
        if (auth('store_owner')->check()) {
            $notifications = Notification::where('receiver_id', auth('store_owner')->id())
                                         ->latest()->take(10)->get();
        } elseif (auth('web')->check()) {
            $notifications = Notification::where('receiver_id', auth('web')->id())
                                         ->latest()->take(10)->get();
        } else {
            return response()->json([], 401);
        }

        return response()->json($notifications);
    }

    
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->markAsRead();

        return redirect()->back()->with('success', 'تم تعليم الإشعار كمقروء');
    }

    /**
     * Delete a notification.
     */
    public function destroy($id)
    {
        try {
            // البحث عن الإشعار بناءً على المعرف (ID)
            $notification = Notification::findOrFail($id);
            
            // حذف الإشعار
            $notification->delete();
    
            // إرسال استجابة JSON بنجاح العملية
            return response()->json([
                'success' => true,
                'message' => 'تم حذف الإشعار بنجاح'
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            // في حالة حدوث خطأ أثناء الحذف
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حذف الإشعار: ' . $e->getMessage()
            ], 500, [], JSON_UNESCAPED_UNICODE);
        }
    }
    


    
    
}
