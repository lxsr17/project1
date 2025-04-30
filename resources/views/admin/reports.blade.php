@extends('admin.admin')

@section('title', 'إدارة البلاغات')

@section('content')
    <div class="page-header">
        <h1 class="page-title">إدارة البلاغات</h1>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="filter-form">
            <div class="search-box">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="البحث في البلاغات">
            </div>
            <div class="filters">
                <select name="type">
                    <option value="">نوع البلاغ</option>
                    <option value="store" {{ request('type') == 'store' ? 'selected' : '' }}>متجر</option>
                    <option value="user" {{ request('type') == 'user' ? 'selected' : '' }}>مستخدم</option>
                    <option value="product" {{ request('type') == 'product' ? 'selected' : '' }}>منتج</option>
                    <option value="review" {{ request('type') == 'review' ? 'selected' : '' }}>تقييم</option>
                </select>
                <select name="status">
                    <option value="">الحالة</option>
                    <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>جديد</option>
                    <option value="inProgress" {{ request('status') == 'inProgress' ? 'selected' : '' }}>قيد المراجعة</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>مغلق</option>
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

    <!-- Reports Table -->
    <div class="reports-table">
        <table>
            <thead>
                <tr>
                    <th>رقم البلاغ</th>
                    <th>نوع البلاغ</th>
                    <th>المُبلغ</th>
                    <th>المُبلغ عنه</th>
                    <th>التاريخ</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                    <tr>
                        <td>#{{ $report->id }}</td>
                        <td>
                            <span class="report-type {{ $report->type }}">
                                @if($report->type == 'store')
                                    متجر
                                @elseif($report->type == 'user')
                                    مستخدم
                                @elseif($report->type == 'product')
                                    منتج
                                @elseif($report->type == 'review')
                                    تقييم
                                @endif
                            </span>
                        </td>
                        <td>{{ $report->reporter->full_name }}</td>
                        <td>
                            @php
                                $entityName = '-';
                                if ($report->type == 'store') {
                                    $store = \App\Models\Store::find($report->entity_id);
                                    if ($store) {
                                        $entityName = $store->business_name_ar;
                                    }
                                } elseif ($report->type == 'user') {
                                    $user = \App\Models\User::find($report->entity_id);
                                    if ($user) {
                                        $entityName = $user->full_name;
                                    }
                                }
                            @endphp
                            {{ $entityName }}
                        </td>
                        <td>{{ $report->created_at->format('d/m/Y') }}</td>
                        <td>
                            <span class="report-status {{ $report->status }}">
                                @if($report->status == 'new')
                                    جديد
                                @elseif($report->status == 'inProgress')
                                    قيد المراجعة
                                @elseif($report->status == 'closed')
                                    مغلق
                                @endif
                            </span>
                        </td>
                        <td>
                            <div class="actions">
                                <button class="action-btn view-btn" title="عرض التفاصيل" data-report-id="{{ $report->id }}">
                                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/eye.svg" alt="View">
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">لا يوجد بلاغات</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="pagination-container">
            {{ $reports->appends(request()->query())->links() }}
        </div>
    </div>
@endsection

@section('modals')
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
                <button class="action-btn suspend-btn" data-action="suspend">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/ban.svg" alt="">
                    إيقاف المتجر/المستخدم
                </button>
                <button class="action-btn warning-btn" data-action="warning">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/triangle-exclamation.svg" alt="">
                    إرسال تحذير
                </button>
                <button class="action-btn delete-btn" data-action="delete">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/trash.svg" alt="">
                    حذف المحتوى المخالف
                </button>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-outline" id="cancelAction">إلغاء</button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let currentReportId = null;

            // View report details
            $('.view-btn').on('click', function() {
                const reportId = $(this).data('report-id');
                showReportDetails(reportId);
            });

            // Close modals
            $('#closeDetailsModal, #closeDetails').on('click', function() {
                $('#reportDetailsModal').removeClass('active');
            });

            $('#closeActionModal, #cancelAction').on('click', function() {
                $('#actionModal').removeClass('active');
            });

            // Take action button
            $('#takeAction').on('click', function() {
                $('#actionModal').addClass('active');
            });

            // Update status button
            $('#updateStatus').on('click', function() {
                updateReportStatus();
            });

            // Action buttons
            $('.action-options .action-btn').on('click', function() {
                const action = $(this).data('action');
                takeAction(action);
            });

            // Show report details
            function showReportDetails(reportId) {
                $.ajax({
                    url: `/admin/reports/${reportId}`,
                    method: 'GET',
                    success: function(response) {
                        const report = response.report;
                        const reportedEntity = response.reportedEntity;
                        currentReportId = report.id;
                        
                        let entityName = '-';
                        let entityType = getReportTypeName(report.type);
                        
                        if (reportedEntity) {
                            if (report.type === 'store') {
                                entityName = reportedEntity.business_name_ar;
                            } else if (report.type === 'user') {
                                entityName = `${reportedEntity.first_name} ${reportedEntity.last_name}`;
                            }
                        }
                        
                        let html = `
                            <div class="detail-group">
                                <h3>تفاصيل البلاغ</h3>
                                <p>رقم البلاغ: #${report.id}</p>
                                <p>نوع البلاغ: ${getReportTypeName(report.type)}</p>
                                <p>تاريخ البلاغ: ${new Date(report.created_at).toLocaleDateString('ar-SA')}</p>
                                <p>الحالة: ${getStatusName(report.status)}</p>
                            </div>
                            <div class="detail-group">
                                <h3>المُبلغ</h3>
                                <p>الاسم: ${report.reporter.first_name} ${report.reporter.last_name}</p>
                                <p>البريد الإلكتروني: ${report.reporter.email}</p>
                            </div>
                            <div class="detail-group">
                                <h3>المُبلغ عنه</h3>
                                <p>النوع: ${entityType}</p>
                                <p>الاسم: ${entityName}</p>
                            </div>
                            <div class="detail-group">
                                <h3>وصف البلاغ</h3>
                                <div class="report-description">${report.description}</div>
                            </div>
                        `;
                        
                        if (report.history && report.history.length > 0) {
                            html += `
                                <div class="report-history">
                                    <h3>سجل الإجراءات</h3>
                                    ${report.history.map(item => `
                                        <div class="history-item">
                                            <div class="history-date">${new Date(item.date).toLocaleDateString('ar-SA')}</div>
                                            <div class="history-action">${item.action}</div>
                                        </div>
                                    `).join('')}
                                </div>
                            `;
                        } else {
                            html += `
                                <div class="report-history">
                                    <h3>سجل الإجراءات</h3>
                                    <p>لا يوجد إجراءات سابقة</p>
                                </div>
                            `;
                        }
                        
                        $('#reportDetailsContent').html(html);
                        $('#reportStatus').val(report.status);
                        $('#reportDetailsModal').addClass('active');
                    },
                    error: function(error) {
                        alert('حدث خطأ أثناء تحميل بيانات البلاغ');
                        console.error(error);
                    }
                });
            }

            // Update report status
            function updateReportStatus() {
                if (!currentReportId) return;
                
                const status = $('#reportStatus').val();
                
                $.ajax({
                    url: `/admin/reports/${currentReportId}/status`,
                    method: 'POST',
                    data: { status },
                    success: function(response) {
                        alert(response.message);
                        window.location.reload();
                    },
                    error: function(error) {
                        alert('حدث خطأ أثناء تحديث حالة البلاغ');
                        console.error(error);
                    }
                });
            }

            // Take action
            function takeAction(action) {
                if (!currentReportId) return;
                
                $.ajax({
                    url: `/admin/reports/${currentReportId}/action`,
                    method: 'POST',
                    data: { action },
                    success: function(response) {
                        alert(response.message);
                        $('#actionModal').removeClass('active');
                        window.location.reload();
                    },
                    error: function(error) {
                        alert('حدث خطأ أثناء اتخاذ الإجراء');
                        console.error(error);
                    }
                });
            }

            // Get report type name in Arabic
            function getReportTypeName(type) {
                const types = {
                    'store': 'متجر',
                    'user': 'مستخدم',
                    'product': 'منتج',
                    'review': 'تقييم'
                };
                return types[type] || type;
            }

            // Get status name in Arabic
            function getStatusName(status) {
                const statuses = {
                    'new': 'جديد',
                    'inProgress': 'قيد المراجعة',
                    'closed': 'مغلق'
                };
                return statuses[status] || status;
            }
        });
    </script>
@endsection