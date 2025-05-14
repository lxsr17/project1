document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('contactForm');
    const phoneInput = document.getElementById('phone');

    // عناصر المودال
    const createAccountBtn = document.getElementById('createAccountBtn');
    const loginBtn = document.getElementById('loginBtn');
    const modal = document.getElementById('accountTypeModal');
    const closeModal = document.getElementById('closeModal');
    const modalTitle = document.querySelector('.modal-title');
    const modalDescription = document.querySelector('.modal-description');
    const loginLink = document.querySelector('.login-link');
    const visitorBtn = document.querySelector('.visitor-btn');
    const merchantBtn = document.querySelector('.merchant-btn');

    // إظهار المودال
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

    // أحداث الأزرار
    createAccountBtn?.addEventListener('click', () => showModal(false));
    loginBtn?.addEventListener('click', () => showModal(true));
    visitorBtn?.addEventListener('click', () => window.location.href = './register');
    merchantBtn?.addEventListener('click', () => window.location.href = './merchant-register');

    loginLink?.addEventListener('click', (e) => {
        e.preventDefault();
        window.location.href = './login';
    });

    closeModal?.addEventListener('click', () => modal.classList.remove('active'));
    modal?.addEventListener('click', (e) => {
        if (e.target === modal) modal.classList.remove('active');
    });

    // التحقق من رقم الجوال
    function validatePhoneNumber(input) {
        const value = input.value;
        const isValid = /^05\d{8}$/.test(value);
        input.setCustomValidity(isValid ? '' : 'يجب أن يبدأ الرقم بـ 05 ويتكون من 10 أرقام');
        return isValid;
    }

    phoneInput?.addEventListener('input', () => validatePhoneNumber(phoneInput));

    // إرسال النموذج
    form?.addEventListener('submit', async function (e) {
        e.preventDefault();
    
        if (!validatePhoneNumber(phoneInput)) {
            return;
        }
    
        const formData = new FormData(form);
    
        try {
            const response = await fetch("{{ route('contact.send') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });
    
            if (response.ok) {
                alert('✅ تم إرسال رسالتك بنجاح');
                form.reset();
            } else {
                const errorData = await response.json();
                alert('❌ حدث خطأ أثناء الإرسال: ' + (errorData.message || 'غير معروف'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('❌ حدث خطأ في الاتصال بالخادم');
        }
    });
    
});
