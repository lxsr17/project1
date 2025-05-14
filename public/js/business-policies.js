document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('businessPoliciesForm');
    const noReturnCheckbox = document.getElementById('noReturn');
    const returnPolicy = document.getElementById('returnPolicy');
    const returnDays = document.getElementById('returnDays');
    const exchangeDays = document.getElementById('exchangeDays');
    const backBtn = document.getElementById('backBtn');

    function setRequired() {
        if (!returnPolicy) return;

        const isChecked = noReturnCheckbox.checked;

        returnPolicy.required = true;

        if (isChecked) {
            returnDays.required = false;
            exchangeDays.required = false;

            returnDays.value = '0';
            exchangeDays.value = '0';
        } else {
            returnDays.required = true;
            exchangeDays.required = true;
        }
    }

    // التحقق قبل الإرسال
    form.addEventListener('submit', function (e) {
        setRequired();

        if (!returnPolicy.value.trim()) {
            e.preventDefault();
            alert("يرجى إدخال سياسة الاستبدال والاسترجاع");
            return;
        }

        if (!noReturnCheckbox.checked) {
            if (!returnDays.value || parseInt(returnDays.value) <= 0) {
                e.preventDefault();
                alert("يرجى إدخال عدد أيام الاسترجاع");
                return;
            }

            if (!exchangeDays.value || parseInt(exchangeDays.value) <= 0) {
                e.preventDefault();
                alert("يرجى إدخال عدد أيام الاستبدال");
                return;
            }
        }
    });

    // عند تغيير حالة التشيك
    noReturnCheckbox.addEventListener('change', () => {
        setRequired();
    });

    // تهيئة أولية عند فتح الصفحة
    setRequired();

    // زر السابق
    backBtn?.addEventListener('click', () => {
        window.location.href = './business-contact.html';
    });
});
