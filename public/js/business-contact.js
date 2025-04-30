document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('businessContactForm');
    const backBtn = document.getElementById('backBtn');
    const phoneInput = document.getElementById('phone');
    const storePhoneInput = document.getElementById('storePhone');
    const customerServicePhoneInput = document.getElementById('customerServicePhone');
    const showPhoneCheckbox = document.getElementById('showPhone');
    const customerServicePhoneGroup = document.getElementById('customerServicePhoneGroup');
    const phoneVisibilityNotice = document.getElementById('phoneVisibilityNotice');

    // إخفاء حقل خدمة العملاء في البداية
    if (customerServicePhoneGroup) {
        customerServicePhoneGroup.style.display = 'none';
    }

    // عند تغيير حالة إظهار رقم الجوال
    showPhoneCheckbox?.addEventListener('change', function() {
        if (customerServicePhoneGroup) {
            customerServicePhoneGroup.style.display = this.checked ? 'block' : 'none';
        }
        if (phoneVisibilityNotice) {
            phoneVisibilityNotice.style.display = this.checked ? 'block' : 'none';
        }
        if (!this.checked && customerServicePhoneInput) {
            customerServicePhoneInput.value = '';
        }
    });

    // تحقق من رقم الجوال الأساسي
    function validatePhoneNumber(input) {
        const value = input.value;
        const isValid = /^05\d{8}$/.test(value);
        input.setCustomValidity(isValid ? '' : 'يجب أن يبدأ الرقم بـ 05 ويتكون من 10 أرقام');
        return isValid;
    }

    // تحقق من رقم المتجر (05 أو 800)
    function validateStorePhone(input) {
        const value = input.value;
        const isMobile = /^05\d{8}$/.test(value);
        const isLandline = /^800\d{7}$/.test(value);
        const isValid = !value || isMobile || isLandline;
        input.setCustomValidity(isValid ? '' : 'رقم المتجر يجب أن يبدأ بـ 05 أو 800.');
        return isValid;
    }

    // تحقق من رقم خدمة العملاء
    function validateCustomerServicePhone(input) {
        const value = input.value;
        const isValid = !value || /^05\d{8}$/.test(value);
        input.setCustomValidity(isValid ? '' : 'رقم خدمة العملاء يجب أن يبدأ بـ 05 ويتكون من 10 أرقام');
        return isValid;
    }

    // تحقق حي أثناء الكتابة
    phoneInput?.addEventListener('input', () => validatePhoneNumber(phoneInput));
    storePhoneInput?.addEventListener('input', () => validateStorePhone(storePhoneInput));
    customerServicePhoneInput?.addEventListener('input', () => validateCustomerServicePhone(customerServicePhoneInput));

    // عند الإرسال
    form?.addEventListener('submit', function(e) {
        if (!validatePhoneNumber(phoneInput)) {
            phoneInput.reportValidity();
            e.preventDefault();
            return;
        }

        if (!validateStorePhone(storePhoneInput)) {
            storePhoneInput.reportValidity();
            e.preventDefault();
            return;
        }

        if (showPhoneCheckbox?.checked && !validateCustomerServicePhone(customerServicePhoneInput)) {
            customerServicePhoneInput.reportValidity();
            e.preventDefault();
            return;
        }

        // ✅ إذا كل شيء صحيح، يكمل الإرسال طبيعي إلى السيرفر
    });

    // زر الرجوع للصفحة السابقة
    backBtn?.addEventListener('click', () => {
        window.history.back();
    });
});
