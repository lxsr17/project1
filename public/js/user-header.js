import { Modal } from './modal.js';
import { notificationsManager } from './notifications.js';

document.addEventListener('DOMContentLoaded', () => {
    initializeHeader();
    initializeNotifications();
    updateNotificationsBadge();
    notificationsManager.subscribe(updateNotificationsBadge);
});

function initializeHeader() {
    const userInfoContainer = document.getElementById('userInfoContainer');
    const userDropdown = document.getElementById('userDropdown');
    const logoutBtn = document.getElementById('logoutBtn');
    const deleteAccountBtn = document.getElementById('deleteAccount');

    // ⬇️ فتح القائمة المنسدلة
    userInfoContainer?.addEventListener('click', function (e) {
        e.stopPropagation();
        userDropdown?.classList.toggle('active');
    });

    // ⬇️ إغلاقها عند الضغط خارجها
    document.addEventListener('click', function (e) {
        if (!userInfoContainer?.contains(e.target)) {
            userDropdown?.classList.remove('active');
        }
    });

    // ⬇️ تسجيل الخروج
    logoutBtn?.addEventListener('click', function (e) {
        e.preventDefault();
        if (confirm('هل أنت متأكد من تسجيل الخروج؟')) {
            localStorage.clear();
            window.location.href = '/index';  
        }
    });

    // ⬇️ حذف الحساب
    deleteAccountBtn?.addEventListener('click', function (e) {
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
        const unreadCount = notificationsManager.getUnreadCount();
        badge.style.display = unreadCount > 0 ? 'block' : 'none';
    }
}

function initializeNotifications() {
    const notificationsIcon = document.getElementById('notificationsIcon');
    const notificationsModal = new Modal({
        closeOnClickOutside: true,
        closeOnEscape: true
    });

    notificationsIcon?.addEventListener('click', function () {
        const notifications = notificationsManager.getNotifications('all', 3);
        const content = document.createElement('div');
        content.className = 'notifications-preview';

        if (notifications.length === 0) {
            content.innerHTML = `
                <h3 class="modal-title">الإشعارات</h3>
                <div class="empty-state">لا توجد إشعارات حالياً</div>
                <div class="modal-footer">
                    <a href="/notifications" class="btn btn-primary">عرض كل الإشعارات</a>
                </div>
            `;
        } else {
            content.innerHTML = `
                <h3 class="modal-title">الإشعارات</h3>
                <div class="notifications-list">
                    ${notifications.map(notification => `
                        <div class="notification-item ${notification.unread ? 'unread' : ''}" data-id="${notification.id}">
                            <div class="notification-icon">
                                <img src="${notification.icon}" alt="">
                            </div>
                            <div class="notification-content">
                                <h4>${notification.title}</h4>
                                <p>${notification.message}</p>
                            </div>
                        </div>
                    `).join('')}
                </div>
                <div class="modal-footer">
                    <a href="/notifications.html" class="btn btn-primary">عرض كل الإشعارات</a>
                </div>
            `;

            content.querySelectorAll('.notification-item').forEach(item => {
                item.addEventListener('click', () => {
                    const id = parseInt(item.dataset.id);
                    notificationsManager.markAsRead(id);
                    window.location.href = '/notifications';
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const userInfo = document.getElementById('userInfoContainer');
            const dropdown = document.getElementById('userDropdown');
        
            if (userInfo && dropdown) {
                userInfo.addEventListener('click', function (e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('active');
                });
        
                document.addEventListener('click', function (e) {
                    if (!userInfo.contains(e.target)) {
                        dropdown.classList.remove('active');
                    }
                });
            }
        });
        document.addEventListener('DOMContentLoaded', function () {
            const userInfo = document.getElementById('userInfoContainer');
            const dropdown = document.getElementById('userDropdown');
        
            if (userInfo && dropdown) {
                userInfo.addEventListener('click', function (e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('active');
                });
        
                document.addEventListener('click', function (e) {
                    if (!userInfo.contains(e.target)) {
                        dropdown.classList.remove('active');
                    }
                });
            }
        });
        

        notificationsModal.setContent(content).open();
    });
}
