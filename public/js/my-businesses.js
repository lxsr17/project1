import { insertUserHeader } from './components/user-header.js';
import { storeManager } from './components/store-manager.js';

document.addEventListener('DOMContentLoaded', function() {
    // Insert user header
    insertUserHeader();
    
    const addBusinessBtn = document.getElementById('addBusinessBtn');
    const businessesGrid = document.querySelector('.businesses-grid');
    const resultsCount = document.querySelector('.results-count');
    
    function createBusinessCard(business) {
        return `
            <div class="business-card" data-id="${business.id}">
                <div class="business-logo">
                    <img src="${business.logo || 'https://via.placeholder.com/120'}" alt="${business.businessNameAr}">
                </div>
                <div class="business-info">
                    <div class="business-header">
                        <div>
                            <h3 class="business-name">${business.businessNameAr}</h3>
                            <p class="store-category">${business.mainCategory}</p>
                        </div>
                        <span class="business-status incomplete">غير مكتمل</span>
                    </div>
                    <div class="store-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-count">(${business.ratingCount || 0} مقيم) ${business.rating || 0}</span>
                    </div>
                    <div class="business-actions">
                        <button class="action-btn edit-btn" onclick="window.editBusiness('${business.id}')">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/pen.svg" alt="">
                            تعديل
                        </button>
                        <button class="action-btn share-btn" onclick="window.copyShareLink('${business.id}')">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/share-nodes.svg" alt="">
                            مشاركة
                        </button>
                        <button class="action-btn delete-btn" onclick="window.deleteBusiness('${business.id}')">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/trash.svg" alt="">
                            حذف
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    function createEmptyState() {
        return `
            <div class="empty-state">
                <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/store.svg" alt="Empty state" class="empty-icon">
                <h2>لا يوجد لديك أي أعمال حالياً</h2>
                <p>ابدأ بإضافة عملك الأول على منصة تحقق</p>
                <button class="btn btn-primary" onclick="window.location.href='./add-business.html'">إضافة عمل جديد</button>
            </div>
        `;
    }

    function displayBusinesses() {
        if (!businessesGrid) return;

        const userStores = storeManager.getUserStores();

        if (userStores.length === 0) {
            businessesGrid.innerHTML = createEmptyState();
        } else {
            businessesGrid.innerHTML = userStores.map(store => createBusinessCard(store)).join('');
        }

        if (resultsCount) {
            resultsCount.textContent = `تم العثور على ${userStores.length} متجر`;
        }

        // Update add business button visibility
        if (addBusinessBtn) {
            addBusinessBtn.style.display = userStores.length >= 4 ? 'none' : 'block';
        }
    }

    // Handle add business button click
    addBusinessBtn?.addEventListener('click', () => {
        const userStores = storeManager.getUserStores();
        if (userStores.length >= 4) {
            alert('لا يمكن إضافة أكثر من 4 متاجر');
            return;
        }
        window.location.href = './add-business';
    });

    // Initialize businesses list
    displayBusinesses();

    // Add global functions for business actions
    window.editBusiness = function(id) {
        localStorage.setItem('editBusinessId', id);
        window.location.href = './edit-business';
    };

    window.copyShareLink = function(id) {
        const store = storeManager.getStore(id);
        if (!store) return;
        
        const shareUrl = `${window.location.origin}/store-details.html?id=${id}`;
        
        // Create a temporary input element
        const tempInput = document.createElement('input');
        tempInput.value = shareUrl;
        document.body.appendChild(tempInput);
        
        // Select and copy the URL
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        
        alert('تم نسخ رابط المتجر إلى الحافظة');
    };

    window.deleteBusiness = function(id) {
        if (confirm('هل أنت متأكد من حذف هذا المتجر؟')) {
            try {
                storeManager.deleteStore(id);
                displayBusinesses();
            } catch (error) {
                alert(error.message);
            }
        }
    };

    // Check for newly created business
    const newBusiness = JSON.parse(localStorage.getItem('newBusiness'));
    if (newBusiness) {
        try {
            storeManager.addStore(newBusiness);
            localStorage.removeItem('newBusiness');
            displayBusinesses();
        } catch (error) {
            alert(error.message);
        }
    }
});