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
    
    // Get stores from localStorage
    const stores = JSON.parse(localStorage.getItem('businesses') || '[]');

    const STORES_PER_PAGE = 10;
    const TOTAL_PAGES = Math.ceil(stores.length / STORES_PER_PAGE);
    let currentPage = 1;

    function createStoreCard(store) {
        return `
            <div class="store-card" data-id="${store.id}" onclick="window.location.href='./store-details.html?id=${store.id}'">
                <div class="store-logo">
                    <img src="${store.logo || 'https://via.placeholder.com/80'}" alt="${store.businessNameAr}">
                </div>
                <div class="store-info">
                    <h3>${store.businessNameAr}</h3>
                    <p class="store-category">${store.mainCategory}</p>
                    <div class="store-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-count">${store.rating || 0}.0 (${store.ratingCount || 0} مقيم)</span>
                    </div>
                    <div class="store-badge">
                        <img src="/logo.svg" alt="شهادة تحقق" class="badge-icon">
                    </div>
                </div>
            </div>
        `;
    }

    function displayStores(page) {
        if (!storesGrid) return;

        if (stores.length === 0) {
            storesGrid.innerHTML = `
                <div class="empty-state">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/store.svg" alt="Empty state" class="empty-icon">
                    <h2>لا يوجد متاجر حالياً</h2>
                    <p>لم يتم إضافة أي متاجر بعد</p>
                </div>
            `;
            if (storesCount) {
                storesCount.textContent = 'عدد النتائج: 0';
            }
            if (pagination) {
                pagination.style.display = 'none';
            }
            return;
        }

        const start = (page - 1) * STORES_PER_PAGE;
        const end = start + STORES_PER_PAGE;
        const pageStores = stores.slice(start, end);
        
        storesGrid.innerHTML = pageStores.map(store => createStoreCard(store)).join('');
        
        if (storesCount) {
            storesCount.textContent = `عدد النتائج: ${stores.length}`;
        }
        
        updatePagination(page);
    }

    function updatePagination(currentPage) {
        if (!pagination) return;

        if (stores.length === 0) {
            pagination.style.display = 'none';
            return;
        }

        pagination.style.display = 'flex';
        let paginationHTML = '';
        
        // Always show first page
        paginationHTML += `<button class="page-btn ${currentPage === 1 ? 'active' : ''}" data-page="1">1</button>`;

        if (TOTAL_PAGES <= 7) {
            // If total pages are 7 or less, show all pages
            for (let i = 2; i <= TOTAL_PAGES; i++) {
                paginationHTML += `<button class="page-btn ${currentPage === i ? 'active' : ''}" data-page="${i}">${i}</button>`;
            }
        } else {
            // Complex pagination with dots
            if (currentPage > 3) {
                paginationHTML += '<span class="page-dots">...</span>';
            }

            // Show pages around current page
            for (let i = Math.max(2, currentPage - 1); i <= Math.min(TOTAL_PAGES - 1, currentPage + 1); i++) {
                paginationHTML += `<button class="page-btn ${currentPage === i ? 'active' : ''}" data-page="${i}">${i}</button>`;
            }

            if (currentPage < TOTAL_PAGES - 2) {
                paginationHTML += '<span class="page-dots">...</span>';
            }

            // Always show last page
            paginationHTML += `<button class="page-btn ${currentPage === TOTAL_PAGES ? 'active' : ''}" data-page="${TOTAL_PAGES}">${TOTAL_PAGES}</button>`;
        }

        pagination.innerHTML = paginationHTML;

        // Add click handlers to new pagination buttons
        document.querySelectorAll('.page-btn').forEach(button => {
            button.addEventListener('click', () => {
                const newPage = parseInt(button.dataset.page);
                if (newPage !== currentPage) {
                    currentPage = newPage;
                    displayStores(currentPage);
                    // Scroll to top of stores section
                    document.querySelector('.stores-list')?.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    }

    // Handle sort links
    sortLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            sortLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');

            const sortType = link.textContent;
            let sortedStores = [...stores];

            switch (sortType) {
                case 'الأحدث':
                    sortedStores.sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt));
                    break;
                case 'الأفضل تقييماً':
                    sortedStores.sort((a, b) => (b.rating || 0) - (a.rating || 0));
                    break;
                case 'الأكثر تقييماً':
                    sortedStores.sort((a, b) => (b.ratingCount || 0) - (a.ratingCount || 0));
                    break;
            }

            currentPage = 1;
            displayStores(currentPage);
        });
    });

    // Handle search form
    if (searchForm) {
        searchForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const query = searchForm.querySelector('input').value.trim().toLowerCase();
            
            if (query) {
                const filteredStores = stores.filter(store => 
                    store.businessNameAr.toLowerCase().includes(query) ||
                    store.businessNameEn?.toLowerCase().includes(query) ||
                    store.id.toString().includes(query)
                );

                if (filteredStores.length === 0) {
                    storesGrid.innerHTML = `
                        <div class="empty-state">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/search.svg" alt="No results" class="empty-icon">
                            <h2>لا توجد نتائج</h2>
                            <p>لم يتم العثور على متاجر تطابق بحثك</p>
                        </div>
                    `;
                    if (storesCount) {
                        storesCount.textContent = 'عدد النتائج: 0';
                    }
                    if (pagination) {
                        pagination.style.display = 'none';
                    }
                } else {
                    storesGrid.innerHTML = filteredStores.map(store => createStoreCard(store)).join('');
                    if (storesCount) {
                        storesCount.textContent = `عدد النتائج: ${filteredStores.length}`;
                    }
                    if (pagination) {
                        pagination.style.display = 'none';
                    }
                }
            } else {
                currentPage = 1;
                displayStores(currentPage);
            }
        });
    }

    // Handle filters
    if (filterApplyBtn) {
        filterApplyBtn.addEventListener('click', () => {
            const certificateType = document.querySelector('input[name="certificate"]:checked')?.value;
            const category = document.querySelector('.filter-select').value;
            const location = document.querySelector('.filter-select:last-child').value;

            let filteredStores = [...stores];

            if (category) {
                filteredStores = filteredStores.filter(store => store.mainCategory === category);
            }

            if (filteredStores.length === 0) {
                storesGrid.innerHTML = `
                    <div class="empty-state">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/filter.svg" alt="No results" class="empty-icon">
                        <h2>لا توجد نتائج</h2>
                        <p>لم يتم العثور على متاجر تطابق التصفية</p>
                    </div>
                `;
                if (storesCount) {
                    storesCount.textContent = 'عدد النتائج: 0';
                }
                if (pagination) {
                    pagination.style.display = 'none';
                }
            } else {
                storesGrid.innerHTML = filteredStores.map(store => createStoreCard(store)).join('');
                if (storesCount) {
                    storesCount.textContent = `عدد النتائج: ${filteredStores.length}`;
                }
                if (pagination) {
                    pagination.style.display = 'none';
                }
            }
        });
    }

    // Initialize first page
    displayStores(currentPage);
});