import { insertUserHeader } from './components/user-header.js';
import { compressImage } from './utils/image-utils.js';

document.addEventListener('DOMContentLoaded', function() {
    // Insert user header
    insertUserHeader();

    const form = document.getElementById('addBusinessForm');
    const cancelBtn = document.getElementById('cancelBtn');
    const mainCategory = document.getElementById('mainCategory');
    const subCategory = document.getElementById('subCategory');
    const linkOptions = document.querySelectorAll('.link-option');
    const commercialRegistryInput = document.getElementById('commercialRegistry');
    const freelanceDocInput = document.getElementById('freelanceDoc');
    const fileInfos = document.querySelectorAll('.file-info');
    const fileNames = document.querySelectorAll('.file-name');
    const removeFileBtns = document.querySelectorAll('.remove-file');
    const businessLogoInput = document.getElementById('businessLogo');

    // Handle logo upload with compression
    businessLogoInput?.addEventListener('change', async function(e) {
        const file = e.target.files[0];
        if (file) {
            try {
                // Compress image before storing
                const compressedImage = await compressImage(file, {
                    maxWidth: 800,
                    maxHeight: 800,
                    quality: 0.8
                });
                
                // Store compressed image data
                const reader = new FileReader();
                reader.onload = function(e) {
                    localStorage.setItem('tempBusinessLogo', e.target.result);
                };
                reader.readAsDataURL(compressedImage);
            } catch (error) {
                console.error('Error compressing image:', error);
                alert('حدث خطأ أثناء معالجة الصورة');
            }
        }
    });

    // Handle link option selection
    linkOptions.forEach(option => {
        option.addEventListener('click', function() {
            linkOptions.forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            
            document.querySelectorAll('.upload-section').forEach(section => {
                section.style.display = 'none';
            });
            
            const type = this.dataset.type;
            if (type === 'commercial' || type === 'freelance') {
                const uploadSection = this.querySelector('.upload-section');
                if (uploadSection) {
                    uploadSection.style.display = 'block';
                }
            }
        });
    });

    // Handle file upload with size check
    [commercialRegistryInput, freelanceDocInput].forEach((input, index) => {
        if (input) {
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Check file size (max 5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('حجم الملف يجب أن لا يتجاوز 5 ميجابايت');
                        input.value = '';
                        return;
                    }

                    const fileInfo = fileInfos[index];
                    const fileName = fileNames[index];
                    if (fileInfo && fileName) {
                        fileName.textContent = file.name;
                        fileInfo.style.display = 'flex';
                    }
                }
            });
        }
    });

    // Handle file removal
    removeFileBtns.forEach((btn, index) => {
        if (btn) {
            btn.addEventListener('click', function() {
                const input = index === 0 ? commercialRegistryInput : freelanceDocInput;
                const fileInfo = fileInfos[index];
                if (input && fileInfo) {
                    input.value = '';
                    fileInfo.style.display = 'none';
                }
            });
        }
    });

    // Handle category changes
    mainCategory?.addEventListener('change', function() {
        const value = this.value;
        subCategory.innerHTML = '<option value="">اختر التصنيف</option>';
        
        if (value === 'retail') {
            const options = [
                'إلكترونيات وأجهزة',
                'أزياء وملابس',
                'مأكولات ومشروبات',
                'مستحضرات تجميل'
            ];
            options.forEach(option => {
                const el = document.createElement('option');
                el.value = option;
                el.textContent = option;
                subCategory.appendChild(el);
            });
        } else if (value === 'wholesale') {
            const options = [
                'مواد غذائية',
                'مواد بناء',
                'أثاث ومفروشات',
                'قطع غيار'
            ];
            options.forEach(option => {
                const el = document.createElement('option');
                el.value = option;
                el.textContent = option;
                subCategory.appendChild(el);
            });
        } else if (value === 'services') {
            const options = [
                'خدمات تقنية',
                'خدمات تسويق',
                'خدمات تصميم',
                'خدمات استشارية'
            ];
            options.forEach(option => {
                const el = document.createElement('option');
                el.value = option;
                el.textContent = option;
                subCategory.appendChild(el);
            });
        }
    });

    // Handle form submission
    form?.addEventListener('submit', async function(e) {
        e.preventDefault();
/*
        const selectedLinkOption = document.querySelector('.link-option.selected');
        if (!selectedLinkOption) {
            alert('الرجاء اختيار طريقة ربط العمل');
            return;
        }

        const linkType = selectedLinkOption.dataset.type;
        const formData = new FormData(form);
        formData.append('linkType', linkType);

        // Check if document upload is required but not uploaded
        if (linkType === 'commercial' && commercialRegistryInput && !commercialRegistryInput.files[0]) {
            alert('الرجاء رفع ملف السجل التجاري');
            return;
        }

        if (linkType === 'freelance' && freelanceDocInput && !freelanceDocInput.files[0]) {
            alert('الرجاء رفع وثيقة العمل الحر');
            return;
        }
*/
        try {
            // Get essential form data only
            const essentialData = {
                businessNameAr: formData.get('businessNameAr'),
                businessNameEn: formData.get('businessNameEn'),
                mainCategory: formData.get('mainCategory'),
                subCategory: formData.get('subCategory'),
                businessDescription: formData.get('businessDescription'),
                linkType,
                logo: localStorage.getItem('tempBusinessLogo') || null
            };

            // Store essential data
            localStorage.setItem('businessData', JSON.stringify(essentialData));
            
            // Clean up temporary storage
            localStorage.removeItem('tempBusinessLogo');

            // Navigate to contact information page
            window.location.href = './business-contact';
        } catch (error) {
            console.error('Error:', error);
            alert('حدث خطأ أثناء حفظ بيانات العمل');
        }
    });

    // Handle cancel button
    cancelBtn?.addEventListener('click', () => {
        if (confirm('هل أنت متأكد من إلغاء إضافة العمل؟')) {
            // Clean up any temporary storage
            localStorage.removeItem('tempBusinessLogo');
            localStorage.removeItem('businessData');
            window.location.href = './my-businesses';
        }
    });
});