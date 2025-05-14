import { insertUserHeader } from './components/user-header.js';
import { notificationsManager } from './components/notifications.js';

document.addEventListener('DOMContentLoaded', function() {
    // Insert user header
    insertUserHeader();

    // Get DOM elements
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const statusFilter = document.getElementById('statusFilter');
    const storesTableBody = document.getElementById('storesTableBody');
    const storeDetailsModal = document.getElementById('storeDetailsModal');
    const notificationModal = document.getElementById('notificationModal');
    const notificationForm = document.getElementById('notificationForm');
    const closeDetailsModal = document.getElementById('closeDetailsModal');
    const closeDetails = document.getElementById('closeDetails');
    const closeNotificationModal = document.getElementById('closeNotificationModal');
    const cancelNotification = document.getElementById('cancelNotification');

    // Sample stores data
    const sampleStores = [
        {
            id: '1',
            businessNameAr: 'متجر الإلكترونيات الذكية',
            businessNameEn: 'Smart Electronics Store',
            mainCategory: 'إلكترونيات',
            status: 'active',
            ownerId: 'user1',
            rating: 4.8,
            ratingCount: 156,
            logo: 'https://images.pexels.com/photos/356056/pexels-photo-356056.jpeg'
        },
        {
            id: '2',
            businessNameAr: 'أزياء المستقبل',
            businessNameEn: 'Future Fashion',
            mainCategory: 'أزياء وملابس',
            status: 'suspended',
            ownerId: 'user2',
            rating: 3.5,
            ratingCount: 89,
            logo: 'https://images.pexels.com/photos/994523/pexels-photo-994523.jpeg'
        },
        {
            id: '3',
            businessNameAr: 'مكتبة المعرفة',
            businessNameEn: 'Knowledge Bookstore',
            mainCategory: 'كتب وقرطاسية',
            status: 'active',
            ownerId: 'user3',
            rating: 4.9,
            ratingCount: 234,
            logo: 'https://images.pexels.com/photos/256450/pexels-photo-256450.jpeg'
        },
        {
            id: '4',
            businessNameAr: 'متجر الهدايا الفريدة',
            businessNameEn: 'Unique Gifts Store',
            mainCategory: 'هدايا',
            status: 'active',
            ownerId: 'user4',
            rating: 4.7,
            ratingCount: 178,
            logo: 'https://images.pexels.com/photos/264507/pexels-photo-264507.jpeg'
        },
        {
            id: '5',
            businessNameAr: 'عطور الشرق',
            businessNameEn: 'Oriental Perfumes',
            mainCategory: 'عطور',
            status: 'suspended',
            ownerId: 'user5',
            rating: 3.2,
            ratingCount: 45,
            logo: 'https://images.pexels.com/photos/965989/pexels-photo-965989.jpeg'
        }
    ];

    // Store sample data in localStorage
    localStorage.setItem('businesses', JSON.stringify(sampleStores));

    // Get stores from localStorage
    let stores = JSON.parse(localStorage.getItem('businesses') || '[]');
    const users = JSON.parse(localStorage.getItem('users') || '[]');

    function createStoreRow(store) {
        const owner = users.find(u => u.id === store.ownerId);
        const stars = '★'.repeat(Math.floor(store.rating || 0)) + '☆'.repeat(5 - Math.floor(store.rating || 0));
        
        return `
            <tr>
                <td>
                    <div class="store-info">
                        <div class="store-logo">
                            <img src="${store.logo || 'https://via.placeholder.com/40'}" alt="${store.businessNameAr}">
                        </div>
                        <span class="store-name">${store.businessNameAr}</span>
                    </div>
                </td>
                <td>${owner ? `${owner.firstName} ${owner.lastName}` : '-'}</td>
                <td>${store.mainCategory}</td>
                <td>
                    <span class="store-status ${store.status || 'active'}">
                        ${store.status === 'suspended' ? 'موقوف' : 
                          store.status === 'pending' ? 'في انتظار الموافقة' : 'نشط'}
                    </span>
                </td>
                <td>
                    <div class="store-rating">
                        <span class="stars">${stars}</span>
                        <span class="rating-count">(${store.ratingCount || 0})</span>
                    </div>
                </td>
                <td>
                    <div class="actions">
                        <button class="action-btn view-btn" title="عرض التفاصيل" data-store-id="${store.id}">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/eye.svg" alt="View">
                        </button>
                        <button class="action-btn notify-btn" title="إرسال تنبيه" data-store-id="${store.id}">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/bell.svg" alt="Notify">
                        </button>
                        <button class="action-btn suspend-btn" title="${store.status === 'suspended' ? 'إلغاء الإيقاف' : 'إيقاف'}" data-store-id="${store.id}">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/ban.svg" alt="Suspend">
                        </button>
                        <button class="action-btn delete-btn" title="حذف" data-store-id="${store.id}">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/trash.svg" alt="Delete">
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }

    function displayStores(filteredStores = stores) {
        if (!storesTableBody) return;

        if (filteredStores.length === 0) {
            storesTableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center">لا يوجد متاجر</td>
                </tr>
            `;
            return;
        }

        storesTableBody.innerHTML = filteredStores.map(store => createStoreRow(store)).join('');

        // Add event listeners for action buttons
        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', () => showStoreDetails(btn.dataset.storeId));
        });

        document.querySelectorAll('.notify-btn').forEach(btn => {
            btn.addEventListener('click', () => showNotificationModal(btn.dataset.storeId));
        });

        document.querySelectorAll('.suspend-btn').forEach(btn => {
            btn.addEventListener('click', () => toggleStoreSuspension(btn.dataset.storeId));
        });

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', () => deleteStore(btn.dataset.storeId));
        });
    }

    function filterStores() {
        const searchTerm = searchInput.value.toLowerCase();
        const category = categoryFilter.value;
        const status = statusFilter.value;

        const filteredStores = stores.filter(store => {
            const matchesSearch = 
                store.businessNameAr.toLowerCase().includes(searchTerm) ||
                store.businessNameEn?.toLowerCase().includes(searchTerm);
            
            const matchesCategory = !category || store.mainCategory === category;
            const matchesStatus = !status || (store.status || 'active') === status;

            return matchesSearch && matchesCategory && matchesStatus;
        });

        displayStores(filteredStores);
    }

    function showStoreDetails(storeId) {
        const store = stores.find(s => s.id === storeId);
        if (!store) return;

        const owner = users.find(u => u.id === store.ownerId);

        const storeDetailsContent = document.getElementById('storeDetailsContent');
        storeDetailsContent.innerHTML = `
            <div class="detail-group">
                <h3>معلومات المتجر</h3>
                <p>الاسم: ${store.businessNameAr}</p>
                <p>التصنيف: ${store.mainCategory}</p>
                <p>الحالة: ${store.status === 'suspended' ? 'موقوف' : 
                            store.status === 'pending' ? 'في انتظار الموافقة' : 'نشط'}</p>
                <p>التقييم: ${store.rating || 0} (${store.ratingCount || 0} تقييم)</p>
                <div class="owner-info">
                    <h4>معلومات صاحب المتجر</h4>
                    <p>الاسم: ${owner ? `${owner.firstName} ${owner.lastName}` : '-'}</p>
                    <p>البريد الإلكتروني: ${owner ? owner.email : '-'}</p>
                    <p>رقم الجوال: ${owner ? owner.phone : '-'}</p>
                </div>
            </div>
        `;

        storeDetailsModal.classList.add('active');
    }

    function showNotificationModal(storeId) {
        const store = stores.find(s => s.id === storeId);
        if (!store) return;

        document.getElementById('notificationStoreId').value = storeId;
        notificationModal.classList.add('active');
    }

    function toggleStoreSuspension(storeId) {
        const storeIndex = stores.findIndex(s => s.id === storeId);
        if (storeIndex === -1) return;

        const newStatus = stores[storeIndex].status === 'suspended' ? 'active' : 'suspended';
        const actionText = newStatus === 'suspended' ? 'إيقاف' : 'إلغاء إيقاف';

        if (confirm(`هل أنت متأكد من ${actionText} هذا المتجر؟`)) {
            stores[storeIndex].status = newStatus;
            localStorage.setItem('businesses', JSON.stringify(stores));

            // Send notification to store owner
            notificationsManager.addNotification({
                type: 'admin',
                title: `تم ${actionText} متجرك`,
                message: `تم ${actionText} متجر ${stores[storeIndex].businessNameAr} من قبل الإدارة`,
                userId: stores[storeIndex].ownerId
            });

            displayStores();
        }
    }

    function deleteStore(storeId) {
        if (confirm('هل أنت متأكد من حذف هذا المتجر؟')) {
            const storeIndex = stores.findIndex(s => s.id === storeId);
            if (storeIndex === -1) return;

            // Send notification to store owner
            notificationsManager.addNotification({
                type: 'admin',
                title: 'تم حذف متجرك',
                message: `تم حذف متجر ${stores[storeIndex].businessNameAr} من قبل الإدارة`,
                userId: stores[storeIndex].ownerId
            });

            stores = stores.filter(s => s.id !== storeId);
            localStorage.setItem('businesses', JSON.stringify(stores));
            displayStores();
        }
    }

    // Event listeners
    searchInput?.addEventListener('input', filterStores);
    categoryFilter?.addEventListener('change', filterStores);
    statusFilter?.addEventListener('change', filterStores);

    // Close modals
    closeDetailsModal?.addEventListener('click', () => storeDetailsModal.classList.remove('active'));
    closeDetails?.addEventListener('click', () => storeDetailsModal.classList.remove('active'));
    closeNotificationModal?.addEventListener('click', () => notificationModal.classList.remove('active'));
    cancelNotification?.addEventListener('click', () => notificationModal.classList.remove('active'));

    // Handle notification form submission
    notificationForm?.addEventListener('submit', (e) => {
        e.preventDefault();

        const storeId = document.getElementById('notificationStoreId').value;
        const store = stores.find(s => s.id === storeId);
        if (!store) return;

        const title = document.getElementById('notificationTitle').value;
        const message = document.getElementById('notificationMessage').value;

        notificationsManager.addNotification({
            type: 'admin',
            title,
            message,
            userId: store.ownerId
        });

        alert('تم إرسال التنبيه بنجاح');
        notificationModal.classList.remove('active');
        notificationForm.reset();
    });


    // إرسال الإشعار عند إرسال الفورم
notificationForm?.addEventListener('submit', function(e) {
    e.preventDefault();

    const storeId = document.getElementById('notificationStoreId').value;
    const title = document.getElementById('notificationTitle').value;
    const message = document.getElementById('notificationMessage').value;

    fetch('/admin/notifications', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            title: title,
            message: message,
            type: 'admin',
            target: 'specific',
            user_id: storeId
        })
    })
    .then(res => {
        if (!res.ok) throw new Error('فشل الحفظ');
        return res.json();
    })
    .then(() => {
        alert('✅ تم إرسال الإشعار بنجاح');
        notificationModal.classList.remove('active');
        notificationForm.reset();
    })
    .catch(err => {
        console.error(err);
        alert('❌ حدث خطأ أثناء الإرسال');
    });
});

    // Initialize stores display
    displayStores();
});