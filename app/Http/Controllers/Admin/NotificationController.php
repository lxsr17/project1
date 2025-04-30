<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

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

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%")
                  ->orWhere('message', 'like', "%{$request->search}%");
        }

        if ($request->filled('target')) {
            $query->where('target', $request->target);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

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
            'type' => 'required|in:alert,announcement,warning',
            'target' => 'required|in:all,merchant,visitor,specific',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $data = $request->only('type', 'target', 'title', 'message', 'user_id');

        Notification::create($data);

        return redirect()->route('admin.notifications.index')->with('success', 'تم إنشاء الإشعار بنجاح');
    }

    /**
     * Display the specified notification.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notification = Notification::findOrFail($id);
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
            'type' => 'required|in:alert,announcement,warning',
            'target' => 'required|in:all,merchant,visitor,specific',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $notification = Notification::findOrFail($id);
        $notification->update($request->only('type', 'target', 'title', 'message', 'user_id'));

        return redirect()->route('admin.notifications.index')->with('success', 'تم تحديث الإشعار بنجاح');
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

        return response()->json(['message' => 'تم حذف الإشعار بنجاح']);
    }
}