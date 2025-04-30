import { insertUserHeader } from './components/user-header.js';

document.addEventListener('DOMContentLoaded', function() {
    // Insert user header
    insertUserHeader();

    // Get new business data
    const newBusiness = JSON.parse(localStorage.getItem('newBusiness') || '{}');

    // Update page content with business name if available
    const businessName = document.querySelector('.success-title');
    if (businessName && newBusiness.businessNameAr) {
        businessName.textContent = `تم إضافة ${newBusiness.businessNameAr} بنجاح!`;
    }

    // Handle navigation buttons
    const myBusinessesBtn = document.querySelector('.btn-outline');
    const viewBusinessBtn = document.querySelector('.btn-primary');

    myBusinessesBtn?.addEventListener('click', () => {
        window.location.href = './my-businesses.html';
    });

    viewBusinessBtn?.addEventListener('click', () => {
        // Navigate to the business page with the new business ID
        window.location.href = `./store-details.html?id=${newBusiness.id || Date.now()}`;
    });

    // Add business to businesses list in localStorage
    if (newBusiness) {
        const businesses = JSON.parse(localStorage.getItem('businesses') || '[]');
        businesses.push({
            id: Date.now().toString(),
            ...newBusiness,
            status: 'incomplete',
            rating: 0,
            ratingCount: 0
        });
        localStorage.setItem('businesses', JSON.stringify(businesses));
    }
});