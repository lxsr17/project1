@extends('admin.admin')

@section('title', 'إدارة الإشعارات')

@section('content')
    <div class="page-header">
        <h1 class="page-title">إدارة الإشعارات</h1>
        <button class="btn btn-primary" id="createNotificationBtn">
            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/plus.svg" alt="">
            إنشاء إشعار جديد
        </button>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <form action="{{ route('admin.notifications.index') }}" method="GET" class="filter-form">
            <div class="search-box">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="البحث في الإشعارات">
            </div>
            <div class="filters">
                <select name="target">
                    <option value="">الفئة المستهدفة</option>
                    <option value="all" {{ request('target') == 'all' ? 'selected' : '' }}>الكل</option>
                    <option value="merchant" {{ request('target') == 'merchant' ? 'selected' : '' }}>التجار</option>
                    <option value="visitor" {{ request('target') == 'visitor' ? 'selected' : '' }}>الزوار</option>
                </select>
                <select name="type">
                    <option value="">نوع الإشعار</option>
                    <option value="alert" {{ request('type') == 'alert' ? 'selected' : '' }}>تنبيه</option>
                    <option value="announcement" {{ request('type') == 'announcement' ? 'selected' : '' }}>إعلان</option>
                    <option value="warning" {{ request('type') == 'warning' ? 'selected' : '' }}>تحذير</option>
                </select>
                <select name="date">
                    <option value="">التاريخ</option>
                    <option value="today" {{ request('date') == 'today' ? 'selected' : '' }}>اليوم</option>
                    <option value="week" {{ request('date') == 'week' ? 'selected' : '' }}>آخر أسبوع</option>
                    <option value="month" {{ request('date') == 'month' ? 'selected' : '' }}>آخر شهر</option>
                </select>
                <button type="submit" class="btn btn-primary">تطبيق</button>
            </div>
        </form>
    </div>

    <!-- Notifications List -->
    <div class="notifications-list">
        @forelse($notifications as $notification)
            <div class="notification-item" data-id="{{ $notification->id }}">
                <div class="notification-header">
                    <div class="notification-info">
                        <h3 class="notification-title">{{ $notification->title }}</h3>
                        <div class="notification-meta">
                            <span class="notification-type {{ $notification->type }}">
                                @if($notification->type == 'alert')
                                    تنبيه
                                @elseif($notification->type == 'announcement')
                                    إعلان
                                @elseif($notification->type == 'warning')
                                    تحذير
                                @elseif($notification->type == 'admin')
                                    إداري
                                @endif
                            </span>
                            <span class="notification-target">
                                @if($notification->target == 'specific')
                                    @php
                                        $user = \App\Models\User::find($notification->user_id);
                                        $userName = $user ? $user->full_name : 'مستخدم محدد';
                                    @endphp
                                    {{ $userName }}
                                @elseif($notification->target == 'all')
                                    الكل
                                @elseif($notification->target == 'merchant')
                                    التجار
                                @elseif($notification->target == 'visitor')
                                    الزوار
                                @endif
                            </span>
                            <span class="notification-date">{{ $notification->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    <div class="notification-actions">
                        <button class="action-btn edit-btn" title="تعديل" data-id="{{ $notification->id }}">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/pen.svg" alt="Edit">
                        </button>
                        <button class="action-btn delete-btn" title="حذف" data-id="{{ $notification->id }}">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/trash.svg" alt="Delete">
                        </button>
                    </div>
                </div>
                <div class="notification-content">
                    {{ $notification->message }}
                </div>
            </div>
        @empty
            <div class="empty-state">
                <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/bell-slash.svg" alt="">
                <h2>لا توجد إشعارات</h2>
                <p>لم يتم إنشاء أي إشعارات بعد</p>
            </div>
        @endforelse
        
        <div class="pagination-container">
            {{ $notifications->appends(request()->query())->links() }}
        </div>
    </div>
@endsection

@section('modals')
    <!-- Create/Edit Notification Modal -->
    <div class="modal" id="notificationModal">
        <div class="modal-content">
            <button class="modal-close" id="closeModal">×</button>
            <h2 class="modal-title">إنشاء إشعار جديد</h2>
            <form id="notificationForm" action="{{ route('admin.notifications.store') }}" method="POST">
                @csrf
                <input type="hidden" id="notificationId" name="id">
                <div class="form-group">
                    <label for="notificationType">نوع الإشعار</label>
                    <select id="notificationType" name="type" required>
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
                    <label for="specificUser">اختر المست  style="display: none;">
                    <label for="specificUser">اختر المستخدم</label>
                    <select id="specificUser" name="user_id">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->full_name }} ({{ $user->email }})</option>
                        @endforeach
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
                    <button type="button" class="btn btn-outline" id="cancelBtn">إلغاء</button>
                    <button type="submit" class="btn btn-primary">إرسال الإشعار</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Create notification button
            $('#createNotificationBtn').on('click', function() {
                showModal();
            });

            // Edit notification
            $('.edit-btn').on('click', function() {
                const notificationId = $(this).data('id');
                editNotification(notificationId);
            });

            // Delete notification
            $('.delete-btn').on('click', function() {
                const notificationId = $(this).data('id');
                if (confirm('هل أنت متأكد من حذف هذا الإشعار؟')) {
                    deleteNotification(notificationId);
                }
            });

            // Close modal
            $('#closeModal, #cancelBtn').on('click', function() {
                $('#notificationModal').removeClass('active');
            });

            // Target change
            $('#notificationTarget').on('change', function() {
                if ($(this).val() === 'specific') {
                    $('#specificUserGroup').show();
                } else {
                    $('#specificUserGroup').hide();
                }
            });

            // Show modal
            function showModal(isEdit = false) {
                $('#notificationForm').trigger('reset');
                $('#notificationForm').attr('method', 'POST');
                $('#notificationForm').attr('action', '{{ route("admin.notifications.store") }}');
                $('input[name="_method"]').remove();
                
                $('.modal-title').text(isEdit ? 'تعديل الإشعار' : 'إنشاء إشعار جديد');
                $('#specificUserGroup').hide();
                $('#notificationModal').addClass('active');
            }

            // Edit notification
            function editNotification(id) {
                $.ajax({
                    url: `/admin/notifications/${id}`,
                    method: 'GET',
                    success: function(response) {
                        const notification = response;
                        
                        $('#notificationId').val(notification.id);
                        $('#notificationType').val(notification.type);
                        $('#notificationTarget').val(notification.target);
                        $('#notificationTitle').val(notification.title);
                        $('#notificationMessage').val(notification.message);
                        
                        if (notification.target === 'specific') {
                            $('#specificUserGroup').show();
                            $('#specificUser').val(notification.user_id);
                        }
                        
                        $('#notificationForm').attr('method', 'POST');
                        $('#notificationForm').attr('action', `/admin/notifications/${id}`);
                        $('#notificationForm').append('<input type="hidden" name="_method" value="PUT">');
                        
                        showModal(true);
                    },
                    error: function(error) {
                        alert('حدث خطأ أثناء تحميل بيانات الإشعار');
                        console.error(error);
                    }
                });
            }

            // Delete notification
            function deleteNotification(id) {
                $.ajax({
                    url: `/admin/notifications/${id}`,
                    method: 'DELETE',
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function(error) {
                        alert('حدث خطأ أثناء حذف الإشعار');
                        console.error(error);
                    }
                });
            }
        });
    </script>
@endsection