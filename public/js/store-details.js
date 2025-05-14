
import { insertUserHeader } from './components/user-header.js';

document.addEventListener('DOMContentLoaded', function () {
    insertUserHeader();

    const store = window.storeData || {};
    const reviews = window.reviewsFromServer || [];

    const storeLogo = document.querySelector('.store-logo img');
    const storeName = document.querySelector('.store-basic-info h1');
    const storeCategory = document.querySelector('.store-category');
    const ratingValue = document.querySelector('.rating-value');
    const ratingCount = document.querySelector('.rating-count');
    const storeIdElement = document.querySelector('.store-id strong');
    const emailLink = document.querySelector('.contact-item a[href^="mailto:"]');
    const phoneLink = document.querySelector('.contact-item a[href^="tel:"]');
    const returnPolicy = document.querySelector('.policy-item p');
    const shareBtn = document.querySelector('.btn-share');
    const reviewsList = document.querySelector('.reviews-list');
    const addReviewBtn = document.getElementById('addReviewBtn');
    const reviewModal = document.getElementById('reviewModal');
    const closeModal = document.getElementById('closeModal');
    const cancelReview = document.getElementById('cancelReview');
    const reviewForm = document.getElementById('reviewForm');

    if (storeLogo) storeLogo.src = store.logo || 'https://via.placeholder.com/120';
    if (storeName) storeName.textContent = store.businessNameAr || store.business_name || 'اسم المتجر';
    if (storeCategory) storeCategory.textContent = store.mainCategory || store.business_type || 'تصنيف المتجر';
    if (ratingValue) ratingValue.textContent = store.rating || '0.0';
    if (ratingCount) ratingCount.textContent = `(${store.ratingCount || 0} تقييم)`;
    if (storeIdElement) storeIdElement.textContent = store.id || '';
    if (emailLink && store.email) {
        emailLink.href = `mailto:${store.email}`;
        emailLink.textContent = store.email;
    }
    if (phoneLink && store.phone1) {
        phoneLink.href = `tel:+966${store.phone1}`;
        phoneLink.textContent = store.phone1;
    }
    if (returnPolicy) {
        returnPolicy.textContent = store.noReturn
            ? 'لا يمكن الاستبدال والاسترجاع وفقاً لطبيعة المنتج أو الخدمة المقدمة'
            : (store.returnPolicy || 'لم يتم تحديد سياسة الاسترجاع');
    }

    function createReviewElement(review) {
        const stars = '★'.repeat(review.rating) + '☆'.repeat(5 - review.rating);
        const date = new Date(review.review_date).toLocaleDateString('ar-SA');
        const username = review.user?.name || 'مستخدم';

        return `
            <div class="review-item">
                <div class="review-header">
                    <div class="review-user">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/user.svg" alt="">
                        <span>${username}</span>
                    </div>
                    <div class="review-date">${date}</div>
                </div>
                <div class="review-rating">
                    <span class="stars">${stars}</span>
                </div>
                <div class="review-comment">
                    <p>${review.comment}</p>
                </div>
            </div>
        `;
    }

    function displayReviews() {
        if (!reviewsList) return;
        reviewsList.innerHTML = reviews.map(createReviewElement).join('');
    }

    displayReviews();

    function openReviewModal() {
        const guest = document.body.dataset.guest === 'true';
        if (guest) {
            window.location.href = '/login';
        } else {
            reviewModal?.classList.add('active');
        }
    }

    function closeReviewModal() {
        reviewModal?.classList.remove('active');
        reviewForm?.reset();
    }

    addReviewBtn?.addEventListener('click', openReviewModal);
    closeModal?.addEventListener('click', closeReviewModal);
    cancelReview?.addEventListener('click', closeReviewModal);
    reviewModal?.addEventListener('click', (e) => {
        if (e.target === reviewModal) closeReviewModal();
    });

    reviewForm?.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(reviewForm);
        const rating = parseInt(formData.get('rating'));
        const comment = formData.get('reviewText');
        const storeId = store.id;

        try {
            const response = await fetch('/reviews', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: (() => {
                    const fd = new FormData();
                    fd.append('rating', rating);
                    fd.append('comment', comment);
                    fd.append('store_id', storeId);
                    return fd;
                })()
            });

            if (!response.ok) throw new Error('فشل إرسال التقييم.');

            reviews.unshift({
                rating: rating,
                comment: comment,
                review_date: new Date().toISOString(),
                user: { name: 'أنت' }
            });

            displayReviews();
            closeReviewModal();
            alert('تم إرسال تقييمك بنجاح');
        } catch (err) {
            alert('حدث خطأ أثناء إرسال التقييم');
            console.error(err);
        }
    });

    shareBtn?.addEventListener('click', async () => {
        try {
            if (navigator.share) {
                await navigator.share({
                    title: `${store.businessNameAr || 'متجر'} - منصة تحقق`,
                    text: `تفضل بزيارة ${store.businessNameAr || 'المتجر'} على منصة تحقق`,
                    url: window.location.href
                });
            } else {
                await navigator.clipboard.writeText(window.location.href);
                alert('تم نسخ رابط المتجر!');
            }
        } catch (error) {
            console.error('خطأ في مشاركة المتجر:', error);
            alert('حدث خطأ أثناء محاولة مشاركة الرابط');
        }
    });


    
});
