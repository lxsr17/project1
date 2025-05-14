document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scroll behavior
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Add search form validation
    const searchForm = document.querySelector('.search-form');
    const searchInput = searchForm.querySelector('input');

    searchForm.addEventListener('submit', function(e) {
        if (searchInput.value.trim() === '') {
            e.preventDefault();
            searchInput.classList.add('error');
            setTimeout(() => {
                searchInput.classList.remove('error');
            }, 3000);
        }
    });
});