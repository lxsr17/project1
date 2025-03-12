
<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>منصة تحقق - دليلك لأفضل المتاجر الإلكترونية</title>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>
    <body>
    <script type="module" src="{{ asset('js/main.js') }}"></script>
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="/logo.svg" alt="تحقق">
            </div>
            <ul class="nav-links">
                <li><a href="/" class="active">الرئيسية</a></li>
                <li><a href="{{ route('stores') }}">متاجر تحقق</a></li>
                <li><a href="{{ route('contact') }}">تواصل معنا</a></li>
            </ul>
            <div class="auth-buttons">
                <button class="btn btn-outline" id="loginBtn">تسجيل الدخول</button>
                <button class="btn btn-primary" id="createAccountBtn">إنشاء حساب</button>
            </div>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="hero-content">
                <h1>منصة تحقق</h1>
                <p>دليلك لأفضل المتاجر الإلكترونية</p>
                <p class="subtitle">تخدم منصة تحقق جميع المتعاملين في التجارة الإلكترونية</p>
                
                <div class="search-container">
                    <form id="search-form" class="search-form">
                        <input type="text" placeholder="ابحث باسم المتجر أو برقم تحقق" name="q">
                        <button type="submit" class="search-btn">بحث</button>
                    </form>
                    <div id="search-results"></div>
                </div>
            </div>
            <div class="decorative-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
            </div>
        </section>

        <!-- Top Rated Stores Section -->
        <section class="top-stores" id="topStoresSection" style="display: none;">
            <h2>المتاجر الأفضل تقييماً</h2>
            <div class="stores-grid" id="topStoresGrid">
                <!-- Stores will be dynamically added here -->
            </div>
        </section>

        <!-- Benefits Section -->
        <section class="benefits">
            <h2>سجل تجارتك في تحقق</h2>
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/bullhorn.svg" alt="انتشار أكثر">
                    </div>
                    <h3>انتشار أكثر</h3>
                    <p>منصة تحقق تساعدك على انتشار تجارتك الإلكترونية ووصولك لعملائك المستهدفين</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/certificate.svg" alt="شهادة معتمدة">
                    </div>
                    <h3>شهادة معتمدة</h3>
                    <p>احصل على شهادة تحقق المعتمدة لتعزيز ثقة عملائك في متجرك</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/handshake.svg" alt="مصداقية أعلى">
                    </div>
                    <h3>مصداقية أعلى</h3>
                    <p>وثق مصداقية متجرك الإلكتروني من خلال منصة تحقق</p>
                </div>
            </div>
        </section>
    </main>

    <div class="modal" id="accountTypeModal">
        <div class="modal-content">
            <button class="modal-close" id="closeModal">×</button>
            <h2 class="modal-title">تسجيل الدخول</h2>
            <p class="modal-description" style="display: none;">اختار نوع حسابك من بين اختيارين للحصول على شهادة تحقق</p>
            <div class="account-type-buttons">
                <button class="account-type-btn merchant-btn">حساب تاجر</button>
                <button class="account-type-btn visitor-btn">حساب زائر</button>
            </div>
            <a href="#" class="login-link">ليس لديك حساب؟ إنشاء حساب جديد</a>
        </div>
    </div>

    


</body>
</html>