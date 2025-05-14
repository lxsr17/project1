
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة البلاغات - منصة تحقق</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-reports.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-header.css') }}">

</head>
<body>

<header>
            @include('admin.admin-header')
        </header>
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
        @include('admin.sidebar')
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header">
                <h1 class="page-title">إدارة البلاغات</h1>
            </div>

            <!-- Filters Section -->
            <div class="filters-section">
    <div class="search-box">
        <input type="text" id="searchInput" placeholder="البحث في البلاغات">
    </div>
    <div class="filters">
        <select id="reportTypeFilter" name="type">
            <option value="">نوع البلاغ</option>
            <option value="store">متجر</option>
            <option value="review">تقييم</option>
        </select>
        <select id="statusFilter" name="status">
            <option value="">الحالة</option>
            <option value="inProgress">قيد المراجعة</option>
            <option value="approved">تم المعالجة</option>
        </select>
        <button class="btn btn-primary" id="filterButton">تطبيق</button>
    </div>
</div>



            <!-- Reports Table -->
            <div class="reports-table">
<table>
<thead>
<tr>
<th>رقم البلاغ</th>
<th>نوع البلاغ</th>
<th>رسالة البلاغ</th>
<th>المُبلغ</th>
<th>المُبلغ عنه</th>
<th>التاريخ</th>
<th>الحالة</th>
<th>الإجراءات</th>
</tr>
</thead>
<tbody id="reportsTableBody">
@forelse($reports as $report)
<tr>
<td>{{ $report->id }}</td>
<td>{{ $report->type }}</td>
<td>{{ $report->description ?? '---' }}</td>
<!-- عرض المُبلغ -->
<td>
    @if($report->type == 'store')
        @php
            $storeOwner = \App\Models\User::find($report->user_id);
        @endphp
        {{ $storeOwner ? $storeOwner->first_name . ' ' . $storeOwner->last_name : '---' }}


        
        @elseif($report->type == 'review')
        @php
            $review = \App\Models\Review::find($report->entity_id);
            $store = $review ? \App\Models\Business::find($review->store_id) : null;
            $storeOwner = $store ? \App\Models\StoreOwner::find($store->store_owner_id) : null;
        @endphp
        {{ $storeOwner ? $storeOwner->first_name . ' ' . $storeOwner->last_name : '---' }}
    @else
        ---
    @endif
    
</td>

<!-- عرض المُبلغ عنه -->
<td>
    @if($report->type == 'review')
        @php
            $review = \App\Models\Review::find($report->entity_id);
            $reviewOwner = $review ? \App\Models\User::find($review->user_id) : null;
        @endphp
        {{ $reviewOwner ? $reviewOwner->first_name . ' ' . $reviewOwner->last_name : '---' }}
    @elseif($report->type == 'store')
        @php
            $store = \App\Models\Business::find($report->entity_id);
        @endphp
    @else
    @endif
     {{ $store ? $store->business_name : '---' }}

</td>

<td>{{ $report->created_at->format('Y-m-d') }}</td>

<td>
    @if($report->status == 'pending')
        <span class="badge bg-warning text-dark">قيد المراجعة</span>
    @elseif($report->status == 'approved' || $report->status == 'closed')
        <span class="badge bg-success">تم المعالجة</span>
    @elseif($report->status == 'inProgress')
        <span class="badge bg-info text-dark">قيد المراجعة</span>
    @elseif($report->status == 'rejected')
        <span class="badge bg-danger">مرفوض</span>
    @else
        <span class="badge bg-secondary">غير معروف</span>
    @endif
</td>



<td>
    <form action="{{ route('reports.action', $report->id) }}" method="POST">
        @csrf
        <select name="action" class="form-select form-select-sm" required>
            <option disabled selected>اختر إجراء</option>
            @if($report->type == 'review')
                <option value="delete">حذف المحتوى</option>
            @endif
            <option value="suspend">إيقاف الحساب</option>
            <option value="warning">تحذير</option>
        </select>
        <button class="btn btn-sm btn-primary mt-1" type="submit">تنفيذ</button>
    </form>
</td>



</tr>
@empty
<tr>
<td colspan="8" class="text-center text-muted">لا توجد بلاغات حتى الآن</td>
</tr>
@endforelse
</tbody>
</table>
</div>

        </main>
    </div>

    <!-- Report Details Modal -->
    <div class="modal" id="reportDetailsModal">
        <div class="modal-content">
            <button class="modal-close" id="closeDetailsModal">×</button>
            <h2 class="modal-title">تفاصيل البلاغ</h2>
            <div class="report-details" id="reportDetailsContent">
                <!-- Report details will be dynamically added here -->
            </div>
            <div class="report-actions">
                <select id="reportStatus" class="status-select">
                    <option value="new">جديد</option>
                    <option value="inProgress">قيد المراجعة</option>
                    <option value="closed">مغلق</option>
                </select>
                <button type="button" class="btn btn-primary" id="takeAction">اتخاذ إجراء</button>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-outline" id="closeDetails">إغلاق</button>
                <button type="button" class="btn btn-primary" id="updateStatus">تحديث الحالة</button>
            </div>
        </div>
    </div>

    <!-- Take Action Modal -->
    <div class="modal" id="actionModal">
        <div class="modal-content">
            <button class="modal-close" id="closeActionModal">×</button>
            <h2 class="modal-title">اتخاذ إجراء</h2>
            <div class="action-options">
                <button class="action-btn suspend-btn">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/ban.svg" alt="">
                    إيقاف المتجر/المستخدم
                </button>
                <button class="action-btn warning-btn">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/triangle-exclamation.svg" alt="">
                    إرسال تحذير
                </button>
                <button class="action-btn delete-btn">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/trash.svg" alt="">
                    حذف المحتوى المخالف
                </button>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-outline" id="cancelAction">إلغاء</button>
            </div>
        </div>
    </div>


<<script>
    document.getElementById('filterButton').addEventListener('click', function() {
        const type = document.getElementById('reportTypeFilter').value;
        const status = document.getElementById('statusFilter').value;
        const search = document.getElementById('searchInput').value;

        let query = '?';
        if (type) query += `type=${type}&`;
        if (status) query += `status=${status}&`;
        if (search) query += `search=${search}&`;

        // إزالة الفاصلة الزائدة في النهاية
        query = query.slice(0, -1);

        // تحديث الرابط بشكل ديناميكي
        window.location.href = '/admin/reports' + query;
    });
</script>


    <script src="{{ asset('js/user-header.js') }}"></script>
    <script src="{{ asset('js/admin-reports.js') }}"></script>
</body>
</html>