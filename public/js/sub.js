document.addEventListener('DOMContentLoaded', function () {
    const subscriptionForms = document.querySelectorAll('.subscription-form');

    subscriptionForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // منع الإرسال الفوري

            // إظهار رسالة
            const message = this.nextElementSibling;
            if (message && message.classList.contains('selection-message')) {
                message.style.display = 'block';
            }

            // تأخير بسيط ثم الإرسال
            setTimeout(() => {
                this.submit();
            }, 1500); // 1.5 ثانية تقريبًا
        });
    });
});
