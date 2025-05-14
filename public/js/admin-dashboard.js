import { insertUserHeader } from './components/user-header.js';
import { notificationsManager } from './components/notifications.js';

document.addEventListener('DOMContentLoaded', function() {
    // Insert user header
    insertUserHeader();

    // Get DOM elements
    const storesCount = document.getElementById('storesCount');
    const pendingStores = document.getElementById('pendingStores');
    const usersCount = document.getElementById('usersCount');
    const merchantCount = document.getElementById('merchantCount');
    const visitorCount = document.getElementById('visitorCount');
    const reportsCount = document.getElementById('reportsCount');
    const pendingReports = document.getElementById('pendingReports');
    const approvalsList = document.getElementById('approvalsList');
    const licenseModal = document.getElementById('licenseModal');
    const closeModal = document.getElementById('closeModal');
    const cancelLicense = document.getElementById('cancelLicense');
    const approveLicense = document.getElementById('approveLicense');
    const rejectLicense = document.getElementById('rejectLicense');

    // Sample stores data
    const sampleStores = [
        {
            id: '1',
            businessNameAr: 'متجر الإلكترونيات الذكية',
            businessNameEn: 'Smart Electronics Store',
            mainCategory: 'إلكترونيات',
            status: 'pending',
            ownerId: 'user1',
            commercialRegistry: true,
            createdAt: '2024-01-20T10:00:00Z',
            logo: 'https://images.pexels.com/photos/356056/pexels-photo-356056.jpeg'
        },
        {
            id: '2',
            businessNameAr: 'أزياء المستقبل',
            businessNameEn: 'Future Fashion',
            mainCategory: 'أزياء وملابس',
            status: 'pending',
            ownerId: 'user2',
            freelanceDoc: true,
            createdAt: '2024-01-19T15:30:00Z',
            logo: 'https://images.pexels.com/photos/994523/pexels-photo-994523.jpeg'
        },
        {
            id: '3',
            businessNameAr: 'مكتبة المعرفة',
            businessNameEn: 'Knowledge Bookstore',
            mainCategory: 'كتب وقرطاسية',
            status: 'active',
            ownerId: 'user3',
            commercialRegistry: true,
            createdAt: '2024-01-18T09:15:00Z',
            logo: 'https://images.pexels.com/photos/256450/pexels-photo-256450.jpeg'
        }
    ];

    // Store sample data in localStorage
    localStorage.setItem('businesses', JSON.stringify(sampleStores));

    // Get data from localStorage
    const stores = JSON.parse(localStorage.getItem('businesses') || '[]');
    const users = JSON.parse(localStorage.getItem('users') || '[]');
    const reports = JSON.parse(localStorage.getItem('reports') || '[]');
    const pendingApprovals = stores.filter(store => 
        store.status === 'pending' && 
        (store.commercialRegistry || store.freelanceDoc)
    );

    let currentStoreId = null;

    // Update stats
    if (storesCount) storesCount.textContent = stores.length;
    if (pendingStores) pendingStores.textContent = `${pendingApprovals.length} في انتظار الموافقة`;
    if (usersCount) usersCount.textContent = users.length;
    if (merchantCount) merchantCount.textContent = `${users.filter(u => u.userType === 'merchant').length} تاجر`;
    if (visitorCount) visitorCount.textContent = `${users.filter(u => u.userType === 'visitor').length} زائر`;
    if (reportsCount) reportsCount.textContent = reports.length;
    if (pendingReports) pendingReports.textContent = `${reports.filter(r => r.status === 'pending').length} بلاغ جديد`;

    // Create approval item
    function createApprovalItem(store) {
        const licenseType = store.commercialRegistry ? 'commercial' : 'freelance';
        const licenseTypeText = licenseType === 'commercial' ? 'سجل تجاري' : 'وثيقة عمل حر';
        
        return `
            <div class="approval-item">
                <div class="store-info">
                    <h3 class="store-name">${store.businessNameAr}</h3>
                    <p class="store-details">
                        نوع العمل: ${store.mainCategory}<br>
                        تاريخ الطلب: ${new Date(store.createdAt).toLocaleDateString('ar-SA')}
                    </p>
                    <span class="license-type ${licenseType}">${licenseTypeText}</span>
                </div>
                <div class="approval-actions">
                    <button class="btn-view" data-store-id="${store.id}">عرض الرخصة</button>
                </div>
            </div>
        `;
    }

    // Display pending approvals
    if (approvalsList) {
        if (pendingApprovals.length === 0) {
            approvalsList.innerHTML = `
                <div class="empty-state">
                    <p>لا توجد طلبات في انتظار الموافقة</p>
                </div>
            `;
        } else {
            approvalsList.innerHTML = pendingApprovals.map(store => createApprovalItem(store)).join('');

            // Add event listeners for view buttons
            document.querySelectorAll('.btn-view').forEach(btn => {
                btn.addEventListener('click', function() {
                    const storeId = this.dataset.storeId;
                    showLicenseModal(storeId);
                });
            });
        }
    }

    // Show license modal
    function showLicenseModal(storeId) {
        const store = stores.find(s => s.id === storeId);
        if (!store) return;

        currentStoreId = storeId;
        
        const licenseStoreName = document.getElementById('licenseStoreName');
        const licenseType = document.getElementById('licenseType');
        const licenseFile = document.getElementById('licenseFile');

        licenseStoreName.textContent = store.businessNameAr;
        licenseType.textContent = store.commercialRegistry ? 'سجل تجاري' : 'وثيقة عمل حر';
        
        // Display license file (in a real app, this would show the actual file)
        licenseFile.innerHTML = `
            <p>ملف الرخصة</p>
            <img src="https://via.placeholder.com/400x300" alt="License">
        `;

        licenseModal.classList.add('active');
    }

    // Close modal handlers
    closeModal?.addEventListener('click', () => licenseModal.classList.remove('active'));
    cancelLicense?.addEventListener('click', () => licenseModal.classList.remove('active'));

    // Handle store approval
    approveLicense?.addEventListener('click', function() {
        if (!currentStoreId) return;

        const storeIndex = stores.findIndex(s => s.id === currentStoreId);
        if (storeIndex === -1) return;

        stores[storeIndex].status = 'active';
        localStorage.setItem('businesses', JSON.stringify(stores));

        // Send notification to store owner
        notificationsManager.addNotification({
            type: 'admin',
            title: 'تم الموافقة على متجرك',
            message: `تم الموافقة على متجر ${stores[storeIndex].businessNameAr}`,
            userId: stores[storeIndex].ownerId
        });

        alert('تم الموافقة على المتجر بنجاح');
        licenseModal.classList.remove('active');
        window.location.reload();
    });

    // Handle store rejection
    rejectLicense?.addEventListener('click', function() {
        if (!currentStoreId) return;

        const storeIndex = stores.findIndex(s => s.id === currentStoreId);
        if (storeIndex === -1) return;

        stores[storeIndex].status = 'rejected';
        localStorage.setItem('businesses', JSON.stringify(stores));

        // Send notification to store owner
        notificationsManager.addNotification({
            type: 'admin',
            title: 'تم رفض متجرك',
            message: `تم رفض متجر ${stores[storeIndex].businessNameAr}`,
            userId: stores[storeIndex].ownerId
        });

        alert('تم رفض المتجر');
        licenseModal.classList.remove('active');
        window.location.reload();
    });
});