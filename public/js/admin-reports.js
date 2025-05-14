import { insertUserHeader } from './components/user-header.js';
import { notificationsManager } from './components/notifications.js';

document.addEventListener('DOMContentLoaded', function() {
    // Insert user header
    insertUserHeader();

    // Get DOM elements
    const searchInput = document.getElementById('searchInput');
    const reportTypeFilter = document.getElementById('reportTypeFilter');
    const statusFilter = document.getElementById('statusFilter');
    const dateFilter = document.getElementById('dateFilter');
    const reportsTableBody = document.getElementById('reportsTableBody');
    const reportDetailsModal = document.getElementById('reportDetailsModal');
    const actionModal = document.getElementById('actionModal');
    const closeDetailsModal = document.getElementById('closeDetailsModal');
    const closeDetails = document.getElementById('closeDetails');
    const closeActionModal = document.getElementById('closeActionModal');
    const cancelAction = document.getElementById('cancelAction');
    const takeAction = document.getElementById('takeAction');
    const updateStatus = document.getElementById('updateStatus');
    const reportStatus = document.getElementById('reportStatus');

    // Sample reports data
    const sampleReports = [
        {
            id: '1',
            type: 'store',
            reporterId: 'user2',
            entityId: '2',
            date: '2024-01-20T10:00:00Z',
            status: 'new',
            description: 'المتجر يقوم ببيع منتجات مقلدة وغير أصلية',
            history: []
        },
        {
            id: '2',
            type: 'user',
            reporterId: 'user4',
            entityId: 'user3',
            date: '2024-01-19T15:30:00Z',
            status: 'inProgress',
            description: 'المستخدم يقوم بنشر تعليقات مسيئة',
            history: [
                {
                    date: '2024-01-19T16:00:00Z',
                    action: 'تم تغيير حالة البلاغ من "جديد" إلى "قيد المراجعة"'
                }
            ]
        },
        {
            id: '3',
            type: 'store',
            reporterId: 'user1',
            entityId: '5',
            date: '2024-01-18T09:15:00Z',
            status: 'closed',
            description: 'المتجر لا يقوم بالرد على الطلبات ولا يقوم بالتوصيل',
            history: [
                {
                    date: '2024-01-18T10:00:00Z',
                    action: 'تم تغيير حالة البلاغ من "جديد" إلى "قيد المراجعة"'
                },
                {
                    date: '2024-01-18T14:30:00Z',
                    action: 'تم إرسال تحذير إلى "عطور الشرق"'
                },
                {
                    date: '2024-01-18T15:00:00Z',
                    action: 'تم تغيير حالة البلاغ من "قيد المراجعة" إلى "مغلق"'
                }
            ]
        },
        {
            id: '4',
            type: 'product',
            reporterId: 'user5',
            entityId: '1',
            date: '2024-01-17T13:45:00Z',
            status: 'new',
            description: 'المنتج غير مطابق للمواصفات المذكورة في الوصف',
            history: []
        },
        {
            id: '5',
            type: 'review',
            reporterId: 'user3',
            entityId: '4',
            date: '2024-01-16T11:20:00Z',
            status: 'closed',
            description: 'تقييم وهمي وغير حقيقي للمتجر',
            history: [
                {
                    date: '2024-01-16T12:00:00Z',
                    action: 'تم حذف التقييم المخالف'
                },
                {
                    date: '2024-01-16T12:30:00Z',
                    action: 'تم تغيير حالة البلاغ من "جديد" إلى "مغلق"'
                }
            ]
        }
    ];

    // Store sample data in localStorage
    localStorage.setItem('reports', JSON.stringify(sampleReports));

    // Get reports from localStorage
    let reports = JSON.parse(localStorage.getItem('reports') || '[]');
    const users = JSON.parse(localStorage.getItem('users') || '[]');
    const stores = JSON.parse(localStorage.getItem('businesses') || '[]');

    let currentReportId = null;

    function getReportTypeName(type) {
        const types = {
            store: 'متجر',
            user: 'مستخدم',
            product: 'منتج',
            review: 'تقييم'
        };
        return types[type] || type;
    }

    function getStatusName(status) {
        const statuses = {
            new: 'جديد',
            inProgress: 'قيد المراجعة',
            closed: 'مغلق'
        };
        return statuses[status] || status;
    }

    function getReportedEntity(report) {
        switch (report.type) {
            case 'store':
                const store = stores.find(s => s.id === report.entityId);
                return {
                    name: store ? store.businessNameAr : '-',
                    type: 'متجر'
                };
            case 'user':
                const user = users.find(u => u.id === report.entityId);
                return {
                    name: user ? `${user.firstName} ${user.lastName}` : '-',
                    type: 'مستخدم'
                };
            default:
                return {
                    name: '-',
                    type: getReportTypeName(report.type)
                };
        }
    }

    function createReportRow(report) {
        const reporter = users.find(u => u.id === report.reporterId);
        const reportedEntity = getReportedEntity(report);
        const date = new Date(report.date).toLocaleDateString('ar-SA');
        
        return `
            <tr>
                <td>#${report.id}</td>
                <td>
                    <span class="report-type ${report.type}">
                        ${getReportTypeName(report.type)}
                    </span>
                </td>
                <td>${reporter ? `${reporter.firstName} ${reporter.lastName}` : '-'}</td>
                <td>${reportedEntity.name}</td>
                <td>${date}</td>
                <td>
                    <span class="report-status ${report.status}">
                        ${getStatusName(report.status)}
                    </span>
                </td>
                <td>
                    <div class="actions">
                        <button class="action-btn view-btn" title="عرض التفاصيل" data-report-id="${report.id}">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/eye.svg" alt="View">
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }

    function displayReports(filteredReports = reports) {
        if (!reportsTableBody) return;

        if (filteredReports.length === 0) {
            reportsTableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center">لا يوجد بلاغات</td>
                </tr>
            `;
            return;
        }

        reportsTableBody.innerHTML = filteredReports.map(report => createReportRow(report)).join('');

        // Add event listeners for view buttons
        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', () => showReportDetails(btn.dataset.reportId));
        });
    }

    function filterReports() {
        const searchTerm = searchInput.value.toLowerCase();
        const type = reportTypeFilter.value;
        const status = statusFilter.value;
        const date = dateFilter.value;

        let filteredReports = reports.filter(report => {
            const reportedEntity = getReportedEntity(report);
            const matchesSearch = reportedEntity.name.toLowerCase().includes(searchTerm);
            const matchesType = !type || report.type === type;
            const matchesStatus = !status || report.status === status;

            if (!date) return matchesSearch && matchesType && matchesStatus;

            const reportDate = new Date(report.date);
            const now = new Date();
            
            switch (date) {
                case 'today':
                    return reportDate.toDateString() === now.toDateString() &&
                           matchesSearch && matchesType && matchesStatus;
                case 'week':
                    const weekAgo = new Date(now - 7 * 24 * 60 * 60 * 1000);
                    return reportDate >= weekAgo &&
                           matchesSearch && matchesType && matchesStatus;
                case 'month':
                    const monthAgo = new Date(now - 30 * 24 * 60 * 60 * 1000);
                    return reportDate >= monthAgo &&
                           matchesSearch && matchesType && matchesStatus;
                default:
                    return matchesSearch && matchesType && matchesStatus;
            }
        });

        displayReports(filteredReports);
    }

    function showReportDetails(reportId) {
        const report = reports.find(r => r.id === reportId);
        if (!report) return;

        currentReportId = reportId;
        const reporter = users.find(u => u.id === report.reporterId);
        const reportedEntity = getReportedEntity(report);

        const reportDetailsContent = document.getElementById('reportDetailsContent');
        reportDetailsContent.innerHTML = `
            <div class="detail-group">
                <h3>تفاصيل البلاغ</h3>
                <p>رقم البلاغ: #${report.id}</p>
                <p>نوع البلاغ: ${getReportTypeName(report.type)}</p>
                <p>تاريخ البلاغ: ${new Date(report.date).toLocaleDateString('ar-SA')}</p>
                <p>الحالة: ${getStatusName(report.status)}</p>
            </div>
            <div class="detail-group">
                <h3>المُبلغ</h3>
                <p>الاسم: ${reporter ? `${reporter.firstName} ${reporter.lastName}` : '-'}</p>
                <p>البريد الإلكتروني: ${reporter ? reporter.email : '-'}</p>
            </div>
            <div class="detail-group">
                <h3>المُبلغ عنه</h3>
                <p>النوع: ${reportedEntity.type}</p>
                <p>الاسم: ${reportedEntity.name}</p>
            </div>
            <div class="detail-group">
                <h3>وصف البلاغ</h3>
                <div class="report-description">${report.description}</div>
            </div>
            <div class="report-history">
                <h3>سجل الإجراءات</h3>
                ${report.history ? report.history.map(item => `
                    <div class="history-item">
                        <div class="history-date">${new Date(item.date).toLocaleDateString('ar-SA')}</div>
                        <div class="history-action">${item.action}</div>
                    </div>
                `).join('') : '<p>لا يوجد إجراءات سابقة</p>'}
            </div>
        `;

        reportStatus.value = report.status;
        reportDetailsModal.classList.add('active');
    }

    function showActionModal() {
        actionModal.classList.add('active');
    }

    function updateReportStatus() {
        if (!currentReportId) return;

        const reportIndex = reports.findIndex(r => r.id === currentReportId);
        if (reportIndex === -1) return;

        const newStatus = reportStatus.value;
        const oldStatus = reports[reportIndex].status;

        if (newStatus === oldStatus) return;

        reports[reportIndex].status = newStatus;
        if (!reports[reportIndex].history) {
            reports[reportIndex].history = [];
        }
        reports[reportIndex].history.push({
            date: new Date().toISOString(),
            action: `تم تغيير حالة البلاغ من "${getStatusName(oldStatus)}" إلى "${getStatusName(newStatus)}"`
        });

        localStorage.setItem('reports', JSON.stringify(reports));
        displayReports();
        reportDetailsModal.classList.remove('active');
    }

    // Event listeners
    searchInput?.addEventListener('input', filterReports);
    reportTypeFilter?.addEventListener('change', filterReports);
    statusFilter?.addEventListener('change', filterReports);
    dateFilter?.addEventListener('change', filterReports);

    // Close modals
    closeDetailsModal?.addEventListener('click', () => reportDetailsModal.classList.remove('active'));
    closeDetails?.addEventListener('click', () => reportDetailsModal.classList.remove('active'));
    closeActionModal?.addEventListener('click', () => actionModal.classList.remove('active'));
    cancelAction?.addEventListener('click', () => actionModal.classList.remove('active'));

    // Take action button
    takeAction?.addEventListener('click', showActionModal);

    // Update status button
    updateStatus?.addEventListener('click', updateReportStatus);

    // Action buttons
    document.querySelectorAll('.action-options .action-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (!currentReportId) return;

            const reportIndex = reports.findIndex(r => r.id === currentReportId);
            if (reportIndex === -1) return;

            const report = reports[reportIndex];
            const reportedEntity = getReportedEntity(report);
            let action = '';

            if (this.classList.contains('suspend-btn')) {
                if (report.type === 'store') {
                    const storeIndex = stores.findIndex(s => s.id === report.entityId);
                    if (storeIndex !== -1) {
                        stores[storeIndex].status = 'suspended';
                        localStorage.setItem('businesses', JSON.stringify(stores));
                        action = `تم إيقاف المتجر "${reportedEntity.name}"`;
                    }
                } else if (report.type === 'user') {
                    const userIndex = users.findIndex(u => u.id === report.entityId);
                    if (userIndex !== -1) {
                        users[userIndex].status = 'suspended';
                        localStorage.setItem('users', JSON.stringify(users));
                        action = `تم إيقاف المستخدم "${reportedEntity.name}"`;
                    }
                }
            } else if (this.classList.contains('warning-btn')) {
                notificationsManager.addNotification({
                    type: 'admin',
                    title: 'تحذير من الإدارة',
                    message: 'تم الإبلاغ عن مخالفة في المحتوى الخاص بك. يرجى مراجعة المحتوى وتصحيحه.',
                    userId: report.entityId
                });
                action = `تم إرسال تحذير إلى "${reportedEntity.name}"`;
            } else if (this.classList.contains('delete-btn')) {
                action = `تم حذف المحتوى المخالف`;
            }

            if (action) {
                if (!reports[reportIndex].history) {
                    reports[reportIndex].history = [];
                }
                reports[reportIndex].history.push({
                    date: new Date().toISOString(),
                    action
                });
                reports[reportIndex].status = 'closed';
                localStorage.setItem('reports', JSON.stringify(reports));
            }

            actionModal.classList.remove('active');
            reportDetailsModal.classList.remove('active');
            displayReports();
        });
    });

    // Initialize reports display
    displayReports();
});