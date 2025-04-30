document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('addBusinessForm');
    const cancelBtn = document.getElementById('cancelBtn');
    const mainCategory = document.getElementById('mainCategory');
    const subCategory = document.getElementById('subCategory');
    const linkOptions = document.querySelectorAll('.link-option');
    const linkTypeInput = document.getElementById('linkType');
    const commercialRegistryInput = document.getElementById('commercialRegistry');
    const freelanceDocInput = document.getElementById('freelanceDoc');
    const businessLogoInput = document.getElementById('businessLogo');

    // التصنيفات الفرعية
    const subCategoryOptions = {
        retail: [
            'إلكترونيات وأجهزة', 'أزياء وملابس', 'مأكولات ومشروبات', 'مستحضرات تجميل',
            'أثاث ومفروشات', 'كتب وقرطاسية', 'هدايا وألعاب', 'رياضة ولياقة',
            'منتجات منزلية', 'مجوهرات واكسسوارات', 'أخرى'
        ],
        wholesale: [
            'مواد غذائية', 'مواد بناء', 'أثاث ومفروشات', 'قطع غيار', 'منسوجات وأقمشة',
            'معدات صناعية', 'مواد كيميائية', 'أدوات كهربائية', 'مستلزمات طبية',
            'مواد تعبئة وتغليف', 'أخرى'
        ],
        services: [
            'خدمات تقنية', 'خدمات تسويق', 'خدمات تصميم', 'خدمات استشارية',
            'خدمات تعليمية', 'خدمات صحية', 'خدمات قانونية', 'خدمات مالية',
            'خدمات سياحية', 'خدمات عقارية', 'أخرى'
        ]
    };

    // تغيير التصنيفات الفرعية عند تغيير التصنيف الرئيسي
    mainCategory?.addEventListener('change', function () {
        const selected = this.value;
        subCategory.innerHTML = '<option value="">اختر التصنيف</option>';
        if (subCategoryOptions[selected]) {
            subCategoryOptions[selected].forEach(option => {
                const el = document.createElement('option');
                el.value = option;
                el.textContent = option;
                subCategory.appendChild(el);
            });
        }
    });

    // معاينة شعار العمل قبل الرفع
    businessLogoInput?.addEventListener('change', function (e) {
        const file = e.target.files[0];
        const preview = document.getElementById('logoPreview');
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (event) {
                preview.src = event.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
            preview.src = '';
        }
    });

    // التعامل مع اختيار نوع الربط بشكل نظيف
    linkOptions.forEach(option => {
        option.addEventListener('click', function () {
            linkOptions.forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');

            // إخفاء جميع أقسام رفع الملفات
            document.querySelectorAll('.upload-section').forEach(section => {
                section.style.display = 'none';
            });

            const type = this.dataset.type;
            linkTypeInput.value = type;

            // عرض القسم المناسب فقط
            if (type === 'commercial') {
                const uploadSection = this.querySelector('.upload-section');
                if (uploadSection) {
                    uploadSection.style.display = 'block';
                    const inputFile = uploadSection.querySelector('input[type="file"]');
                    inputFile?.click();
                }
            } else if (type === 'freelance') {
                const uploadSection = this.querySelector('.upload-section');
                if (uploadSection) {
                    uploadSection.style.display = 'block';
                    const inputFile = uploadSection.querySelector('input[type="file"]');
                    inputFile?.click();
                }
            }
        });
    });

    // تفعيل الضغط اليدوي الصحيح على رفع السجل التجاري فقط من الزر (بدون تكرار)
    document.querySelector('label[for="commercialRegistry"]')?.addEventListener('click', function (e) {
        e.stopPropagation();
        document.getElementById('commercialRegistry')?.click();
    });

    // تفعيل الضغط اليدوي الصحيح على رفع وثيقة العمل الحر فقط من الزر (بدون تكرار)
    document.querySelector('label[for="freelanceDoc"]')?.addEventListener('click', function (e) {
        e.stopPropagation();
        document.getElementById('freelanceDoc')?.click();
    });

    // تحقق عند إرسال الفورم
    form?.addEventListener('submit', function (e) {
        const linkError = document.getElementById('linkError');
        linkError.style.display = 'none';
        linkError.textContent = '';

        if (!linkTypeInput.value) {
            e.preventDefault();
            linkError.textContent = 'يرجى اختيار طريقة ربط العمل.';
            linkError.style.display = 'block';
            return;
        }

        if (linkTypeInput.value === 'commercial' && (!commercialRegistryInput || !commercialRegistryInput.files.length)) {
            e.preventDefault();
            linkError.textContent = 'يرجى رفع السجل التجاري.';
            linkError.style.display = 'block';
            return;
        }

        if (linkTypeInput.value === 'freelance' && (!freelanceDocInput || !freelanceDocInput.files.length)) {
            e.preventDefault();
            linkError.textContent = 'يرجى رفع وثيقة العمل الحر.';
            linkError.style.display = 'block';
            return;
        }
    });
});
