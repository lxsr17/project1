document.addEventListener('DOMContentLoaded', function() {
    // Get DOM elements
    const storesGrid = document.querySelector('.stores-grid');
    const pagination = document.querySelector('.pagination');
    const storesCount = document.querySelector('.stores-stats span');
    const sortLinks = document.querySelectorAll('.sort-link');
    const searchForm = document.getElementById('stores-search-form');
    const filterApplyBtn = document.querySelector('.filter-apply');
    
    // Auth elements
    const createAccountBtn = document.getElementById('createAccountBtn');
    const loginBtn = document.getElementById('loginBtn');
    const modal = document.getElementById('accountTypeModal');
    const closeModal = document.getElementById('closeModal');
    const modalTitle = document.querySelector('.modal-title');
    const modalDescription = document.querySelector('.modal-description');
    const loginLink = document.querySelector('.login-link');
    const visitorBtn = document.querySelector('.visitor-btn');
    const merchantBtn = document.querySelector('.merchant-btn');

    // Modal functionality
    function showModal(isLogin) {
        if (isLogin) {
            window.location.href ='./login';
            return;
        }
        
        modalTitle.textContent = 'إنشاء حساب جديد';
        modalDescription.style.display = 'block';
        loginLink.textContent = 'لديك حساب؟ تسجيل الدخول';
        modal.classList.add('active');
    }

    createAccountBtn?.addEventListener('click', () => showModal(false));
    loginBtn?.addEventListener('click', () => showModal(true));

    // Handle visitor registration button click
    visitorBtn?.addEventListener('click', () => {
        window.location.href = './register';
    });

    // Handle merchant registration button click
    merchantBtn?.addEventListener('click', () => {
        window.location.href = './merchant-register';
    });

    // Toggle between login and registration
    loginLink?.addEventListener('click', (e) => {
        e.preventDefault();
        window.location.href = './login';
    });

    if (closeModal) {
        closeModal.addEventListener('click', () => {
            modal.classList.remove('active');
        });

        // Close modal when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });
    }
    


    const STORES_PER_PAGE = 10;
    let currentPage = 1;
    let filteredStores = [...stores];

    function createStoreCard(store) {
        return `
            <div class="store-card" onclick="window.location.href='/store-details/${store.id}'">
                <div class="store-logo">
                    <img src="${store.logo || '/images/placeholder.png'}" alt="شعار المتجر">
                </div>
                <div class="store-info">
                    <h3>${store.businessNameAr}</h3>
                    <p class="store-category">${store.mainCategory}</p>
                    <div class="store-rating">
                        <span class="stars">
                            ${'★'.repeat(Math.floor(store.rating || 0))}
                            ${'☆'.repeat(5 - Math.floor(store.rating || 0))}
                        </span>
                        <span class="rating-count">${store.rating || 0} (${store.ratingCount || 0} تقييم)</span>
                    </div>
                </div>
            </div>
        `;
    }

    function displayStores(page) {
        if (!storesGrid) return;

        const start = (page - 1) * STORES_PER_PAGE;
        const end = start + STORES_PER_PAGE;
        const pageStores = filteredStores.slice(start, end);

        storesGrid.innerHTML = pageStores.length > 0 ?
            pageStores.map(store => createStoreCard(store)).join('') :
            `<div class="empty-state">
                <h2>لا يوجد متاجر</h2>
                <p>لم يتم العثور على متاجر مطابقة.</p>
            </div>`;

        storesCount.textContent = `عدد النتائج: ${filteredStores.length}`;

        updatePagination(page);
    }

    function updatePagination(currentPage) {
        if (!pagination) return;

        const totalPages = Math.ceil(filteredStores.length / STORES_PER_PAGE);

        if (totalPages <= 1) {
            pagination.style.display = 'none';
            return;
        }

        pagination.style.display = 'flex';
        pagination.innerHTML = '';

        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement('button');
            btn.textContent = i;
            btn.className = 'page-btn' + (i === currentPage ? ' active' : '');
            btn.addEventListener('click', () => {
                displayStores(i);
            });
            pagination.appendChild(btn);
        }
    }

    // Sort functionality
    sortLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            sortLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');

            const sortType = link.textContent.trim();
            if (sortType === 'الأحدث') {
                filteredStores.sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt));
            } else if (sortType === 'الأفضل تقييماً') {
                filteredStores.sort((a, b) => (b.rating || 0) - (a.rating || 0));
            } else if (sortType === 'الأكثر تقييماً') {
                filteredStores.sort((a, b) => (b.ratingCount || 0) - (a.ratingCount || 0));
            }
            displayStores(1);
        });
    });

    // Search functionality
    if (searchForm) {
        searchForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const query = searchForm.querySelector('input').value.trim().toLowerCase();
            filteredStores = stores.filter(store => 
                store.businessNameAr.toLowerCase().includes(query) ||
                (store.businessNameEn?.toLowerCase().includes(query)) ||
                (store.id.toString().includes(query))
            );
            displayStores(1);
        });
    }

    // Filter functionality
    if (filterApplyBtn) {
        filterApplyBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const certificate = document.querySelector('input[name="certificate"]:checked')?.value;
            const category = document.querySelector('select[name="category"]').value;
            const city = document.querySelector('select[name="city"]').value;

            filteredStores = stores.filter(store => {
                let certMatch = true;
                if (certificate === 'gold') {
                    certMatch = !!store.commercial_registration_document;
                } else if (certificate === 'silver') {
                    certMatch = !!store.freelancer_document && !store.commercial_registration_document;
                }

                const categoryMatch = category ? store.mainCategory === category : true;
                const cityMatch = city ? store.city === city : true;

                return certMatch && categoryMatch && cityMatch;
            });

            displayStores(1);
        });
    }

    // Init
    displayStores(1);
    const filterClearBtn = document.querySelector('.filter-clear');

if (filterClearBtn) {
    filterClearBtn.addEventListener('click', (e) => {
        e.preventDefault();

        // إزالة تحديد الشهادة
        const checkedCertificate = document.querySelector('input[name="certificate"]:checked');
        if (checkedCertificate) {
            checkedCertificate.checked = false;
        }

        // إعادة تحديد القوائم المنسدلة إلى الخيار الفارغ
        const categorySelect = document.querySelector('select[name="category"]');
        const citySelect = document.querySelector('select[name="city"]');

        if (categorySelect) categorySelect.selectedIndex = 0;
        if (citySelect) citySelect.selectedIndex = 0;

        // إعادة عرض جميع المتاجر
        filteredStores = [...stores];
        displayStores(1);
    });
}



});
