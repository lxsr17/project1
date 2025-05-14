import { insertUserHeader } from './components/user-header.js';

document.addEventListener('DOMContentLoaded', function() {
    // Insert user header
    insertUserHeader();

    const backBtn = document.getElementById('backBtn');
    const submitBtn = document.getElementById('submitBtn');
    const editBtns = document.querySelectorAll('.edit-btn');

    // Get business data from localStorage
    const businessData = JSON.parse(localStorage.getItem('businessData') || '{}');

    // Populate business information
    function populateBusinessInfo() {
        const businessInfo = document.getElementById('businessInfo');
        if (!businessInfo) return;

        businessInfo.innerHTML = `
            <div class="info-group">
                <h4>اسم العمل - اللغة العربية</h4>
                <p>${businessData.businessNameAr || '-'}</p>
            </div>
            <div class="info-group">
                <h4>اسم العمل - اللغة الإنجليزية</h4>
                <p>${businessData.businessNameEn || '-'}</p>
            </div>
            <div class="info-group">
                <h4>نوع العمل الرئيسي</h4>
                <p>${businessData.mainCategory || '-'}</p>
            </div>
            <div class="info-group">
                <h4>تصنيف العمل الفرعي</h4>
                <p>${businessData.subCategory || '-'}</p>
            </div>
            <div class="info-group full-width">
                <h4>وصف العمل</h4>
                <p>${businessData.businessDescription || '-'}</p>
            </div>
        `;
    }

    // Populate contact information
    function populateContactInfo() {
        const contactInfo = document.getElementById('contactInfo');
        if (!contactInfo) return;

        contactInfo.innerHTML = `
            <div class="info-group">
                <h4>البريد الإلكتروني</h4>
                <p>${businessData.email || '-'}</p>
            </div>
            <div class="info-group">
                <h4>رقم الجوال (الأساسي)</h4>
                <p>${businessData.phone || '-'}</p>
            </div>
            <div class="info-group">
                <h4>رقم المتجر</h4>
                <p>${businessData.storePhone || '-'}</p>
            </div>
            ${businessData.showPhone ? `
            <div class="info-group">
                <h4>رقم جوال خدمة العملاء</h4>
                <p>${businessData.customerServicePhone || '-'}</p>
            </div>
            ` : ''}
        `;
    }

    // Populate policies information
    function populatePoliciesInfo() {
        const policiesInfo = document.getElementById('policiesInfo');
        if (!policiesInfo) return;

        if (businessData.noReturn) {
            policiesInfo.innerHTML = `
                <div class="info-group full-width">
                    <p>لا يمكن الاستبدال والاسترجاع وفقاً لطبيعة المنتج أو الخدمة المقدمة</p>
                </div>
            `;
        } else {
            policiesInfo.innerHTML = `
                <div class="info-group full-width">
                    <h4>سياسة الاستبدال والاسترجاع</h4>
                    <p>${businessData.returnPolicy || '-'}</p>
                </div>
                <div class="info-group">
                    <h4>عدد أيام الاسترجاع</h4>
                    <p>${businessData.returnDays || '0'} يوم</p>
                </div>
                <div class="info-group">
                    <h4>عدد أيام الاستبدال</h4>
                    <p>${businessData.exchangeDays || '0'} يوم</p>
                </div>
            `;
        }
    }

    // Populate additional information
    function populateAdditionalInfo() {
        const additionalInfo = document.getElementById('additionalInfo');
        if (!additionalInfo) return;
        
        // Social media section
        let socialHtml = `
            <div class="info-group full-width">
                <h4>حسابات التواصل الاجتماعي</h4>
                <div class="social-links">
        `;

        if (businessData.twitter) {
            socialHtml += `
                <a href="${businessData.twitter}" class="social-link" target="_blank">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/brands/twitter.svg" alt="Twitter">
                    تويتر ${businessData.showTwitter ? '(يظهر في المتجر)' : ''}
                </a>
            `;
        }

        if (businessData.instagram) {
            socialHtml += `
                <a href="${businessData.instagram}" class="social-link" target="_blank">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/brands/instagram.svg" alt="Instagram">
                    انستقرام ${businessData.showInstagram ? '(يظهر في المتجر)' : ''}
                </a>
            `;
        }

        if (businessData.tiktok) {
            socialHtml += `
                <a href="${businessData.tiktok}" class="social-link" target="_blank">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/brands/tiktok.svg" alt="TikTok">
                    تيك توك ${businessData.showTiktok ? '(يظهر في المتجر)' : ''}
                </a>
            `;
        }

        socialHtml += `
                </div>
            </div>
        `;

        // Platform links section
        let platformsHtml = `
            <div class="info-group full-width">
                <h4>منصات العمل</h4>
                <div class="social-links">
        `;

        if (businessData.website) {
            platformsHtml += `
                <a href="${businessData.website}" class="social-link" target="_blank">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/globe.svg" alt="Website">
                    الموقع الإلكتروني
                </a>
            `;
        }

        if (businessData.androidApp) {
            platformsHtml += `
                <a href="${businessData.androidApp}" class="social-link" target="_blank">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/brands/android.svg" alt="Android">
                    تطبيق Android
                </a>
            `;
        }

        if (businessData.iosApp) {
            platformsHtml += `
                <a href="${businessData.iosApp}" class="social-link" target="_blank">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/brands/apple.svg" alt="iOS">
                    تطبيق iOS
                </a>
            `;
        }

        if (businessData.whatsapp) {
            platformsHtml += `
                <a href="${businessData.whatsapp}" class="social-link" target="_blank">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/brands/whatsapp.svg" alt="WhatsApp">
                    واتساب
                </a>
            `;
        }

        if (businessData.telegram) {
            platformsHtml += `
                <a href="${businessData.telegram}" class="social-link" target="_blank">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/brands/telegram.svg" alt="Telegram">
                    تليجرام
                </a>
            `;
        }

        platformsHtml += `
                </div>
            </div>
        `;

        additionalInfo.innerHTML = socialHtml + platformsHtml;
    }

    // Initialize all sections
    populateBusinessInfo();
    populateContactInfo();
    populatePoliciesInfo();
    populateAdditionalInfo();

    // Handle edit buttons
    editBtns.forEach(btn => {
        btn?.addEventListener('click', function() {
            const section = this.dataset.section;
            const pages = {
                business: './add-business.html',
                contact: './business-contact.html',
                policies: './business-policies.html',
                additional: './business-additional.html'
            };
            window.location.href = pages[section];
        });
    });

    // Handle back button
    backBtn?.addEventListener('click', () => {
        window.location.href = './business-additional.html';
    });

    // Handle submit button
    submitBtn?.addEventListener('click', async () => {
        try {
            // Store the business data for the success page
            localStorage.setItem('newBusiness', JSON.stringify(businessData));
            
            // Clear the form data
            localStorage.removeItem('businessData');
            
            // Navigate to success page
            window.location.href = './business-success.html';
        } catch (error) {
            console.error('Error:', error);
            alert('حدث خطأ أثناء إنشاء العمل');
        }
    });
});