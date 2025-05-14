<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        return view('admin.admin-reports', compact('reports'));

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

    $report = Report::findOrFail($id);

    // نجيب الكيان المرتبط بالبلاغ حسب النوع
    $entity = null;
    if ($report->type === 'store') {
        $entity = \App\Models\Store::find($report->entity_id);
    } elseif ($report->type === 'user') {
        $entity = \App\Models\User::find($report->entity_id);
    }

    if (!$entity) {
        return back()->withErrors(['message' => 'الكيان غير موجود']);
    }

    // تنفيذ الإجراء
    switch ($request->action) {
        case 'suspend':
            $entity->status = 'suspended';
            $entity->save();
            $report->status = 'approved';
            $report->save();
            $report->addToHistory('تم إيقاف الكيان');
            break;

        case 'warning':
            $report->status = 'approved';
            $report->save();
            $report->addToHistory('تم إرسال تحذير');
            break;

        case 'delete':
            $entity->delete();
            $report->status = 'approved';
            $report->save();
            $report->addToHistory('تم حذف الكيان');
            break;
    }

    return back()->with('success', 'تم تنفيذ الإجراء بنجاح');
    
}

    public function store(Request $request)
    {
        $request->validate([
            'entity_id' => 'required|integer',
            'type' => 'required|string',
            'description' => 'required|string|max:1000',
        ]);

        Report::create([
            'user_id'     => Auth::id(),
            'entity_id'   => $request->entity_id,
            'type'        => $request->type,
            'description' => $request->description,
            'status'      => 'pending',
        ]);

        return back()->with('success', 'تم إرسال البلاغ بنجاح، سيتم مراجعته قريبًا.');
    }
}

 