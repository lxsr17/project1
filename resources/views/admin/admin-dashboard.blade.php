<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المشرف - منصة تحقق</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
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
                <h1 class="page-title">لوحة تحكم المشرف</h1>
                <p class="page-description">نظرة عامة على النظام</p>
            </div>
<!-- Stats Grid -->
<div class="stats-grid">
    <!-- قسم المتاجر -->
    <div class="stat-card">
        <h3>المتاجر</h3>
        <div class="stat-value" id="storesCount">{{ $storesCount }}</div>
        <div class="stat-details">
            <span class="pending" id="pendingStores">{{ $pendingStores }} متجر في انتظار الموافقة </span>
            <span class="suspended" id="suspendedStores">{{ $suspendedStores }} متجر موقوف مؤقتًا </span>
        </div>
    </div>
    <!-- قسم المستخدمين -->
    <div class="stat-card">
    <h3>المستخدمين</h3>
    <div class="stat-value" id="usersCount">{{ $usersCount }}</div>
    <div class="stat-details">
        <span id="merchantCount">{{ $merchantCount }} تاجر</span>
        <span id="visitorCount">{{ $visitorCount }} زائر</span>
    </div>
</div>


    <!-- قسم البلاغات -->
    <div class="stat-card">
        <h3>البلاغات</h3>
        <div class="stat-value" id="reportsCount">{{ $reportsCount }}</div>
        <div class="stat-details">
            <span class="pending" id="pendingReports">{{ $pendingReports }} بلاغ جديد</span>
        </div>
    </div>
</div>


            <!-- Pending Approvals -->
            <section class="pending-approvals">
                <div class="section-header">
                    <h2>طلبات الموافقة على الرخص</h2>
                    
                </div>
                <div class="approvals-list" id="approvalsList">
                @if($pendingApprovals->count())
                <table class="table">
                    
                <thead>
            <tr>
                <th>المتجر</th>
                <th>صاحب المتجر</th>
                <th>التصنيف</th>
                <th>الحالة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
    @foreach($pendingApprovals as $store)
        <tr>
            <td>{{ $store->business_name ?? '-' }}</td>
            <td>{{ $store->storeOwner->first_name ?? '-' }}</td>
            <td>{{ $store->business_type ?? '-' }}</td>
            <td>{{ $store->status }}</td>
            <td class="actions">
    <a href="{{ route('admin.stores.details', $store->id) }}" class="btn btn-gray">عرض</a>
</td>




        </tr>
    @endforeach
</tbody>

    </table>
    

@else
    <p>لا توجد طلبات حالياً.</p>
@endif
                </div>
            </section>
        </main>
    </div>

    <!-- View License Modal -->
    <div class="modal" id="licenseModal">
        <div class="modal-content">
            <button class="modal-close" id="closeModal">×</button>
            <h2 class="modal-title">عرض الرخصة</h2>
            <div class="license-content">
                <div class="license-info">
                    <h3 id="licenseStoreName"></h3>
                    <p id="licenseType"></p>
                </div>
                <div class="license-file" id="licenseFile">
                    <!-- License file will be displayed here -->
                </div>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-outline" id="cancelLicense">إغلاق</button>
                <button type="button" class="btn btn-primary" id="approveLicense">موافقة</button>
                <button type="button" class="btn btn-reject" id="rejectLicense">رفض</button>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/user-header.js') }}"></script>
    <script src="{{ asset('js/admin-dashboard.js') }}"></script>


</body>
</html>