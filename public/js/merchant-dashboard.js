import { insertUserHeader } from './components/user-header.js';

document.addEventListener('DOMContentLoaded', function() {
    // Insert user header
    insertUserHeader();

    // Handle sidebar navigation
    const navLinks = document.querySelectorAll('.nav-link');
    const currentPage = window.location.pathname;
    
    navLinks.forEach(link => {
        // Set active class based on current page
        if (link.getAttribute('href') === currentPage || 
            (currentPage === '/' && link.getAttribute('href') === './merchant-dashboard')) {
            link.classList.add('active');
        }
    });
});