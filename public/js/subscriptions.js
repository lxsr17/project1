import { insertUserHeader } from './components/user-header.js';

document.addEventListener('DOMContentLoaded', function() {
    // Insert user header
    insertUserHeader();

    const subscriptionsContainer = document.querySelector('.subscriptions-container');
    const viewPlansBtn = document.querySelector('.btn-primary');

    // Sample subscription data (in a real app, this would come from an API)
    const subscriptions = [];

    function createSubscriptionCard(subscription) {
        return `
            <div class="subscription-card">
                <div class="subscription-header">
                    <h3>${subscription.planName}</h3>
                    <span class="status ${subscription.status}">${subscription.status === 'active' ? 'نشط' : 'منتهي'}</span>
                </div>
                <div class="subscription-details">
                    <p>تاريخ البدء: ${subscription.startDate}</p>
                    <p>تاريخ الانتهاء: ${subscription.endDate}</p>
                    <p>السعر: ${subscription.price} ريال</p>
                </div>
                <div class="subscription-actions">
                    <button class="btn btn-outline">تجديد الاشتراك</button>
                    <button class="btn btn-primary">تفاصيل الاشتراك</button>
                </div>
            </div>
        `;
    }

    function createEmptyState() {
        return `
            <div class="empty-state">
                <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/credit-card.svg" alt="Empty state" class="empty-icon">
                <h2>لا يوجد لديك اشتراكات حالياً</h2>
                <p>يمكنك الاشتراك في خدماتنا المميزة لتطوير أعمالك</p>
                <button class="btn btn-primary" onclick="window.location.href='./plans.html'">عرض الباقات</button>
            </div>
        `;
    }

    function displaySubscriptions() {
        if (!subscriptionsContainer) return;

        if (subscriptions.length === 0) {
            subscriptionsContainer.innerHTML = createEmptyState();
        } else {
            subscriptionsContainer.innerHTML = `
                <div class="subscriptions-grid">
                    ${subscriptions.map(subscription => createSubscriptionCard(subscription)).join('')}
                </div>
            `;
        }
    }

    // Handle view plans button click
    viewPlansBtn?.addEventListener('click', () => {
        window.location.href = './plans';
    });

    // Initialize subscriptions display
    displaySubscriptions();

    // Handle subscription renewal
    document.addEventListener('click', function(e) {
        if (e.target.matches('.btn-outline')) {
            e.preventDefault();
            alert('سيتم توجيهك إلى صفحة تجديد الاشتراك');
        } else if (e.target.matches('.btn-primary') && e.target.textContent === 'تفاصيل الاشتراك') {
            e.preventDefault();
            alert('سيتم عرض تفاصيل الاشتراك');
        }
    });
});