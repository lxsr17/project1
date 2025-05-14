@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المستخدمين - منصة تحقق</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-users.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-header.css') }}">
<style>
    

    </style>
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
                <h1 class="page-title">إدارة المستخدمين</h1>
            </div>

            <!-- Filters Section -->
            <form method="GET" action="{{ route('admin.users') }}" class="filters-section">
                <div class="search-box">
                    <input type="text" id="searchInput" name="q" placeholder="البحث بالاسم أو البريد الإلكتروني" value="{{ request('q') }}">
                </div>
                <div class="filters">
                    <select id="userTypeFilter" name="type">
                        <option value="">نوع المستخدم</option>
                        <option value="visitor" {{ request('type') == 'visitor' ? 'selected' : '' }}>زائر</option>
                        <option value="merchant" {{ request('type') == 'merchant' ? 'selected' : '' }}>تاجر</option>
                    </select>
                    <select id="statusFilter" name="status">
                        <option value="">الحالة</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>موقوف</option>
                    </select>
                </div>
                <button type="submit" class="btn">تصفية</button>
                <button type="button" id="resetFilters" class="btn btn-reset">إعادة تعيين</button>

            </form>


            <!-- Users Table -->
            <div class="users-table">
            <table class="table table-striped">
    <thead>
        <tr>
            <th>الاسم</th>
            <th>البريد الإلكتروني</th>
            <th>نوع المستخدم</th>
            <th>الحالة</th>
            <th>تاريخ التسجيل</th>
            <th>إجراءات</th>
        </tr>
    </thead>
    <tbody id="usersTableBody">
        <!-- عرض الزوار -->
        @foreach($visitors as $user)
            <tr>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>زائر</td>
                <td>{{ $user->status == 'active' ? 'نشط' : 'موقوف' }}</td>
                <td>
    @if($user->created_at)
        {{ $user->created_at->format('Y-m-d') }}
    @else
        <span class="text-muted">غير متوفر</span>
    @endif
</td>
                <td>
                    <form method="POST" action="{{ route('admin.users.suspend', $user->id) }}" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="type" value="visitor">
                        <button class="btn btn-warning">إيقاف</button>
                    </form>
                    <form method="POST" action="{{ route('admin.users.resume', $user->id) }}" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="type" value="visitor">
                        <button class="btn btn-success">استئناف</button>
                    </form>
                    <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" style="display:inline;" onsubmit="return confirm('هل أنت متأكد؟');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">حذف</button>
                    </form>
                </td>
            </tr>
        @endforeach

        <!-- عرض التجار -->
        @foreach($merchants as $user)
            <tr>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>تاجر</td>
                <td>{{ $user->status == 'active' ? 'نشط' : 'موقوف' }}</td>
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.users.suspend', $user->id) }}" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="type" value="merchant">
                        <button class="btn btn-warning">إيقاف</button>
                    </form>
                    <form method="POST" action="{{ route('admin.users.resume', $user->id) }}" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="type" value="merchant">
                        <button class="btn btn-success">استئناف</button>
                    </form>
                    <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" style="display:inline;" onsubmit="return confirm('هل أنت متأكد؟');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">حذف</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>



            </div>
        </main>
    </div>

    <!-- User Details Modal -->
    <div class="modal" id="userDetailsModal">
        <div class="modal-content">
            <button class="modal-close" id="closeDetailsModal">×</button>
            <h2 class="modal-title">تفاصيل المستخدم</h2>
            <div class="user-details" id="userDetailsContent">
                <!-- User details will be dynamically added here -->
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-outline" id="closeDetails">إغلاق</button>
            </div>
        </div>
    </div>

    <!-- Send Notification Modal -->
    <div class="modal" id="notificationModal">
        <div class="modal-content">
            <button class="modal-close" id="closeNotificationModal">×</button>
            <h2 class="modal-title">إرسال تنبيه</h2>
            <form id="notificationForm">
                <input type="hidden" id="notificationUserId">
                <div class="form-group">
                    <label for="notificationTitle">عنوان التنبيه</label>
                    <input type="text" id="notificationTitle" required>
                </div>
                <div class="form-group">
                    <label for="notificationMessage">نص التنبيه</label>
                    <textarea id="notificationMessage" rows="4" required></textarea>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-outline" id="cancelNotification">إلغاء</button>
                    <button type="submit" class="btn btn-primary">إرسال</button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/user-header.js') }}"></script>
    <script src="{{ asset('js/admin-users.js') }}"></script>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const resetBtn = document.getElementById('resetFilters');
    const filtersForm = resetBtn?.closest('form');

    if (resetBtn && filtersForm) {
        resetBtn.addEventListener('click', function () {
            // تفريغ القيم
            document.getElementById('searchInput').value = '';
            document.getElementById('userTypeFilter').value = '';
            document.getElementById('statusFilter').value = '';

            // إرسال النموذج لإعادة تحميل البيانات من السيرفر بدون فلترة
            filtersForm.submit();
        });
    }
});
</script>

 


</body>
</html>