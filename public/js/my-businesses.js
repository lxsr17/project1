import { insertUserHeader } from './components/user-header.js';
import { storeManager } from './components/store-manager.js';
import Swal from 'sweetalert2'; // نحتاج نستورد SweetAlert2

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
                <button class="btn btn-primary" onclick="window.location.href='./add-business'">إضافة عمل جديد</button>
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

        if (addBusinessBtn) {
            addBusinessBtn.style.display = userStores.length >= 4 ? 'none' : 'block';
        }
    }

    // Handle add business button click
    addBusinessBtn?.addEventListener('click', (e) => {
        const userStores = storeManager.getUserStores();
        if (userStores.length >= 4) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'تنبيه!',
                text: 'لا يمكنك إضافة أكثر من ٤ أعمال.',
                confirmButtonText: 'حسنًا'
            });
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
        
        const shareUrl = `${window.location.origin}/store-details/${id}`;
        
        const tempInput = document.createElement('input');
        tempInput.value = shareUrl;
        document.body.appendChild(tempInput);
        
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        
        Swal.fire('تم النسخ!', 'تم نسخ رابط المتجر إلى الحافظة.', 'success');
    };

    window.deleteBusiness = function(id) {
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "لا يمكنك التراجع بعد الحذف!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'نعم، احذف!',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                try {
                    storeManager.deleteStore(id);
                    displayBusinesses();
                    Swal.fire('تم الحذف!', 'تم حذف المتجر بنجاح.', 'success');
                } catch (error) {
                    Swal.fire('خطأ!', error.message, 'error');
                }
            }
        });
    };

    // Check for newly created business
    const newBusiness = JSON.parse(localStorage.getItem('newBusiness'));
    if (newBusiness) {
        try {
            storeManager.addStore(newBusiness);
            localStorage.removeItem('newBusiness');
            displayBusinesses();
        } catch (error) {
            Swal.fire('خطأ!', error.message, 'error');
        }
    }
});
