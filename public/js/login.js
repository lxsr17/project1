document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');
    const loginError = document.getElementById('loginError');

    // إعادة تعيين الأخطاء
    function resetErrors() {
        emailError.textContent = '';
        emailError.classList.remove('show');
        passwordError.textContent = '';
        passwordError.classList.remove('show');
        loginError.textContent = '';
        loginError.classList.remove('show');
        emailInput.classList.remove('error');
        passwordInput.classList.remove('error');
    }

    // عرض رسالة خطأ
    function showError(element, message) {
        element.textContent = message;
        element.classList.add('show');
        if (element === emailError) emailInput.classList.add('error');
        if (element === passwordError) passwordInput.classList.add('error');
    }

    // إرسال الطلب عند الضغط على تسجيل الدخول
    loginForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        resetErrors();

        const email = emailInput.value.trim();
        const password = passwordInput.value.trim();

        try {
            const response = await fetch('/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                credentials: 'same-origin',
                body: JSON.stringify({ email, password })
            });

            const data = await response.json();

            if (response.ok) {
                if (data.redirect) {
                    window.location.href = data.redirect;
                }
            } else {
                if (data.errors) {
                    if (data.errors.email) showError(emailError, data.errors.email[0]);
                    if (data.errors.password) showError(passwordError, data.errors.password[0]);
                } else {
                    showError(loginError, data.message || 'فشل تسجيل الدخول');
                }
            }

        } catch (error) {
            console.error('حدث خطأ:', error);
            showError(loginError, 'فشل الاتصال بالخادم');
        }
    });
});
