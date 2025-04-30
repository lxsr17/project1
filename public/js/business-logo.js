// public/js/business-logo.js

export function handleBusinessLogoUpload(inputSelector = '#businessLogo') {
    const input = document.querySelector(inputSelector);

    if (!input) return;

    input.addEventListener('change', function (e) {
        const file = e.target.files[0];

        if (!file) return;

        // التحقق من الحجم (بحد أقصى 2 ميغابايت)
        if (file.size > 2 * 1024 * 1024) {
            alert('حجم الصورة يجب ألا يتجاوز 2 ميغابايت.');
            input.value = '';
            return;
        }

        // معاينة الصورة المرفوعة
        const reader = new FileReader();
        reader.onload = function (event) {
            const preview = document.querySelector('#logoPreview');
            if (preview) {
                preview.src = event.target.result;
                preview.style.display = 'block';
            }
        };
        reader.readAsDataURL(file);
    });
}
