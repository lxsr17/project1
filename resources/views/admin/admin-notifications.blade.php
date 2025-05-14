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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الإشعارات - منصة تحقق</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-notifications.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-header.css') }}">
</head>
<body>
<header>
    @include('admin.admin-header')
</header>
<div class="dashboard">
    <aside class="sidebar">
        @include('admin.sidebar')
    </aside>

    <main class="main-content">

<div class="page-header">
    <h1 class="page-title">إدارة الإشعارات</h1>
    <button class="btn btn-primary" id="createNotificationBtn">
        <i class="fas fa-plus"></i> إنشاء إشعار جديد
    </button>
</div>

<!-- Filters Section -->
<div class="filters-section">
    <div class="search-box">
        <input type="text" id="searchInput" placeholder="البحث في الإشعارات">
    </div>
    <div class="filters">
        <select id="targetFilter">
            <option value="">الفئة المستهدفة</option>
            <option value="merchant">التجار</option>
            <option value="visitor">الزوار</option>
        </select>
        <select id="typeFilter">
            <option value="">الإشعار</option>
            <option value="alert">تنبيه</option>
            <option value="announcement">إعلان</option>
            <option value="warning">تحذير</option>
        </select>
        <select id="dateFilter">
            <option value="">التاريخ</option>
            <option value="today">اليوم</option>
            <option value="week">آخر أسبوع</option>
            <option value="month">آخر شهر</option>
        </select>
        <button id="applyFilterBtn" class="btn btn-primary">
            <i class="fas fa-filter"></i> تطبيق
        </button>
        <button id="resetFilterBtn" class="btn btn-secondary">
            <i class="fas fa-sync"></i> إعادة تعيين
        </button>
    </div>
</div>



        <!-- Notifications List -->
        <div class="notifications-list" id="notificationsList">
            <table class="table table-striped">
                <thead>

                <tr>
    <th>العنوان</th>
    <th>نوع الإشعار</th>
    <th>الإشعار</th> <!-- تعديل -->
    <th>الرسالة</th> <!-- تعديل -->
    <th>الفئة المستهدفة</th>
    <th>التاريخ</th>
    <th>حالة القراءة</th>
    <th>المُرسل</th>
    <th>الرابط</th>
    <th>التاريخ المحدد</th>
    <th>الإجراءات</th>
</tr>

@foreach($notifications as $notification)
<tr>
    <td>{{ $notification->title }}</td>
    <td>{{ ucfirst($notification->type) }}</td>
    <td>
    @if($notification->type == 'alert')
    تنبيه
@elseif($notification->type == 'announcement')
    إعلان
@elseif($notification->type == 'warning')
    تحذير
@endif

    </td>
    <td>{{ $notification->message }}</td> <!-- تعديل -->
    <td>
    @switch($notification->target)
        @case('merchant')
            تجار
            @break
        @case('visitor')
            زوار
            @break
        @case('all')
            الكل
            @break
        @case('specific')
            مستخدم محدد
            @break
        @default
            غير محدد
    @endswitch
</td>


    <td>{{ $notification->created_at->format('Y-m-d') }}</td>
    <td>
        @if($notification->is_read)
            <span class="badge bg-success">مقروء</span>
        @else
            <span class="badge bg-warning">غير مقروء</span>
        @endif
    </td>
    <td>{{ $notification->sender_admin_id ? 'Admin' : 'System' }}</td>
    <td>
        @if($notification->link)
            <a href="{{ $notification->link }}" target="_blank">عرض</a>
        @else
            ---
        @endif
    </td>
    <td>{{ $notification->date ? $notification->date : '---' }}</td>
    <td>
    <button onclick="deleteNotification({{ $notification->id }})" class="btn btn-sm btn-danger">حذف</button>
</td>

</tr>
@endforeach


                </tbody>
            </table>
        </div>
    </main>
</div>

  <!-- Create/Edit Notification Modal -->
  <!-- نافذة إنشاء الإشعار -->
<div class="modal" id="notificationModal">
    <div class="modal-content">
        <button class="modal-close" id="closeModal">×</button>
        <h2 class="modal-title">إنشاء إشعار جديد</h2>
        <form action="{{ route('admin.notifications.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="notificationType">نوع الإشعار</label>
        <select id="notificationType" name="type" required>
            <option value="" disabled selected>اختر نوع الإشعار</option>
            <option value="alert">تنبيه</option>
            <option value="announcement">إعلان</option>
            <option value="warning">تحذير</option>
        </select>
    </div>
    <div class="form-group">
        <label for="notificationTarget">الفئة المستهدفة</label>
        <select id="notificationTarget" name="target" required>
            <option value="all">الكل</option>
            <option value="merchant">التجار</option>
            <option value="visitor">الزوار</option>
            <option value="specific">مستخدم محدد</option>
        </select>
    </div>
    <div class="form-group" id="specificUserGroup" style="display: none;">
        <label for="specificUser">اختر المستخدم</label>
        <select id="specificUser" name="userId">
            <!-- تعبئة المستخدمين بشكل ديناميكي -->
        </select>
    </div>
    <div class="form-group">
        <label for="notificationTitle">عنوان الإشعار</label>
        <input type="text" id="notificationTitle" name="title" required>
    </div>
    <div class="form-group">
        <label for="notificationMessage">نص الإشعار</label>
        <textarea id="notificationMessage" name="message" rows="4" required></textarea>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">إرسال الإشعار</button>
    </div>
</form>

    </div>
</div>


    <script src="{{ asset('js/user-header.js') }}"></script>
    <script type="module" src="{{ asset('js/admin-notifications.js') }}"></script>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const createBtn = document.getElementById('createNotificationBtn');
    const modal = document.getElementById('notificationModal');
    const closeModal = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelBtn');

    if (createBtn) {
        createBtn.addEventListener('click', function () {
            modal.classList.add('active');
        });
    }

    if (closeModal) {
        closeModal.addEventListener('click', function () {
            modal.classList.remove('active');
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', function () {
            modal.classList.remove('active');
        });
    }
});
</script>






</script>
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const createBtn = document.getElementById('createNotificationBtn');
    const modal = document.getElementById('notificationModal');
    const closeModal = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const notificationForm = document.getElementById('notificationForm');
    const notificationTarget = document.getElementById('notificationTarget');
    const specificUserGroup = document.getElementById('specificUserGroup');
    const specificUser = document.getElementById('specificUser');

    // فتح النافذة
    createBtn.addEventListener('click', function () {
        modal.classList.add('active');
    });

    // إغلاق النافذة
    closeModal.addEventListener('click', function () {
        modal.classList.remove('active');
    });

    cancelBtn.addEventListener('click', function () {
        modal.classList.remove('active');
    });

    // إظهار حقل المستخدم المحدد عند اختيار "مستخدم محدد"
    document.addEventListener('DOMContentLoaded', function () {
    const notificationTarget = document.getElementById('notificationTarget');
    const specificUserGroup = document.getElementById('specificUserGroup');

    notificationTarget.addEventListener('change', function () {
        if (notificationTarget.value === 'specific') {
            specificUserGroup.style.display = 'block';
        } else {
            specificUserGroup.style.display = 'none';
        }
    });
});


    // إرسال الإشعار
    notificationForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(notificationForm);
        const data = {
            type: formData.get('type'),
            target: formData.get('target'),
            title: formData.get('title'),
            message: formData.get('message'),
            userId: formData.get('userId') || null
        };

        try {
            const response = await fetch('/admin/notifications', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            if (result.success) {
                alert('تم إرسال الإشعار بنجاح');
                modal.classList.remove('active');
                notificationForm.reset();
            } else {
                alert('حدث خطأ أثناء إرسال الإشعار: ' + result.message);
            }
        } catch (error) {
            alert('فشل الاتصال بالخادم');
        }
    });

    // عرض جميع الإشعارات
    function deleteNotification(id) {
    if (!confirm('هل أنت متأكد من حذف هذا الإشعار؟')) return;

    fetch(`/admin/notifications/${id}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert(result.message);
            // إزالة الصف من الجدول بعد الحذف
            const row = document.getElementById(`notification-${id}`);
            if (row) row.remove();
        } else {
            alert('خطأ: ' + result.message);
        }
    })
    .catch(error => {
        alert('فشل الاتصال بالخادم');
    });
}

    // صيغة عرض الفئة باللغة العربية
    function formatTarget(target) {
        switch (target) {
            case 'all':
                return 'الكل';
            case 'merchant':
                return 'التجار';
            case 'visitor':
                return 'الزوار';
            case 'specific':
                return 'مستخدم محدد';
            default:
                return 'غير معروف';
        }
    }

    // تحميل الإشعارات من المتغير الذي يتم تمريره من Laravel
    const notifications = @json($notifications);
    displayNotifications();
});
</script>
@endsection

</script>

</body>
</html>
