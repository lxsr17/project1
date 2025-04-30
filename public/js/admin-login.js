document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const emailInput = document.querySelector('input[name="email"]');
    const passwordInput = document.querySelector('input[name="password"]');

    // التحقق من الحقول
    form.addEventListener('submit', function (e) {
        if (!emailInput.value || !passwordInput.value) {
            e.preventDefault();
            alert('يرجى تعبئة جميع الحقول');
        }
    });

    // زر عرض / إخفاء كلمة المرور
    const toggle = document.createElement('span');
    toggle.textContent = '👁';
    toggle.style.cursor = 'pointer';
    toggle.style.marginRight = '10px';

    passwordInput.parentNode.appendChild(toggle);

    toggle.addEventListener('click', function () {
        passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
    });
});
