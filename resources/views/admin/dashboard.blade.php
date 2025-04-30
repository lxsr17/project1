@extends('admin.admin')

@section('content')
    <div class="page-header">
        <h1 class="page-title">لوحة تحكم المشرف</h1>
        <p class="page-description">نظرة عامة على النظام</p>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>المتاجر</h3>
            <div class="stat-value">{{ $storesCount }}</div>
            <div class="stat-details">
                <span class="pending">{{ $pendingStores }} في انتظار الموافقة</span>
            </div>
        </div>

        <div class="stat-card">
            <h3>المستخدمين</h3>
            <div class="stat-value">{{ $usersCount }}</div>
            <div class="stat-details">
                <span>{{ $merchantCount }} تاجر</span>
              
            </div>
        </div>

        <div class="stat-card">
            <h3>البلاغات</h3>
           
            <div class="stat-details">
                
            </div>
        </div>
    </div>

    <!-- Pending Approvals -->
    <section class="pending-approvals">
        <div class="section-header">
            <h2>طلبات الموافقة على الرخص</h2>
        </div>
        <div class="approvals-list">
            @if($pendingApprovals->count() > 0)
                @foreach($pendingApprovals as $store)
                    <div class="approval-item">
                        <div class="store-info">
                            <h3 class="store-name">{{ $store->business_name_ar }}</h3>
                            <p class="store-details">
                                نوع العمل: {{ $store->main_category }}<br>
                                تاريخ الطلب: {{ $store->created_at->format('d/m/Y') }}
                            </p>
                            <span class="license-type {{ $store->commercial_registry ? 'commercial' : 'freelance' }}">
                                {{ $store->commercial_registry ? 'سجل تجاري' : 'وثيقة عمل حر' }}
                            </span>
                        </div>
                        <div class="approval-actions">
                            <button class="btn-view" data-store-id="{{ $store->id }}">عرض الرخصة</button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <p>لا توجد طلبات في انتظار الموافقة</p>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('modals')
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
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.btn-view').on('click', function() {
                const storeId = $(this).data('store-id');
                showLicenseModal(storeId);
            });

            $('#closeModal, #cancelLicense').on('click', function() {
                $('#licenseModal').removeClass('active');
            });

            $('#approveLicense').on('click', function() {
                const storeId = $('#approveLicense').data('store-id');
                approveLicense(storeId);
            });

            $('#rejectLicense').on('click', function() {
                const storeId = $('#rejectLicense').data('store-id');
                rejectLicense(storeId);
            });

            function showLicenseModal(storeId) {
                $.ajax({
                    url: `/admin/license/${storeId}`,
                    method: 'GET',
                    success: function(response) {
                        $('#licenseStoreName').text(response.business_name_ar);
                        $('#licenseType').text(response.commercial_registry ? 'سجل تجاري' : 'وثيقة عمل حر');
                        $('#licenseFile').html(`<p>ملف الرخصة</p><img src="https://via.placeholder.com/400x300" alt="License">`);
                        $('#approveLicense').data('store-id', storeId);
                        $('#rejectLicense').data('store-id', storeId);
                        $('#licenseModal').addClass('active');
                    },
                    error: function(error) {
                        alert('حدث خطأ أثناء تحميل بيانات الرخصة');
                    }
                });
            }

            function approveLicense(storeId) {
                $.ajax({
                    url: `/admin/license/${storeId}/approve`,
                    method: 'POST',
                    success: function(response) {
                        alert(response.message);
                        $('#licenseModal').removeClass('active');
                        window.location.reload();
                    },
                    error: function(error) {
                        alert('حدث خطأ أثناء الموافقة');
                    }
                });
            }

            function rejectLicense(storeId) {
                $.ajax({
                    url: `/admin/license/${storeId}/reject`,
                    method: 'POST',
                    success: function(response) {
                        alert(response.message);
                        $('#licenseModal').removeClass('active');
                        window.location.reload();
                    },
                    error: function(error) {
                        alert('حدث خطأ أثناء الرفض');
                    }
                });
            }
        });
    </script>
@endsection
