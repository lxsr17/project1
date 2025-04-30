import { insertUserHeader } from './components/user-header.js';
import { notificationsManager } from './components/notifications.js';

document.addEventListener('DOMContentLoaded', function() {
    // Insert user header
    insertUserHeader();

    const tabButtons = document.querySelectorAll('.tab-btn');
    const notificationList = document.getElementById('notificationList');
    const currentUser = JSON.parse(localStorage.getItem('currentUser') || '{}');

    function formatTime(timestamp) {
        try {
            const date = new Date(timestamp);
            if (isNaN(date.getTime())) {
                return 'منذ قليل';
            }
            
            const now = new Date();
            const diff = now - date;
            const minutes = Math.floor(diff / 60000);
            const hours = Math.floor(minutes / 60);
            const days = Math.floor(hours / 24);

            if (minutes < 60) {
                return `منذ ${minutes} دقيقة`;
            } else if (hours < 24) {
                return `منذ ${hours} ساعة`;
            } else {
                return `منذ ${days} يوم`;
            }
        } catch (error) {
            console.error('Error formatting date:', error);
            return 'منذ قليل';
        }
    }

    function createNotificationElement(notification) {
        let icon = '';
        switch (notification.type) {
            case 'admin':
                icon = 'https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/bell.svg';
                break;
            case 'reviews':
                icon = 'https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/comment.svg';
                break;
            default:
                icon = 'https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/circle-info.svg';
        }

        return `
            <div class="notification-item ${notification.unread ? 'unread' : ''}" data-id="${notification.id}">
                <div class="notification-header">
                    <div class="notification-icon">
                        <img src="${icon}" alt="">
                    </div>
                    <div class="notification-info">
                        <h3 class="notification-title">${notification.title}</h3>
                        <div class="notification-meta">
                            <span>${formatTime(notification.timestamp)}</span>
                            ${notification.type === 'admin' ? '<span>من الإدارة</span>' : ''}
                        </div>
                    </div>
                </div>
                <div class="notification-content">
                    <p>${notification.message}</p>
                </div>
                <div class="notification-actions">
                    ${notification.unread ? `
                        <button type="button" class="mark-read-btn" data-id="${notification.id}">
                            تحديد كمقروء
                        </button>
                    ` : ''}
                    ${notification.link ? `
                        <button type="button" class="view-btn" onclick="window.location.href='${notification.link}'">
                            عرض التفاصيل
                        </button>
                    ` : ''}
                </div>
            </div>
        `;
    }

    function displayNotifications(type = 'all') {
        if (!notificationList) return;

        // Get notifications based on user type and filter
        let notifications = notificationsManager.getNotifications();

        // Filter notifications based on user type and tab
        notifications = notifications.filter(notification => {
            if (type === 'all') return true;
            return notification.type === type;
        });

        if (notifications.length === 0) {
            notificationList.innerHTML = `
                <div class="empty-state">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/bell-slash.svg" alt="">
                    <p>لا توجد إشعارات حالياً</p>
                </div>
            `;
            return;
        }

        notificationList.innerHTML = notifications
            .map(notification => createNotificationElement(notification))
            .join('');

        // Add click handlers for mark as read buttons
        document.querySelectorAll('.mark-read-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = parseInt(btn.dataset.id);
                notificationsManager.markAsRead(id);
                displayNotifications(getCurrentTab());
            });
        });
    }

    function getCurrentTab() {
        return document.querySelector('.tab-btn.active')?.dataset.tab || 'all';
    }

    // Handle tab clicks
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            tabButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            displayNotifications(button.dataset.tab);
        });
    });

    // Subscribe to notifications changes
    notificationsManager.subscribe(() => {
        displayNotifications(getCurrentTab());
    });

    // Initialize notifications display
    displayNotifications();
});