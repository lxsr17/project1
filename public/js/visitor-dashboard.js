import { insertUserHeader } from './components/user-header.js';

document.addEventListener('DOMContentLoaded', function() {
    // Insert user header
    insertUserHeader();

    const searchForm = document.getElementById('stores-search-form');
    const recentReviews = document.getElementById('recentReviews');
    const topStores = document.getElementById('topStores');

    // Get current user
    const currentUser = JSON.parse(localStorage.getItem('currentUser') || '{}');

    // Get stores from localStorage
    const stores = JSON.parse(localStorage.getItem('businesses') || '[]');

    // Get user's reviews from localStorage or initialize empty array
    const userReviews = JSON.parse(localStorage.getItem(`reviews_${currentUser.email}`) || '[]');

    function createReviewCard(review) {
        return `
            <div class="review-card">
                <div class="review-header">
                    <span class="review-store">${review.storeName}</span>
                    <span class="review-date">${new Date(review.date).toLocaleDateString('ar-SA')}</span>
                </div>
                <div class="review-rating">
                    ${'★'.repeat(review.rating)}${'☆'.repeat(5 - review.rating)}
                </div>
                <p class="review-comment">${review.comment}</p>
                <p class="review-user">تقييمك</p>
            </div>
        `;
    }

    function createStoreCard(store) {
        return `
            <div class="store-card" onclick="window.location.href='./store-details.html?id=${store.id}'">
                <div class="store-logo">
                    <img src="${store.logo || 'https://via.placeholder.com/80'}" alt="${store.businessNameAr}">
                </div>
                <h3 class="store-name">${store.businessNameAr}</h3>
                <p class="store-category">${store.mainCategory}</p>
                <div class="store-rating">
                    <span class="stars">★★★★★</span>
                    <span class="count">${store.rating || 0}.0 (${store.ratingCount || 0} تقييم)</span>
                </div>
            </div>
        `;
    }

    // Display user's recent reviews
    if (recentReviews) {
        if (userReviews.length === 0) {
            recentReviews.innerHTML = `
                <div class="empty-state">
                    <p>لم تقم بإضافة أي تقييمات بعد</p>
                </div>
            `;
        } else {
            // Sort reviews by date (most recent first)
            const sortedReviews = [...userReviews].sort((a, b) => 
                new Date(b.date) - new Date(a.date)
            );
            recentReviews.innerHTML = sortedReviews.map(review => createReviewCard(review)).join('');
        }
    }

    // Display top rated stores
    if (topStores) {
        const topRatedStores = [...stores]
            .sort((a, b) => (b.rating || 0) - (a.rating || 0))
            .slice(0, 6);
        
        topStores.innerHTML = topRatedStores.map(store => createStoreCard(store)).join('');
    }

    // Handle search
    searchForm?.addEventListener('submit', (e) => {
        e.preventDefault();
        const query = e.target.q.value.trim().toLowerCase();
        
        if (query) {
            window.location.href = `./stores.html?q=${encodeURIComponent(query)}`;
        }
    });
});