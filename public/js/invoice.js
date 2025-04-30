document.addEventListener('DOMContentLoaded', function () {
    const paymentForm = document.querySelector('form[action*="payment-process"]');
    const payButton = document.querySelector('.btn-pay');

    if (paymentForm && payButton) {
        paymentForm.addEventListener('submit', function (e) {
            // تأكيد الدفع
            const confirmed = confirm('هل أنت متأكد أنك تريد إتمام عملية الدفع؟');
            if (!confirmed) {
                e.preventDefault();
                return;
            }

            // تعطيل الزر لتجنب التكرار
            payButton.disabled = true;
            payButton.textContent = 'جاري المعالجة...';
        });
    }
});
