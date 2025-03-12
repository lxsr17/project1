document.addEventListener('DOMContentLoaded', function() {
    const loginContainer = document.querySelector('.login-container');
    const loginForm = document.getElementById('loginForm');
    const accountTypeModal = document.getElementById('accountTypeModal');
    const showRegisterOptions = document.getElementById('showRegisterOptions');
    const closeModal = document.getElementById('closeModal');
    const merchantLoginBtn = document.getElementById('merchantLoginBtn');
    const visitorLoginBtn = document.getElementById('visitorLoginBtn');

    // تعريف المتغير global لحفظ نوع الحساب
    let selectedAccountType = null;

    // عرض مودال اختيار نوع الحساب عند تحميل الصفحة
    accountTypeModal.classList.add('active');

    // إغلاق المودال عند الضغط على الزر
    closeModal?.addEventListener('click', () => {
        window.location.href = './';
    });

    // إغلاق المودال عند النقر خارج المحتوى
    accountTypeModal?.addEventListener('click', (e) => {
        if (e.target === accountTypeModal) {
            window.location.href = './';
        }
    });

    // تسجيل دخول التاجر
    merchantLoginBtn?.addEventListener('click', () => {
        selectedAccountType = 'merchant'; // تعيين نوع الحساب إلى 'تاجر'
       // console.log('تم اختيار نوع الحساب:', selectedAccountType); // تأكيد اختيار نوع الحساب
        accountTypeModal.classList.remove('active');
        loginContainer.style.display = 'block';
    });

    // تسجيل دخول الزائر
    visitorLoginBtn?.addEventListener('click', () => {
        selectedAccountType = 'visitor'; // تعيين نوع الحساب إلى 'زائر'
       // console.log('تم اختيار نوع الحساب:', selectedAccountType); // تأكيد اختيار نوع الحساب
        accountTypeModal.classList.remove('active');
        loginContainer.style.display = 'block';
    });

    // عرض خيارات التسجيل
    showRegisterOptions?.addEventListener('click', (e) => {
        e.preventDefault();
        loginContainer.style.display = 'none';
        const registerModal = document.createElement('div');
        registerModal.className = 'modal active';
        registerModal.innerHTML = `
            <div class="modal-content">
                <button class="modal-close" onclick="this.parentElement.parentElement.remove()">×</button>
                <h2 class="modal-title">إنشاء حساب جديد</h2>
                <p class="modal-description">اختر نوع الحساب الذي تريد إنشاءه</p>
                <div class="account-type-buttons">
                    <button class="account-type-btn merchant-btn" onclick="window.location.href='./merchant-register.html'">حساب تاجر</button>
                    <button class="account-type-btn visitor-btn" onclick="window.location.href='./register.html'">حساب زائر</button>
                </div>
            </div>
        `;
        document.body.appendChild(registerModal);

        registerModal.addEventListener('click', (e) => {
            if (e.target === registerModal) {
                registerModal.remove();
                loginContainer.style.display = 'block';
            }
        });
    });

    // التحقق من بيانات تسجيل الدخول
    loginForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const email = loginForm.email.value;
        const password = loginForm.password.value;
        console.log('إرسال البيانات:', { email, password, accountType: selectedAccountType });
    
        // مباشرةً بعد إرسال البيانات، التوجيه إلى /dashboard
        window.location.href = '/merchant-dashboard';
    });
    
});