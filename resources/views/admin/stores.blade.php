@extends('admin.admin')


@section('title', 'إدارة المتاجر')

@section('content')
    <div class="page-header">
        <h1 class="page-title">إدارة المتاجر</h1>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <form action="{{ route('admin.stores.index') }}" method="GET" class="filter-form">
            <div class="search-box">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="البحث باسم المتجر أو البريد الإلكتروني">
            </div>
            <div class="filters">
                <select name="category">
                    <option value="">التصنيف</option>
                    <option value="retail" {{ request('category') == 'retail' ? 'selected' : '' }}>متجر تجزئة</option>
                    <option value="wholesale" {{ request('category') == 'wholesale' ? 'selected' : '' }}>متجر جملة</option>
                    <option value="services" {{ request('category') == 'services' ? 'selected' : '' }}>خدمات</option>
                </select>
                <select name="status">
                    <option value="">الحالة</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>في انتظار الموافقة</option>
                    <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>موقوف</option>
                </select>
                <button type="submit" class="btn btn-primary">تطبيق</button>
            </div>
        </form>
    </div>

    <!-- Stores Table -->
    <div class="stores-table">
        <table>
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
                @forelse($stores as $store)
                    <tr>
                        <td>
                            <div class="store-info">
                                <div class="store-logo">
                                    <img src="{{ $store->logo ? asset('storage/' . $store->logo) : 'https://via.placeholder.com/40' }}" alt="{{ $store->business_name_ar }}">
                                </div>
                                <div class="store-name">{{ $store->business_name_ar }}</div>
                            </div>
                        </td>
                        <td>{{ $store->owner->full_name ?? '—' }}</td>

                        <td>{{ $store->main_category }}</td>
                        <td>
                            <span class="store-status {{ $store->status }}">
                                @if($store->status == 'active')
                                    نشط
                                @elseif($store->status == 'pending')
                                    في انتظار الموافقة
                                @elseif($store->status == 'suspended')
                                    موقوف
                                @else
                                    مرفوض
                                @endif
                            </span>
                        </td>
                        <td>
                            <div class="actions">
                                <button class="action-btn view-btn" title="عرض التفاصيل" data-store-id="{{ $store->id }}">
                                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/eye.svg" alt="View">
                                </button>
                                <button class="action-btn notify-btn" title="إرسال تنبيه" data-store-id="{{ $store->id }}">
                                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/bell.svg" alt="Notify">
                                </button>
                                @if($store->status == 'active')
                                    <button class="action-btn suspend-btn" title="إيقاف المتجر" data-store-id="{{ $store->id }}">
                                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/ban.svg" alt="Suspend">
                                    </button>
                                @elseif($store->status == 'suspended')
                                    <button class="action-btn activate-btn" title="تفعيل المتجر" data-store-id="{{ $store->id }}">
                                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/check.svg" alt="Activate">
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">لا توجد متاجر</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="pagination-container">
            {{ $stores->appends(request()->query())->links() }}
        </div>
    </div>
@endsection

@section('modals')
    <!-- Store Details Modal -->
    <div class="modal" id="storeDetailsModal">
        <div class="modal-content">
            <button class="modal-close" id="closeDetailsModal">×</button>
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
    <div class="modal" id="notificationModal">
        <div class="modal-content">
            <button class="modal-close" id="closeNotificationModal">×</button>
            <h2 class="modal-title">إرسال تنبيه</h2>
            <form id="notificationForm">
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
                    <button type="submit" class="btn btn-primary">إرسال</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // View store details
            $('.view-btn').on('click', function() {
                const storeId = $(this).data('store-id');
                showStoreDetails(storeId);
            });

            // Send notification
            $('.notify-btn').on('click', function() {
                const storeId = $(this).data('store-id');
                showNotificationModal(storeId);
            });

            // Suspend store
            $('.suspend-btn').on('click', function() {
                const storeId = $(this).data('store-id');
                if (confirm('هل أنت متأكد من إيقاف هذا المتجر؟')) {
                    updateStoreStatus(storeId, 'suspended');
                }
            });

            // Activate store
            $('.activate-btn').on('click', function() {
                const storeId = $(this).data('store-id');
                if (confirm('هل أنت متأكد من تفعيل هذا المتجر؟')) {
                    updateStoreStatus(storeId, 'active');
                }
            });

            // Close modals
            $('#closeDetailsModal, #closeDetails').on('click', function() {
                $('#storeDetailsModal').removeClass('active');
            });

            $('#closeNotificationModal, #cancelNotification').on('click', function() {
                $('#notificationModal').removeClass('active');
            });

            // Submit notification form
            $('#notificationForm').on('submit', function(e) {
                e.preventDefault();
                const storeId = $('#notificationStoreId').val();
                const title = $('#notificationTitle').val();
                const message = $('#notificationMessage').val();
                
                sendNotification(storeId, title, message);
            });

            // Show store details
            function showStoreDetails(storeId) {
                $.ajax({
                    url: `/admin/stores/${storeId}`,
                    method: 'GET',
                    success: function(response) {
                        const store = response;
                        const owner = store.owner;
                        
                        let html = `
                            <div class="detail-group">
                                <h3>معلومات المتجر</h3>
                                <p>الاسم: ${store.business_name_ar}</p>
                                <p>التصنيف: ${store.main_category}</p>
                                <p>الحالة: 
                                    <span class="store-status ${store.status}">
                                        ${getStatusName(store.status)}
                                    </span>
                                </p>
                                <p>تاريخ الإنشاء: ${new Date(store.created_at).toLocaleDateString('ar-SA')}</p>
                            </div>
                            <div class="detail-group">
                                <h3>معلومات صاحب المتجر</h3>
                                <div class="owner-info">
                                    <p>الاسم: ${owner.first_name} ${owner.last_name}</p>
                                    <p>البريد الإلكتروني: ${owner.email}</p>
                                    <p>رقم الهاتف: ${owner.phone || '-'}</p>
                                </div>
                            </div>
                        `;
                        
                        $('#storeDetailsContent').html(html);
                        $('#storeDetailsModal').addClass('active');
                    },
                    error: function(error) {
                        alert('حدث خطأ أثناء تحميل بيانات المتجر');
                        console.error(error);
                    }
                });
            }

            // Show notification modal
            function showNotificationModal(storeId) {
                $('#notificationStoreId').val(storeId);
                $('#notificationForm').trigger('reset');
                $('#notificationModal').addClass('active');
            }

            // Update store status
            function updateStoreStatus(storeId, status) {
                $.ajax({
                    url: `/admin/stores/${storeId}/status`,
                    method: 'POST',
                    data: { status },
                    success: function(response) {
                        alert(response.message);
                        window.location.reload();
                    },
                    error: function(error) {
                        alert('حدث خطأ أثناء تحديث حالة المتجر');
                        console.error(error);
                    }
                });
            }

            // Send notification
            function sendNotification(storeId, title, message) {
                $.ajax({
                    url: `/admin/stores/${storeId}/notify`,
                    method: 'POST',
                    data: { title, message },
                    success: function(response) {
                        alert(response.message);
                        $('#notificationModal').removeClass('active');
                    },
                    error: function(error) {
                        alert('حدث خطأ أثناء إرسال الإشعار');
                        console.error(error);
                    }
                });
            }

            // Get status name in Arabic
            function getStatusName(status) {
                const statuses = {
                    'active': 'نشط',
                    'pending': 'في انتظار الموافقة',
                    'suspended': 'موقوف',
                    'rejected': 'مرفوض'
                };
                return statuses[status] || status;
            }
        });
    </script>
@endsection