document.addEventListener('DOMContentLoaded', function() {
    // Modal functionality
    const modal = document.getElementById('accountTypeModal');
    const createAccountBtn = document.getElementById('createAccountBtn');
    const loginBtn = document.getElementById('loginBtn');
    const closeModal = document.getElementById('closeModal');
    const modalTitle = document.querySelector('.modal-title');
    const modalDescription = document.querySelector('.modal-description');
    const loginLink = document.querySelector('.login-link');
    const visitorBtn = document.querySelector('.visitor-btn');
    const merchantBtn = document.querySelector('.merchant-btn');

    function showModal(isLogin) {
        if (isLogin) {
            window.location.href = './login';
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
    const topStoresSection = document.getElementById('topStoresSection');
    const topStoresGrid = document.getElementById('topStoresGrid');

    // Display top rated stores if any exist
    if (stores.length > 0) {
        // Sort stores by rating
        const topStores = stores
            .sort((a, b) => b.rating - a.rating)
            .slice(0, 3); // Get top 3 stores

        if (topStores.length > 0) {
            topStoresSection.style.display = 'block';
            topStoresGrid.innerHTML = topStores.map(store => `
                <div class="store-card" onclick="window.location.href='./store-details.html?id=${store.id}'">
                    <div class="store-logo">
                        <img src="${store.logo || 'https://via.placeholder.com/80'}" alt="${store.businessNameAr}">
                    </div>
                    <div class="store-info">
                        <h3>${store.businessNameAr}</h3>
                        <p class="store-category">${store.mainCategory}</p>
                        <div class="store-rating">
                            <span class="stars">★★★★★</span>
                            <span class="rating-count">${store.rating}.0</span>
                        </div>
                    </div>
                </div>
            `).join('');
        }
    }

    // Add search form validation and handling
    const searchForm = document.querySelector('#search-form');
    if (searchForm) {
        const searchInput = searchForm.querySelector('input');
        const searchResults = document.querySelector('#search-results');

        searchForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const query = searchInput.value.trim();
            
            if (query === '') {
                searchInput.classList.add('error');
                setTimeout(() => {
                    searchInput.classList.remove('error');
                }, 3000);
                return;
            }

            try {
                // Filter stores based on search query
                const results = stores.filter(store => 
                    store.businessNameAr.includes(query) || 
                    store.businessNameEn?.includes(query)
                );
                
                if (searchResults) {
                    if (results.length > 0) {
                        searchResults.textContent = `تم العثور على ${results.length} متجر`;
                    } else {
                        searchResults.textContent = 'لم يتم العثور على نتائج';
                    }
                }
            } catch (error) {
                console.error('Error searching:', error);
                if (searchResults) {
                    searchResults.textContent = 'حدث خطأ أثناء البحث';
                }
            }
        });
    }
    
});
