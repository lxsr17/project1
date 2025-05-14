import { insertUserHeader } from './components/user-header.js';
import { notificationsManager } from './components/notifications.js';

document.addEventListener('DOMContentLoaded', function() {
    // Insert user header
    insertUserHeader();

    // Get DOM elements
    const searchInput = document.getElementById('searchInput');
    const targetFilter = document.getElementById('targetFilter');
    const typeFilter = document.getElementById('typeFilter');
    const dateFilter = document.getElementById('dateFilter');
    const notificationsList = document.getElementById('notificationsList');
    const createNotificationBtn = document.getElementById('createNotificationBtn');
    const notificationModal = document.getElementById('notificationModal');
    const notificationForm = document.getElementById('notificationForm');
    const closeModal = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const notificationTarget = document.getElementById('notificationTarget');
    const specificUserGroup = document.getElementById('specificUserGroup');
    const specificUser = document.getElementById('specificUser');

   
    // Store sample data in localStorage
    localStorage.setItem('admin_notifications', JSON.stringify(sampleNotifications));

    // Get notifications from localStorage
    let notifications = JSON.parse(localStorage.getItem('admin_notifications') || '[]');
    const users = JSON.parse(localStorage.getItem('users') || '[]');

    // Populate users dropdown
    function populateUsersDropdown() {
        if (!specificUser) return;

        specificUser.innerHTML = '<option value="">اختر المستخدم</option>';
        users.forEach(user => {
            specificUser.innerHTML += `
                <option value="${user.id}">
                    ${user.firstName} ${user.lastName} (${user.email})
                </option>
            `;
        });
    }

    function getNotificationTypeName(type) {
        const types = {
            alert: 'تنبيه',
            announcement: 'إعلان',
            warning: 'تحذير'
        };
        return types[type] || type;
    }

    function getTargetName(target, userId) {
        if (target === 'specific' && userId) {
            const user = users.find(u => u.id === userId);
            return user ? `${user.firstName} ${user.lastName}` : 'مستخدم محدد';
        }

        const targets = {
            all: 'الكل',
            merchant: 'التجار',
            visitor: 'الزوار'
        };
        return targets[target] || target;
    }

    function createNotificationItem(notification) {
        const date = new Date(notification.date).toLocaleDateString('ar-SA');
        
        return `
            <div class="notification-item" data-id="${notification.id}">
                <div class="notification-header">
                    <div class="notification-info">
                        <h3 class="notification-title">${notification.title}</h3>
                        <div class="notification-meta">
                            <span class="notification-type ${notification.type}">
                                ${getNotificationTypeName(notification.type)}
                            </span>
                            <span class="notification-target">
                                ${getTargetName(notification.target, notification.userId)}
                            </span>
                            <span class="notification-date">${date}</span>
                        </div>
                    </div>
                    <div class="notification-actions">
                        <button class="action-btn edit-btn" title="تعديل" data-id="${notification.id}">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/pen.svg" alt="Edit">
                        </button>
                        <button class="action-btn delete-btn" title="حذف" data-id="${notification.id}">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/trash.svg" alt="Delete">
                        </button>
                    </div>
                </div>
                <div class="notification-content">
                    ${notification.message}
                </div>
            </div>
        `;
    }

    function displayNotifications(filteredNotifications = notifications) {
        if (!notificationsList) return;

        if (filteredNotifications.length === 0) {
            notificationsList.innerHTML = `
                <div class="empty-state">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/bell-slash.svg" alt="">
                    <h2>لا توجد إشعارات</h2>
                    <p>لم يتم إنشاء أي إشعارات بعد</p>
                </div>
            `;
            return;
        }

        notificationsList.innerHTML = filteredNotifications
            .sort((a, b) => new Date(b.date) - new Date(a.date))
            .map(notification => createNotificationItem(notification))
            .join('');

        // Add event listeners for action buttons
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', () => editNotification(btn.dataset.id));
        });

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', () => deleteNotification(btn.dataset.id));
        });
    }

    function filterNotifications() {
        const searchTerm = searchInput.value.toLowerCase();
        const target = targetFilter.value;
        const type = typeFilter.value;
        const date = dateFilter.value;

        let filteredNotifications = notifications.filter(notification => {
            const matchesSearch = 
                notification.title.toLowerCase().includes(searchTerm) ||
                notification.message.toLowerCase().includes(searchTerm);
            
            const matchesTarget = !target || notification.target === target;
            const matchesType = !type || notification.type === type;

            if (!date) return matchesSearch && matchesTarget && matchesType;

            const notificationDate = new Date(notification.date);
            const now = new Date();
            
            switch (date) {
                case 'today':
                    return notificationDate.toDateString() === now.toDateString() &&
                           matchesSearch && matchesTarget && matchesType;
                case 'week':
                    const weekAgo = new Date(now - 7 * 24 * 60 * 60 * 1000);
                    return notificationDate >= weekAgo &&
                           matchesSearch && matchesTarget && matchesType;
                case 'month':
                    const monthAgo = new Date(now - 30 * 24 * 60 * 60 * 1000);
                    return notificationDate >= monthAgo &&
                           matchesSearch && matchesTarget && matchesType;
                default:
                    return matchesSearch && matchesTarget && matchesType;
            }
        });

        displayNotifications(filteredNotifications);
    }

    function showModal(isEdit = false) {
        notificationModal.classList.add('active');
        notificationForm.reset();
        document.querySelector('.modal-title').textContent = 
            isEdit ? 'تعديل الإشعار' : 'إنشاء إشعار جديد';
        specificUserGroup.style.display = 'none';
    }

    function editNotification(id) {
        const notification = notifications.find(n => n.id === id);
        if (!notification) return;

        document.getElementById('notificationId').value = id;
        document.getElementById('notificationType').value = notification.type;
        document.getElementById('notificationTarget').value = notification.target;
        document.getElementById('notificationTitle').value = notification.title;
        document.getElementById('notificationMessage').value = notification.message;

        if (notification.target === 'specific') {
            specificUserGroup.style.display = 'block';
            specificUser.value = notification.userId;
        }

        showModal(true);
    }

    function deleteNotification(id) {
        if (confirm('هل أنت متأكد من حذف هذا الإشعار؟')) {
            notifications = notifications.filter(n => n.id !== id);
            localStorage.setItem('admin_notifications', JSON.stringify(notifications));
            displayNotifications();
        }
    }

    // Event listeners
    searchInput?.addEventListener('input', filterNotifications);
    targetFilter?.addEventListener('change', filterNotifications);
    typeFilter?.addEventListener('change', filterNotifications);
    dateFilter?.addEventListener('change', filterNotifications);

    createNotificationBtn?.addEventListener('click', () => showModal());

    closeModal?.addEventListener('click', () => notificationModal.classList.remove('active'));
    cancelBtn?.addEventListener('click', () => notificationModal.classList.remove('active'));

    notificationTarget?.addEventListener('change', function() {
        specificUserGroup.style.display = this.value === 'specific' ? 'block' : 'none';
        if (this.value === 'specific') {
            specificUser.required = true;
        } else {
            specificUser.required = false;
            specificUser.value = '';
        }
    });

    notificationForm?.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(notificationForm);
        const notificationId = formData.get('notificationId');
        
        const notification = {
            id: notificationId || Date.now().toString(),
            type: formData.get('type'),
            target: formData.get('target'),
            title: formData.get('title'),
            message: formData.get('message'),
            date: new Date().toISOString()
        };

        if (notification.target === 'specific') {
            notification.userId = formData.get('userId');
            if (!notification.userId) {
                alert('الرجاء اختيار المستخدم');
                return;
            }
        }

        if (notificationId) {
            // Update existing notification
            notifications = notifications.map(n => 
                n.id === notificationId ? { ...n, ...notification } : n
            );
        } else {
            // Add new notification
            notifications.push(notification);
        }

        localStorage.setItem('admin_notifications', JSON.stringify(notifications));

        // Send notification to users
        if (notification.target === 'specific') {
            notificationsManager.addNotification({
                type: notification.type,
                title: notification.title,
                message: notification.message,
                userId: notification.userId
            });
        } else {
            // Get users based on target
            const targetUsers = users.filter(user => {
                if (notification.target === 'all') return true;
                return user.userType === notification.target;
            });

            // Send notification to each user
            targetUsers.forEach(user => {
                notificationsManager.addNotification({
                    type: notification.type,
                    title: notification.title,
                    message: notification.message,
                    userId: user.id
                });
            });
        }

        notificationModal.classList.remove('active');
        displayNotifications();
        alert('تم إرسال الإشعار بنجاح');
    });

    // إظهار المودال عند الضغط على زر "إنشاء إشعار جديد"
createNotificationBtn?.addEventListener('click', () => {
    notificationModal.classList.add('active');
    notificationForm.reset();
    specificUserGroup.style.display = 'none';
    document.querySelector('.modal-title').textContent = 'إنشاء إشعار جديد';
});

    // Initialize
    populateUsersDropdown();
    displayNotifications();
});