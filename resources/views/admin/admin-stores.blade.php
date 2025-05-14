    <!DOCTYPE html>
    <html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>إدارة المتاجر - منصة تحقق</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
        <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin-stores.css') }}">
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
                    <h1 class="page-title">إدارة المتاجر</h1>
                </div>

                <!-- Filters Section -->
                <form method="GET" action="{{ route('admin.stores') }}" class="filters-section">
                    <div class="filters-wrapper">
                        <input type="text" name="q" class="filter-input" value="{{ request('q') }}" placeholder="ابحث باسم المتجر أو البريد الإلكتروني">

                        <select name="category" class="filter-select">
                            <option value="">التصنيف</option>
                            <option value="retail" {{ request('category') == 'retail' ? 'selected' : '' }}>تجزئة</option>
                            <option value="wholesale" {{ request('category') == 'wholesale' ? 'selected' : '' }}>جملة</option>
                            <option value="services" {{ request('category') == 'services' ? 'selected' : '' }}>خدمات</option>
                        </select>

                        <select name="status" class="filter-select">
                            <option value="">الحالة</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>نشط</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>بانتظار الموافقة</option>
                            <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>موقوف</option>
                        </select>

                        <div class="filter-buttons">
                            <button type="submit" class="filter-button">تصفية</button>
                            <a href="{{ route('admin.stores') }}" class="filter-reset-button">إعادة تعيين</a>
                        </div>
                    </div>
                </form>



                <!-- Stores Table -->
                            <div class="stores-table">
                    <table>
                                    <thead>
                                        <tr>
                                            <th>المتجر</th>
                                            <th>صاحب المتجر</th>
                                            <th>التصنيف</th>
                                            <th>الحالة</th>
                                            <th>التقييم</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody id="storesTableBody">
                                    @foreach($stores as $business)
                                    <tr>
                                    <td>{{ $business->business_name }}</td>
                                    <td>{{ $business->storeOwner->first_name . ' ' . $business->storeOwner->last_name }}</td>
                                    <td>{{ $business->business_type }}</td>
                                    <td>
                                        @switch($business->status)
                                            @case('approved') نشط @break
                                            @case('pending') في انتظار الموافقة @break
                                            @case('rejected') مرفوض @break
                                            @case('draft') غير مكتمل @break
                                            @case('suspended')موقف موقتا @break
                                            @default {{ $business->status }}
                                        @endswitch
                                    </td>
                                    <td>{{ number_format(optional($business->reviews)->avg('rating') ?? 0, 1) }}</td>
                                    <td class="actions">
                                    <!-- عرض التفاصيل -->
                                    <a href="{{ route('admin.stores.details', $business->id) }}" class="btn btn-gray">عرض</a>

                                    <!-- إيقاف المتجر -->
                                    <form action="{{ route('admin.stores.suspend', $business->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-warning">إيقاف</button>
                                    </form>

                                    <!-- استئناف المتجر -->
                                    <form action="{{ route('admin.stores.resume', $business->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success">استئناف</button>
                                    </form>

                                    <!-- حذف المتجر -->
                                    <form action="{{ route('admin.stores.delete', $business->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من حذف المتجر؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">حذف</button>
                                    </form>

                                    <!-- إرسال إشعار -->
                                    <button class="btn btn-dark open-notification-modal" data-store-id="{{ $business->id }}" data-store-name="{{ $business->business_name }}">
                                        إرسال إشعار
                                    </button>
                                </td>

                                </tr>
                            @endforeach
                            </tbody>
                    </table>
                </div>
            </main>
        </div>

        <!-- Store Details Modal -->
        <div class="modal" id="storeDetailsModal">
            <div class="modal-content">
                <button class="modal-close" id="closeDetailsModal">X</button>
                <h2 class="modal-title">تفاصيل المتجر</h2>
                <div class="store-details" id="storeDetailsContent">
                    <!-- Store details will be dynamically added here -->
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-outline" id="closeDetails">إغلاق</button>
                </div>
            </div>
        </div>

        <!-- Send Notification Modal -->
        <div class="modal" id="notificationModal" style="display:none;">
            <div class="modal-content">
                <button class="modal-close" id="closeNotificationModal">×</button>
                <h2 class="modal-title">إرسال تنبيه</h2>
                <form id="notificationForm">
                    @csrf
                    <input type="hidden" id="notificationStoreId">
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
                    <button type="submit" id="submitNotification" class="btn btn-primary">إرسال</button>

                    </div>
                </form>
            </div>
        </div>

        <!-- Scripts -->
        <script src="{{ asset('js/user-header.js') }}"></script>
        <script src="{{ asset('js/admin-srores.js') }}"></script>
        <script>
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("notificationModal");
    const openButtons = document.querySelectorAll(".open-notification-modal");
    const closeBtn = document.getElementById("closeNotificationModal");
    const cancelBtn = document.getElementById("cancelNotification");
    const form = document.getElementById("notificationForm");

    openButtons.forEach(button => {
        button.addEventListener("click", () => {
            const storeId = button.dataset.storeId;
            document.getElementById("notificationStoreId").value = storeId;
            modal.style.display = "block";
        });
    });

    closeBtn.addEventListener("click", () => modal.style.display = "none");
    cancelBtn.addEventListener("click", () => modal.style.display = "none");

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const storeId = document.getElementById("notificationStoreId").value;
        const title = document.getElementById("notificationTitle").value;
        const message = document.getElementById("notificationMessage").value;

        try {
            const response = await fetch(`/admin/stores/${storeId}/notify`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ title, message })
            });

            if (!response.ok) throw new Error("فشل الإرسال");

            alert("تم إرسال التنبيه بنجاح");
            modal.style.display = "none";
            form.reset();
        } catch (err) {
            alert("حدث خطأ أثناء إرسال التنبيه");
        }
    });
});
</script>
    </body>
    </html>