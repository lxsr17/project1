import { insertUserHeader } from './components/user-header.js';
import { notificationsManager } from './components/notifications.js';

document.addEventListener('DOMContentLoaded', function() {
    // Insert user header
    insertUserHeader();

    // Get DOM elements
    const searchInput = document.getElementById('searchInput');
    const userTypeFilter = document.getElementById('userTypeFilter');
    const statusFilter = document.getElementById('statusFilter');
    const usersTableBody = document.getElementById('usersTableBody');
    const userDetailsModal = document.getElementById('userDetailsModal');
    const notificationModal = document.getElementById('notificationModal');
    const notificationForm = document.getElementById('notificationForm');
    const closeDetailsModal = document.getElementById('closeDetailsModal');
    const closeDetails = document.getElementById('closeDetails');
    const closeNotificationModal = document.getElementById('closeNotificationModal');
    const cancelNotification = document.getElementById('cancelNotification');

    

    // Store sample data in localStorage
    localStorage.setItem('users', JSON.stringify(sampleUsers));

    // Get users from localStorage
    let users = JSON.parse(localStorage.getItem('users') || '[]');

    function createUserRow(user) {
        const registrationDate = new Date(user.registrationDate).toLocaleDateString('ar-SA');
        
        return `
            <tr>
                <td>${user.firstName} ${user.lastName}</td>
                <td>${user.email}</td>
                <td>
                    <span class="user-type ${user.userType}">
                        ${user.userType === 'visitor' ? 'زائر' : 'تاجر'}
                    </span>
                </td>
                <td>
                    <span class="user-status ${user.status || 'active'}">
                        ${user.status === 'suspended' ? 'موقوف' : 'نشط'}
                    </span>
                </td>
                <td>${registrationDate}</td>
                <td>
                    <div class="actions">
                        <button class="action-btn view-btn" title="عرض التفاصيل" data-user-id="${user.id}">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/eye.svg" alt="View">
                        </button>
                        <button class="action-btn notify-btn" title="إرسال تنبيه" data-user-id="${user.id}">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/bell.svg" alt="Notify">
                        </button>
                        <button class="action-btn suspend-btn" title="${user.status === 'suspended' ? 'إلغاء الإيقاف' : 'إيقاف'}" data-user-id="${user.id}">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/ban.svg" alt="Suspend">
                        </button>
                        <button class="action-btn delete-btn" title="حذف" data-user-id="${user.id}">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/trash.svg" alt="Delete">
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }

    function displayUsers(filteredUsers = users) {
        if (!usersTableBody) return;

        if (filteredUsers.length === 0) {
            usersTableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center">لا يوجد مستخدمين</td>
                </tr>
            `;
            return;
        }

        usersTableBody.innerHTML = filteredUsers.map(user => createUserRow(user)).join('');

        // Add event listeners for action buttons
        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', () => showUserDetails(btn.dataset.userId));
        });

        document.querySelectorAll('.notify-btn').forEach(btn => {
            btn.addEventListener('click', () => showNotificationModal(btn.dataset.userId));
        });

        document.querySelectorAll('.suspend-btn').forEach(btn => {
            btn.addEventListener('click', () => toggleUserSuspension(btn.dataset.userId));
        });

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', () => deleteUser(btn.dataset.userId));
        });
    }

    function filterUsers() {
        const searchTerm = searchInput.value.toLowerCase();
        const userType = userTypeFilter.value;
        const status = statusFilter.value;

        const filteredUsers = users.filter(user => {
            const matchesSearch = 
                `${user.firstName} ${user.lastName}`.toLowerCase().includes(searchTerm) ||
                user.email.toLowerCase().includes(searchTerm);
            
            const matchesType = !userType || user.userType === userType;
            const matchesStatus = !status || (user.status || 'active') === status;

            return matchesSearch && matchesType && matchesStatus;
        });

        displayUsers(filteredUsers);
    }

    function showUserDetails(userId) {
        const user = users.find(u => u.id === userId);
        if (!user) return;

        // Get user's reviews
        const reviews = JSON.parse(localStorage.getItem(`reviews_${user.email}`) || '[]');

        const userDetailsContent = document.getElementById('userDetailsContent');
        userDetailsContent.innerHTML = `
            <div class="detail-group">
                <h3>البيانات الشخصية</h3>
                <p>الاسم: ${user.firstName} ${user.lastName}</p>
                <p>البريد الإلكتروني: ${user.email}</p>
                <p>رقم الجوال: ${user.phone}</p>
                <p>نوع المستخدم: ${user.userType === 'visitor' ? 'زائر' : 'تاجر'}</p>
                <p>الحالة: ${user.status === 'suspended' ? 'موقوف' : 'نشط'}</p>
                <p>تاريخ التسجيل: ${new Date(user.registrationDate).toLocaleDateString('ar-SA')}</p>
            </div>
            ${user.userType === 'visitor' ? `
                <div class="detail-group">
                    <h3>التقييمات (${reviews.length})</h3>
                    <div class="reviews-list">
                        ${reviews.map(review => `
                            <div class="review-item">
                                <div class="review-header">
                                    <span class="review-store">${review.storeName}</span>
                                    <span class="review-date">${new Date(review.date).toLocaleDateString('ar-SA')}</span>
                                </div>
                                <div class="review-rating">${'★'.repeat(review.rating)}${'☆'.repeat(5 - review.rating)}</div>
                                <p class="review-comment">${review.comment}</p>
                            </div>
                        `).join('') || '<p>لا توجد تقييمات</p>'}
                    </div>
                </div>
            ` : ''}
        `;

        userDetailsModal.classList.add('active');
    }

    function showNotificationModal(userId) {
        const user = users.find(u => u.id === userId);
        if (!user) return;

        document.getElementById('notificationUserId').value = userId;
        notificationModal.classList.add('active');
    }

    function toggleUserSuspension(userId) {
        const userIndex = users.findIndex(u => u.id === userId);
        if (userIndex === -1) return;

        const newStatus = users[userIndex].status === 'suspended' ? 'active' : 'suspended';
        const actionText = newStatus === 'suspended' ? 'إيقاف' : 'إلغاء إيقاف';

        if (confirm(`هل أنت متأكد من ${actionText} هذا المستخدم؟`)) {
            users[userIndex].status = newStatus;
            localStorage.setItem('users', JSON.stringify(users));

            // Send notification to user
            notificationsManager.addNotification({
                type: 'admin',
                title: `تم ${actionText} حسابك`,
                message: `تم ${actionText} حسابك من قبل الإدارة`,
                userId: userId
            });

            displayUsers();
        }
    }

    function deleteUser(userId) {
        if (confirm('هل أنت متأكد من حذف هذا المستخدم؟')) {
            users = users.filter(u => u.id !== userId);
            localStorage.setItem('users', JSON.stringify(users));
            displayUsers();
        }
    }

    // Event listeners
    searchInput?.addEventListener('input', filterUsers);
    userTypeFilter?.addEventListener('change', filterUsers);
    statusFilter?.addEventListener('change', filterUsers);

    // Close modals
    closeDetailsModal?.addEventListener('click', () => userDetailsModal.classList.remove('active'));
    closeDetails?.addEventListener('click', () => userDetailsModal.classList.remove('active'));
    closeNotificationModal?.addEventListener('click', () => notificationModal.classList.remove('active'));
    cancelNotification?.addEventListener('click', () => notificationModal.classList.remove('active'));

    // Handle notification form submission
    notificationForm?.addEventListener('submit', (e) => {
        e.preventDefault();

        const userId = document.getElementById('notificationUserId').value;
        const title = document.getElementById('notificationTitle').value;
        const message = document.getElementById('notificationMessage').value;

        notificationsManager.addNotification({
            type: 'admin',
            title,
            message,
            userId
        });

        alert('تم إرسال التنبيه بنجاح');
        notificationModal.classList.remove('active');
        notificationForm.reset();
    });

    // Initialize users display
    displayUsers();

    function suspendUser(userId, userType) {
        if (!confirm('هل أنت متأكد من تعليق هذا الحساب؟')) return;
    
        fetch(`/admin/users/${userId}/suspend`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ type: userType })
        })
        .then(response => response.json())
        .then(result => {
            if (result.status === 'suspended') {
                alert(result.message);
                // تحديث الحالة في الجدول مباشرة
                const statusCell = document.getElementById(`status-${userId}`);
                if (statusCell) {
                    statusCell.textContent = 'موقوف';
                    statusCell.classList.remove('text-success');
                    statusCell.classList.add('text-danger');
                }
            } else {
                alert('خطأ: ' + result.message);
            }
        })
        .catch(error => {
            alert('فشل الاتصال بالخادم');
        });
    }
    
});