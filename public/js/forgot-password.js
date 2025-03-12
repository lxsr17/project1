document.addEventListener('DOMContentLoaded', function() {
    const emailForm = document.getElementById('emailForm');
    const verificationForm = document.getElementById('verificationForm');
    const newPasswordForm = document.getElementById('newPasswordForm');
    const timerSpan = document.getElementById('timer');
    const resendCodeBtn = document.getElementById('resendCode');
    const requirements = document.querySelectorAll('.requirement');
    const newPasswordInput = document.getElementById('newPassword');
    const confirmNewPasswordInput = document.getElementById('confirmNewPassword');

    let timeLeft = 120; // 2 minutes
    let timerId = null;

    // Password validation rules
    const passwordValidation = {
        length: password => password.length >= 8,
        uppercase: password => /[A-Z]/.test(password),
        lowercase: password => /[a-z]/.test(password),
        number: password => /[0-9]/.test(password),
        special: password => /[!@#$%^&*]/.test(password)
    };

    function startTimer() {
        if (timerId) clearInterval(timerId);
        
        timeLeft = 120;
        updateTimer();
        
        timerId = setInterval(() => {
            timeLeft--;
            updateTimer();
            
            if (timeLeft <= 0) {
                clearInterval(timerId);
                if (resendCodeBtn) {
                    resendCodeBtn.disabled = false;
                }
            }
        }, 1000);
    }

    function updateTimer() {
        if (!timerSpan) return;
        
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerSpan.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    }

    function validatePassword() {
        if (!newPasswordInput) return false;
        
        const password = newPasswordInput.value;
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
        return newPasswordInput.value === confirmNewPasswordInput.value;
    }

    // Handle verification code input
    document.querySelectorAll('.verification-code-input').forEach((input, index) => {
        input.addEventListener('input', function(e) {
            if (e.target.value.length === 1) {
                const nextInput = document.querySelectorAll('.verification-code-input')[index + 1];
                if (nextInput) nextInput.focus();
            }
        });

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !e.target.value) {
                const prevInput = document.querySelectorAll('.verification-code-input')[index - 1];
                if (prevInput) prevInput.focus();
            }
        });
    });

    // Handle email form submission
    emailForm?.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const email = emailForm.email.value;
        
        try {
            // In a real app, this would send a verification code
            emailForm.style.display = 'none';
            verificationForm.style.display = 'block';
            startTimer();
        } catch (error) {
            console.error('Error:', error);
            alert('حدث خطأ أثناء إرسال رمز التحقق');
        }
    });

    // Handle verification form submission
    verificationForm?.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const inputs = verificationForm.querySelectorAll('.verification-code-input');
        const code = Array.from(inputs).map(input => input.value).join('');
        
        try {
            // In a real app, this would verify the code
            verificationForm.style.display = 'none';
            newPasswordForm.style.display = 'block';
        } catch (error) {
            console.error('Error:', error);
            alert('رمز التحقق غير صحيح');
        }
    });

    // Handle resend code button
    resendCodeBtn?.addEventListener('click', function() {
        // In a real app, this would resend the verification code
        startTimer();
        resendCodeBtn.disabled = true;
    });

    // Handle new password form submission
    newPasswordForm?.addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!validatePassword()) {
            alert('يرجى استيفاء جميع متطلبات كلمة المرور');
            return;
        }

        if (!validateConfirmPassword()) {
            alert('كلمات المرور غير متطابقة');
            return;
        }

        try {
            // In a real app, this would update the password
            alert('تم تغيير كلمة المرور بنجاح');
            window.location.href = '/login.html';
        } catch (error) {
            console.error('Error:', error);
            alert('حدث خطأ أثناء تغيير كلمة المرور');
        }
    });

    // Add password validation on input
    newPasswordInput?.addEventListener('input', validatePassword);
    
    confirmNewPasswordInput?.addEventListener('input', function() {
        const isValid = validateConfirmPassword();
        this.setCustomValidity(isValid ? '' : 'كلمات المرور غير متطابقة');
    });
});