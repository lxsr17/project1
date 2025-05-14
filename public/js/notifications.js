// ✅ تعريف كائن الإشعارات
const notificationsManager = {
    notifications: [
        {
            id: 1,
            title: "إشعار إداري",
            message: "تمت الموافقة على متجرك.",
            type: "admin",
            timestamp: new Date().toISOString(),
            unread: true,
            link: "/store-details/1"
        },
        {
            id: 2,
            title: "تقييم جديد",
            message: "تمت إضافة تقييم جديد لمتجرك.",
            type: "reviews",
            timestamp: new Date().toISOString(),
            unread: true
        }
    ],
    getNotifications() {
        return this.notifications;
    },
    getUnreadCount() {
        return this.notifications.filter(n => n.unread).length;
    },
    markAsRead(id) {
        const n = this.notifications.find(n => n.id === id);
        if (n) n.unread = false;
    },
    subscribe(callback) {
        // محاكاة إشعار جديد بعد 10 ثواني
        setTimeout(() => {
            this.notifications.push({
                id: Date.now(),
                title: "إشعار جديد",
                message: "تمت إضافة عنصر جديد",
                type: "admin",
                timestamp: new Date().toISOString(),
                unread: true
            });
            callback();
        }, 10000);
    }
};

// ✅ بقية الكود كما هو
document.addEventListener('DOMContentLoaded', function() {
    // ... الكود حق insertUserHeader إذا احتجته

    const tabButtons = document.querySelectorAll('.tab-btn');
    const notificationList = document.getElementById('notificationList');
    const currentUser = JSON.parse(localStorage.getItem('currentUser') || '{}');

    function formatTime(timestamp) {
        try {
            const date = new Date(timestamp);
            const now = new Date();
            const diff = now - date;
            const minutes = Math.floor(diff / 60000);
            const hours = Math.floor(minutes / 60);
            const days = Math.floor(hours / 24);

            if (minutes < 60) return `منذ ${minutes} دقيقة`;
            if (hours < 24) return `منذ ${hours} ساعة`;
            return `منذ ${days} يوم`;
        } catch {
            return 'منذ قليل';
        }
    }

    function createNotificationElement(notification) {
        let icon = '';
        switch (notification.type) {
            case 'admin': icon = 'https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/bell.svg'; break;
            case 'reviews': icon = 'https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/comment.svg'; break;
            default: icon = 'https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/circle-info.svg';
        }

        return `
            <div class="notification-item ${notification.unread ? 'unread' : ''}" data-id="${notification.id}">
                <div class="notification-header">
                    <div class="notification-icon"><img src="${icon}" alt=""></div>
                    <div class="notification-info">
                        <h3 class="notification-title">${notification.title}</h3>
                        <div class="notification-meta">
                            <span>${formatTime(notification.timestamp)}</span>
                            ${notification.type === 'admin' ? '<span>من الإدارة</span>' : ''}
                        </div>
                    </div>
                </div>
                <div class="notification-content"><p>${notification.message}</p></div>
                <div class="notification-actions">
                    ${notification.unread ? `<button type="button" class="mark-read-btn" data-id="${notification.id}">تحديد كمقروء</button>` : ''}
                    ${notification.link ? `<button type="button" class="view-btn" onclick="window.location.href='${notification.link}'">عرض التفاصيل</button>` : ''}
                </div>
            </div>
        `;
    }

    function displayNotifications(type = 'all') {
        if (!notificationList) return;

        let notifications = notificationsManager.getNotifications().filter(n => {
            return type === 'all' || n.type === type;
        });

        if (notifications.length === 0) {
            notificationList.innerHTML = `<div class="empty-state"><p>لا توجد إشعارات حالياً</p></div>`;
            return;
        }

        notificationList.innerHTML = notifications.map(createNotificationElement).join('');

        document.querySelectorAll('.mark-read-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                notificationsManager.markAsRead(parseInt(btn.dataset.id));
                displayNotifications(getCurrentTab());
            });
        });
    }

    function getCurrentTab() {
        return document.querySelector('.tab-btn.active')?.dataset.tab || 'all';
    }

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            tabButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            displayNotifications(button.dataset.tab);
        });
    });

    notificationsManager.subscribe(() => {
        displayNotifications(getCurrentTab());
    });

    displayNotifications();
});
