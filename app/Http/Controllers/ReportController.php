<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Store;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
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
     * Display a listing of the reports.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $query = Report::query();
    
        // تطبيق الفلاتر
        if ($request->filled('search')) {
            $query->where('description', 'like', "%{$request->search}%");
        }
    
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
    
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        $reports = $query->paginate(10);
        return view('admin.reports', compact('reports'));
    }
    

    

    /**
     * Display the specified report.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $report = Report::with('reporter')->findOrFail($id);
        
        // Get reported entity
        $reportedEntity = null;
        if ($report->type === 'store') {
            $reportedEntity = Store::find($report->entity_id);
        } elseif ($report->type === 'user') {
            $reportedEntity = User::find($report->entity_id);
        }

        return response()->json([
            'report' => $report,
            'reportedEntity' => $reportedEntity
        ]);
    }

    /**
     * Update the specified report status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,inProgress,closed',
        ]);

        $report = Report::findOrFail($id);
        $oldStatus = $report->status;
        $newStatus = $request->input('status');
        
        if ($oldStatus !== $newStatus) {
            $report->status = $newStatus;
            
            // Add to history
            $report->addToHistory("تم تغيير حالة البلاغ من \"{$this->getStatusName($oldStatus)}\" إلى \"{$this->getStatusName($newStatus)}\"");
        }

        return response()->json(['success' => true, 'message' => 'تم تحديث حالة البلاغ بنجاح']);
    }

    /**
     * Take action on a report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function takeAction(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:suspend,warning,delete',
        ]);
    
        $report = Report::findOrFail($id);
        $action = $request->input('action');
        $actionText = '';
    
        // إيقاف المتجر إذا كان نوع البلاغ store
        if ($report->type === 'store' && $action === 'suspend') {
            $store = \App\Models\Business::find($report->entity_id);
            if ($store) {
                $store->status = 'suspended';
                $store->save();
                $actionText = "تم إيقاف المتجر \"{$store->business_name}\"";
    
                Notification::create([
                    'title' => 'تم إيقاف متجرك',
                    'message' => 'تم إيقاف متجرك بسبب مخالفة شروط الاستخدام',
                    'type' => 'admin',
                    'target' => 'specific',
                    'user_id' => $store->store_owner_id,
                ]);
    
                // تحديث حالة البلاغ بعد إيقاف المتجر
                $report->status = 'approved';
                $report->save();
            }
        }
    
        // حذف التعليق إذا كان نوع البلاغ review
        elseif ($report->type === 'review' && $action === 'delete') {
            $review = \App\Models\Review::find($report->entity_id);
            if ($review) {
                $userId = $review->user_id;
                $review->delete();
                $actionText = "تم حذف التعليق من قبل الإدارة";
    
                // إرسال إشعار لصاحب التعليق
                Notification::create([
                    'title' => 'حذف تعليق',
                    'message' => 'تم حذف تعليقك بسبب انتهاك سياسة الاستخدام',
                    'type' => 'admin',
                    'target' => 'specific',
                    'user_id' => $userId,
                ]);
    
                // تحديث حالة البلاغ بعد حذف التعليق
                $report->status = 'approved';
                $report->save();
            }
        }
    
        // إضافة الحالة إلى تاريخ البلاغ
        if ($actionText) {
            $report->addToHistory($actionText);
            $report->status = 'approved';  // ضمان تحديث الحالة في جميع الحالات
            $report->save();  // حفظ البلاغ بعد التعديل
        }
    
        return redirect()->back()->with('success', 'تم اتخاذ الإجراء بنجاح');
    }
    

    
    

    /**
     * Get status name in Arabic.
     *
     * @param  string  $status
     * @return string
     */
    private function getStatusName($status)
    {
        $statuses = [
            'new' => 'جديد',
            'inProgress' => 'قيد المراجعة',
            'closed' => 'مغلق'
        ];
        return $statuses[$status] ?? $status;
    }


    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:store,review',
            'entity_id' => 'required|integer',
            'description' => 'nullable|string|max:1000',
        ]);
    
        // التحقق من نوع المستخدم وصلاحياته
        $userId = Auth::guard('web')->id() ?? Auth::guard('store_owner')->id();
    
        // تحقق من صلاحيات البلاغ
        if (Auth::guard('web')->check() && $request->type !== 'store') {
            return redirect()->back()->with('error', 'الزوار يمكنهم فقط الإبلاغ عن المتاجر.');
        }
    
        if (Auth::guard('store_owner')->check() && $request->type !== 'review') {
            return redirect()->back()->with('error', 'التجار يمكنهم فقط الإبلاغ عن المراجعات.');
        }
    
        try {
            Report::create([
                'user_id' => $userId,
                'entity_id' => $request->entity_id,
                'type' => $request->type,
                'description' => $request->description,
                'status' => 'new',
            ]);
    
            return redirect()->back()->with('success', 'تم إرسال البلاغ بنجاح');
        } catch (\Exception $e) {
            \Log::error("Error saving report: " . $e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء إرسال البلاغ');
        }
    }
    


}