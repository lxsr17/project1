document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('merchantRegisterForm');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    const requirements = document.querySelectorAll('.requirement');
    const birthdateInput = document.getElementById('birthdate');
    const phoneInput = document.getElementById('phone');

    const passwordValidation = {
        length: password => password.length >= 8,
        uppercase: password => /[A-Z]/.test(password),
        lowercase: password => /[a-z]/.test(password),
        number: password => /[0-9]/.test(password),
        special: password => /[!@#$%^&*]/.test(password)
    };

    function validatePassword() {
        const password = passwordInput.value;
        let isValid = true;

        requirements.forEach(req => {
            const type = req.dataset.requirement;
            const valid = passwordValidation[type](password);
            req.classList.toggle('valid', valid);
            req.classList.toggle('invalid', !valid);
            if (!valid) isValid = false;
        });

        return isValid;
    }

    function validateConfirmPassword() {
        return passwordInput.value === confirmPasswordInput.value;
    }

    function validatePhoneNumber() {
        const phone = phoneInput.value;
        const isValid = /^05\d{8}$/.test(phone);
        phoneInput.setCustomValidity(isValid ? '' : 'يجب أن يبدأ الرقم بـ 05 ويتكون من 10 أرقام');
        return isValid;
    }

    // Initialize birthdate input
    function initializeBirthdateInput() {
        const today = new Date();
        
        // Set max date to today
        const maxDate = today.toISOString().split('T')[0];
        birthdateInput.setAttribute('max', maxDate);
        
        // Set min date (18 years ago)
        const minDate = new Date();
        minDate.setFullYear(today.getFullYear() - 18);
        birthdateInput.setAttribute('min', minDate.toISOString().split('T')[0]);
        
        // Set default value to placeholder date (optional)
        birthdateInput.setAttribute('placeholder', 'اختر تاريخ الميلاد');
    }

    initializeBirthdateInput();

    passwordInput.addEventListener('input', validatePassword);
    phoneInput.addEventListener('input', validatePhoneNumber);

    confirmPasswordInput.addEventListener('input', function() {
        const isValid = validateConfirmPassword();
        this.setCustomValidity(isValid ? '' : 'كلمات المرور غير متطابقة');
    });

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!validatePassword()) {
            alert('يرجى استيفاء جميع متطلبات كلمة المرور');
            return;
        }

        if (!validateConfirmPassword()) {
            alert('كلمات المرور غير متطابقة');
            return;
        }

        if (!validatePhoneNumber()) {
            alert('يجب أن يبدأ رقم الجوال بـ 05 ويتكون من 10 أرقام');
            return;
        }

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        try {
            const response = await fetch('http://127.0.0.1:8000/merchants', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });

            if (response.ok) {
                alert('تم إنشاء الحساب بنجاح');
                window.location.href = '/index.html';
            } else {
                const error = await response.json();
                alert(error.message || 'حدث خطأ أثناء إنشاء الحساب');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('حدث خطأ أثناء إنشاء الحساب');
        }
    });
});