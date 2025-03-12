document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const phoneInput = document.getElementById('phone');
    
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

    // Phone number validation
    function validatePhoneNumber(input) {
        const value = input.value;
        const isValid = /^05\d{8}$/.test(value);
        input.setCustomValidity(isValid ? '' : 'يجب أن يبدأ الرقم بـ 05 ويتكون من 10 أرقام');
        return isValid;
    }

    // Add input validation listeners
    phoneInput?.addEventListener('input', () => validatePhoneNumber(phoneInput));

    // Handle form submission
    form?.addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!validatePhoneNumber(phoneInput)) {
            return;
        }

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        try {
            // In a real app, this would be an API call
            console.log('Form data:', data);
            alert('تم إرسال رسالتك بنجاح');
            form.reset();
        } catch (error) {
            console.error('Error:', error);
            alert('حدث خطأ أثناء إرسال الرسالة');
        }
    });
});