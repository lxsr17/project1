<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class Notification_Controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:store_owner,web');
    }

    /**
     * Display a listing of the notifications.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $query = Notification::query();

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($request->filled('target')) {
            $query->where('target', $request->input('target'));
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('date')) {
            $date = $request->input('date');
            $now = now();
            
            if ($date === 'today') {
                $query->whereDate('created_at', $now->toDateString());
            } elseif ($date === 'week') {
                $query->where('created_at', '>=', $now->subDays(7));
            } elseif ($date === 'month') {
                $query->where('created_at', '>=', $now->subDays(30));
            }
        }

        $notifications = $query->orderBy('created_at', 'desc')->paginate(10);
        $users = User::all();

        return view('admin.notifications', compact('notifications', 'users'));
    }

    /**
     * Store a newly created notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:alert,announcement,warning',
            'target' => 'required|in:all,merchant,visitor,specific',
            'user_id' => 'required_if:target,specific|nullable|exists:users,id',
        ]);

        $data = $request->only(['title', 'message', 'type', 'target']);
        
        if ($request->input('target') === 'specific') {
            $data['user_id'] = $request->input('user_id');
            
            // Create notification for specific user
            Notification::create($data);
        } else {
            // Get users based on target
            $query = User::query();
            
            if ($request->input('target') !== 'all') {
                $query->where('user_type', $request->input('target'));
            }
            
            $users = $query->get();
            
            // Create notification for each user
            foreach ($users as $user) {
                Notification::create([
                    'title' => $data['title'],
                    'message' => $data['message'],
                    'type' => $data['type'],
                    'target' => $data['target'],
                    'user_id' => $user->id,
                ]);
            }
        }

        return redirect()->route('admin.notifications.index')
            ->with('success', 'تم إرسال الإشعار بنجاح');
    }

    /**
     * Display the specified notification.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notification = Notification::with('user')->findOrFail($id);
        return response()->json($notification);
    }

    /**
     * Update the specified notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:alert,announcement,warning',
        ]);

        $notification = Notification::findOrFail($id);
        $notification->update($request->only(['title', 'message', 'type']));

        return redirect()->route('admin.notifications.index')
            ->with('success', 'تم تحديث الإشعار بنجاح');
    }

    /**
     * Remove the specified notification.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->route('admin.notifications.index')
            ->with('success', 'تم حذف الإشعار بنجاح');
    }
    public function userNotifications(Request $request)
    {
        $user = auth('store_owner')->user() ?? auth('web')->user();
    
        if (!$user) {
            return redirect()->route('login')->with('error', 'الرجاء تسجيل الدخول لعرض الإشعارات.');
        }
    
        $type = $request->input('type');
        $query = \App\Models\Notification::where('receiver_type', class_basename($user))
                                         ->where('receiver_id', $user->id);
    
        if ($type) {
            $query->where('type', $type);
        }
    
        $notifications = $query->orderBy('created_at', 'desc')->get();
    
        return view('main.notifications', compact('notifications'));
    }

    public function fetch(Request $request)
{
    if (auth('store_owner')->check()) {
        $notifications = Notification::where('store_owner_id', auth('store_owner')->id())
                                     ->latest()->take(10)->get();
    } elseif (auth('web')->check()) {
        $notifications = Notification::where('user_id', auth('web')->id())
                                     ->latest()->take(10)->get();
    } else {
        return response()->json([], 401);
    }

    return response()->json($notifications);
}

    
    
}