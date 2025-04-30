document.addEventListener('DOMContentLoaded', function() {
    const mainCategory = document.getElementById('mainCategory');
    const subCategory = document.getElementById('subCategory');

    const subCategoryOptions = {
        retail: [
            { value: 'electronics', label: 'إلكترونيات وأجهزة' },
            { value: 'fashion', label: 'أزياء وملابس' },
            { value: 'food', label: 'مأكولات ومشروبات' },
            { value: 'beauty', label: 'مستحضرات تجميل' },
            { value: 'furniture', label: 'أثاث ومفروشات' },
            { value: 'books', label: 'كتب وقرطاسية' },
            { value: 'gifts', label: 'هدايا وألعاب' },
            { value: 'sports', label: 'رياضة ولياقة' },
            { value: 'home', label: 'منتجات منزلية' },
            { value: 'jewelry', label: 'مجوهرات واكسسوارات' },
            { value: 'other', label: 'أخرى' }
        ],
        wholesale: [
            { value: 'food-wholesale', label: 'مواد غذائية' },
            { value: 'construction', label: 'مواد بناء' },
            { value: 'furniture-wholesale', label: 'أثاث ومفروشات' },
            { value: 'spare-parts', label: 'قطع غيار' },
            { value: 'textiles', label: 'منسوجات وأقمشة' },
            { value: 'industrial', label: 'معدات صناعية' },
            { value: 'chemicals', label: 'مواد كيميائية' },
            { value: 'electrical', label: 'أدوات كهربائية' },
            { value: 'medical', label: 'مستلزمات طبية' },
            { value: 'packaging', label: 'مواد تعبئة وتغليف' },
            { value: 'other', label: 'أخرى' }
        ],
        services: [
            { value: 'tech', label: 'خدمات تقنية' },
            { value: 'marketing', label: 'خدمات تسويق' },
            { value: 'design', label: 'خدمات تصميم' },
            { value: 'consulting', label: 'خدمات استشارية' },
            { value: 'education', label: 'خدمات تعليمية' },
            { value: 'health', label: 'خدمات صحية' },
            { value: 'legal', label: 'خدمات قانونية' },
            { value: 'financial', label: 'خدمات مالية' },
            { value: 'tourism', label: 'خدمات سياحية' },
            { value: 'real-estate', label: 'خدمات عقارية' },
            { value: 'other', label: 'أخرى' }
        ]
    };

    mainCategory?.addEventListener('change', function() {
        const selectedCategory = this.value;
        subCategory.innerHTML = '<option value="">اختر التصنيف</option>';

        if (subCategoryOptions[selectedCategory]) {
            subCategoryOptions[selectedCategory].forEach(option => {
                const el = document.createElement('option');
                el.value = option.value;
                el.textContent = option.label;
                subCategory.appendChild(el);
            });
        }
    });

    // اعادة ملء التصنيفات عند تحميل الصفحة
    const initialMainCategory = mainCategory?.value;
    const initialSubCategory = subCategory?.dataset.selected;

    if (initialMainCategory && subCategoryOptions[initialMainCategory]) {
        subCategory.innerHTML = '<option value="">اختر التصنيف</option>';
        subCategoryOptions[initialMainCategory].forEach(option => {
            const el = document.createElement('option');
            el.value = option.value;
            el.textContent = option.label;
            if (option.value === initialSubCategory) {
                el.selected = true;
            }
            subCategory.appendChild(el);
        });
    }
});
