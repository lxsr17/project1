<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::query()->with('reporter');

        if ($request->filled('search')) {
            $query->where('description', 'like', "%{$request->search}%");
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
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

        $reports = $query->latest()->paginate(10);

        return view('admin.reports', compact('reports'));
    }

    public function show($id)
    {
        $report = Report::with('reporter')->findOrFail($id);

        $reportedEntity = null;
        if ($report->type === 'store') {
            $reportedEntity = Store::find($report->entity_id);
        } elseif ($report->type === 'user') {
            $reportedEntity = User::find($report->entity_id);
        }

        return response()->json([
            'report' => $report,
            'reportedEntity' => $reportedEntity,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,inProgress,closed'
        ]);

        $report = Report::findOrFail($id);
        $report->status = $request->status;
        $report->save();

        return response()->json(['message' => 'تم تحديث حالة البلاغ بنجاح']);
    }

    public function takeAction(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:suspend,warning,delete'
        ]);

        // هنا تقدر تطبق منطق الإيقاف أو الحذف حسب الحاجة.
        return response()->json(['message' => 'تم اتخاذ الإجراء بنجاح']);
    }
}

 /*
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
