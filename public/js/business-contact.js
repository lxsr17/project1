import { insertUserHeader } from './components/user-header.js';

document.addEventListener('DOMContentLoaded', function() {
    // Insert user header
    insertUserHeader();

    const form = document.getElementById('businessContactForm');
    const backBtn = document.getElementById('backBtn');
    const phoneInput = document.getElementById('phone');
    const storePhoneInput = document.getElementById('storePhone');
    const customerServicePhoneInput = document.getElementById('customerServicePhone');
    const showPhoneCheckbox = document.getElementById('showPhone');
    const customerServicePhoneGroup = document.getElementById('customerServicePhoneGroup');

    // Initially hide customer service phone field
    if (customerServicePhoneGroup) {
        customerServicePhoneGroup.style.display = 'none';
    }

    // Show/hide customer service phone field based on checkbox
    showPhoneCheckbox?.addEventListener('change', function() {
        if (customerServicePhoneGroup) {
            customerServicePhoneGroup.style.display = this.checked ? 'block' : 'none';
        }
        if (!this.checked && customerServicePhoneInput) {
            customerServicePhoneInput.value = ''; // Clear the value when hiding
        }
    });

    // Phone number validation
    function validatePhoneNumber(input) {
        const value = input.value;
        const isValid = /^05\d{8}$/.test(value);
        input.setCustomValidity(isValid ? '' : 'يجب أن يبدأ الرقم بـ 05 ويتكون من 10 أرقام');
        return isValid;
    }

    // Store phone validation (accepts both mobile and landline formats)
    function validateStorePhone(input) {
        const value = input.value;
        const isMobile = /^05\d{8}$/.test(value);
        const isLandline = /^800\d{7}$/.test(value);
        const isValid = !value || isMobile || isLandline; // Optional field
        input.setCustomValidity(isValid ? '' : 'يجب أن يكون الرقم بصيغة صحيحة');
        return isValid;
    }

    // Customer service phone validation
    function validateCustomerServicePhone(input) {
        const value = input.value;
        const isValid = !value || /^05\d{8}$/.test(value); // Optional field
        input.setCustomValidity(isValid ? '' : 'يجب أن يبدأ الرقم بـ 05 ويتكون من 10 أرقام');
        return isValid;
    }

    // Add input validation listeners
    phoneInput?.addEventListener('input', () => validatePhoneNumber(phoneInput));
    storePhoneInput?.addEventListener('input', () => validateStorePhone(storePhoneInput));
    customerServicePhoneInput?.addEventListener('input', () => validateCustomerServicePhone(customerServicePhoneInput));

    // Load saved data if exists
    const savedData = JSON.parse(localStorage.getItem('businessData') || '{}');
    if (form && savedData) {
        Object.keys(savedData).forEach(key => {
            const input = form.elements[key];
            if (input) {
                if (input.type === 'checkbox') {
                    input.checked = savedData[key];
                    // Trigger change event for checkbox
                    if (input === showPhoneCheckbox) {
                        const event = new Event('change');
                        input.dispatchEvent(event);
                    }
                } else {
                    input.value = savedData[key];
                }
            }
        });
    }

    // Handle form submission
    form?.addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!validatePhoneNumber(phoneInput)) {
            alert('يجب أن يبدأ رقم الجوال بـ 05 ويتكون من 10 أرقام');
            return;
        }

        if (!validateStorePhone(storePhoneInput)) {
            alert('رقم المتجر غير صحيح');
            return;
        }

        if (showPhoneCheckbox?.checked && !validateCustomerServicePhone(customerServicePhoneInput)) {
            alert('رقم خدمة العملاء غير صحيح');
            return;
        }

        try {
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            // Get previous business data
            const businessData = JSON.parse(localStorage.getItem('businessData') || '{}');
            
            // Merge contact data with business data
            const mergedData = { ...businessData, ...data };

            // Store complete data for next step
            localStorage.setItem('businessData', JSON.stringify(mergedData));

            // Proceed to next step
            window.location.href = './business-policies';
        } catch (error) {
            console.error('Error:', error);
            alert('حدث خطأ أثناء حفظ بيانات التواصل');
        }
    });

    // Handle back button
    backBtn?.addEventListener('click', () => {
        window.location.href = './add-business';
    });
});