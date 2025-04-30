<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Store;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

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
        $query = Report::with('reporter');

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('reporter', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
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

        if ($report->type === 'store' && $action === 'suspend') {
            $store = Store::find($report->entity_id);
            if ($store) {
                $store->status = 'suspended';
                $store->save();
                $actionText = "تم إيقاف المتجر \"{$store->business_name_ar}\"";
                
                // Notify store owner
                Notification::create([
                    'title' => 'تم إيقاف متجرك',
                    'message' => 'تم إيقاف متجرك بسبب مخالفة شروط الاستخدام',
                    'type' => 'admin',
                    'target' => 'specific',
                    'user_id' => $store->owner_id,
                ]);
            }
        } elseif ($report->type === 'user' && $action === 'suspend') {
            $user = User::find($report->entity_id);
            if ($user) {
                $user->status = 'suspended';
                $user->save();
                $actionText = "تم إيقاف المستخدم \"{$user->full_name}\"";
                
                // Notify user
                Notification::create([
                    'title' => 'تم إيقاف حسابك',
                    'message' => 'تم إيقاف حسابك بسبب مخالفة شروط الاستخدام',
                    'type' => 'admin',
                    'target' => 'specific',
                    'user_id' => $user->id,
                ]);
            }
        } elseif ($action === 'warning') {
            $entityId = $report->entity_id;
            $entityType = $report->type;
            
            if ($entityType === 'store') {
                $store = Store::find($entityId);
                if ($store) {
                    $actionText = "تم إرسال تحذير إلى المتجر \"{$store->business_name_ar}\"";
                    
                    // Notify store owner
                    Notification::create([
                        'title' => 'تحذير من الإدارة',
                        'message' => 'تم الإبلاغ عن مخالفة في المحتوى الخاص بك. يرجى مراجعة المحتوى وتصحيحه.',
                        'type' => 'warning',
                        'target' => 'specific',
                        'user_id' => $store->owner_id,
                    ]);
                }
            } elseif ($entityType === 'user') {
                $user = User::find($entityId);
                if ($user) {
                    $actionText = "تم إرسال تحذير إلى المستخدم \"{$user->full_name}\"";
                    
                    // Notify user
                    Notification::create([
                        'title' => 'تحذير من الإدارة',
                        'message' => 'تم الإبلاغ عن مخالفة في المحتوى الخاص بك. يرجى مراجعة المحتوى وتصحيحه.',
                        'type' => 'warning',
                        'target' => 'specific',
                        'user_id' => $user->id,
                    ]);
                }
            }
        } elseif ($action === 'delete') {
            $actionText = "تم حذف المحتوى المخالف";
            // In a real application, you would delete the content here
        }

        if ($actionText) {
            $report->addToHistory($actionText);
            $report->status = 'closed';
            $report->save();
        }

        return response()->json(['success' => true, 'message' => 'تم اتخاذ الإجراء بنجاح']);
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
}