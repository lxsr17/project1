import { notificationsManager } from './notifications.js';

document.addEventListener('DOMContentLoaded', () => {
    initializeHeader();
    initializeNotifications();
    updateNotificationsBadge();
    notificationsManager.subscribe(updateNotificationsBadge);
});

function initializeHeader() {
    const userInfo = document.getElementById('userInfoContainer');
    const dropdown = document.getElementById('userDropdown');
    const logoutBtn = document.getElementById('logoutBtn');
    const deleteBtn = document.getElementById('deleteAccount');

    userInfo?.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdown?.classList.toggle('active');
    });

    document.addEventListener('click', (e) => {
        if (!userInfo?.contains(e.target)) {
            dropdown?.classList.remove('active');
        }
    });

    logoutBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        if (confirm('هل أنت متأكد من تسجيل الخروج؟')) {
            localStorage.clear();
            window.location.href = '/index';
        }
    });

    deleteBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        if (confirm('هل أنت متأكد من حذف حسابك؟ هذا الإجراء لا يمكن التراجع عنه.')) {
            localStorage.clear();
            alert('تم حذف الحساب.');
            window.location.href = '/';
        }
    });


    
}

function updateNotificationsBadge() {
    const badge = document.querySelector('.notifications-badge');
    if (badge) {
        const unread = notificationsManager.getUnreadCount();
        badge.textContent = unread > 0 ? unread : '';
        badge.style.display = unread > 0 ? 'flex' : 'none';
    }
}

function initializeNotifications() {
    const icon = document.getElementById('notificationsIcon');
    const modal = document.getElementById('notificationsModal');
    const close = document.getElementById('closeNotificationsModal');
    const listContainer = modal?.querySelector('.notifications-list');

    icon?.addEventListener('click', () => {
        icon?.addEventListener('click', async () => {
            if (!modal || !listContainer) return;
        
            listContainer.innerHTML = '<div class="loading-state">جاري التحميل...</div>';
        
            try {
                const response = await fetch('/notifications/fetch');
                if (!response.ok) throw new Error('فشل التحميل');
                const notifications = await response.json();
        
                listContainer.innerHTML = '';
        
                if (notifications.length === 0) {
                    listContainer.innerHTML = `
                        <div class="empty-state">لا توجد إشعارات حالياً</div>
                    `;
                } else {
                    listContainer.innerHTML = notifications.map(n => `
                        <div class="notification-item ${n.read_at ? '' : 'unread'}" data-id="${n.id}">
                            <div class="notification-icon">
                                <img src="${n.icon || '/images/bell.svg'}" alt="">
                            </div>
                            <div class="notification-content">
                                <h4>${n.title}</h4>
                                <p>${n.message}</p>
                            </div>
                        </div>
                    `).join('');
                }
        
                modal.classList.add('active');
            } catch (error) {
                listContainer.innerHTML = '<div class="error-state">حدث خطأ أثناء تحميل الإشعارات.</div>';
            }
        });
        
        if (!modal || !listContainer) return;

        listContainer.innerHTML = '';

        if (notifications.length === 0) {
            listContainer.innerHTML = `
                <div class="empty-state">لا توجد إشعارات حالياً</div>
            `;
        } else {
            listContainer.innerHTML = notifications.map(n => `
                <div class="notification-item ${n.unread ? 'unread' : ''}" data-id="${n.id}">
                    <div class="notification-icon">
                        <img src="${n.icon || '/images/bell.svg'}" alt="">
                    </div>
                    <div class="notification-content">
                        <h4>${n.title}</h4>
                        <p>${n.message}</p>
                    </div>
                </div>
            `).join('');
        }

        modal.classList.add('active');
    });

    close?.addEventListener('click', () => {
        modal?.classList.remove('active');
    });
}
