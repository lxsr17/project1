<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>متاجر تحقق</title>
    <link rel="stylesheet" href="{{ asset('css/stores.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<script type="module" src="{{ asset('js/stores.js') }}"></script>
    <!-- Header with Auth Buttons -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="/logo.svg" alt="تحقق">
            </div>
            <ul class="nav-links">
                <li><a href="/">الرئيسية</a></li>
                <li><a href="{{ route('stores') }}" class="active">متاجر تحقق</a></li>
                <li><a href="{{ route('contact') }}">تواصل معنا</a></li>
            </ul>
            <div class="auth-buttons">
                <button class="btn btn-outline" id="loginBtn">تسجيل الدخول</button>
                <button class="btn btn-primary" id="createAccountBtn">إنشاء حساب</button>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="stores-page guest-view">
        <div class="search-section">
            <div class="search-container">
                <form id="stores-search-form" class="search-form">
                    <div class="search-input-wrapper">
                        <input type="text" placeholder="ابحث باسم المتجر أو برقم تحقق" name="q">
                    </div>
                    <button type="submit" class="search-btn">بحث</button>
                </form>
            </div>
        </div>

        <div class="stores-content">
            <aside class="filters-sidebar">
                <div class="filter-section">
                    <h3>نوع الشهادة</h3>
                    <div class="certificate-type">
                        <label>
                            <input type="radio" name="certificate" value="gold">
                            <span class="certificate-label gold">الشهادة الذهبية</span>
                        </label>
                        <label>
                            <input type="radio" name="certificate" value="silver">
                            <span class="certificate-label silver">الشهادة الفضية</span>
                        </label>
                    </div>
                </div>

                <div class="filter-section">
                    <h3>تصنيف العمل</h3>
                    <select class="filter-select">
                        <option value="">اختر التصنيف</option>
                        <option value="electronics">إلكترونيات</option>
                        <option value="fashion">أزياء</option>
                        <option value="food">مأكولات</option>
                        <option value="design">تصميم وطباعة</option>
                    </select>
                </div>

                <div class="filter-section">
                    <h3>الموقع</h3>
                    <select class="filter-select">
                        <option value="">اختر المدينة</option>
                        <option value="riyadh">الرياض</option>
                        <option value="jeddah">جدة</option>
                        <option value="dammam">الدمام</option>
                    </select>
                </div>

                <button class="btn btn-primary filter-apply">تطبيق التصفية</button>
            </aside>

            <section class="stores-list">
                <div class="stores-header">
                    <h2>متاجر تحقق</h2>
                    <div class="stores-stats">
                        <span>عدد النتائج: 0</span>
                        <div class="sort-options">
                            <a href="#" class="sort-link active">الأحدث</a>
                            <a href="#" class="sort-link">الأفضل تقييماً</a>
                            <a href="#" class="sort-link">الأكثر تقييماً</a>
                        </div>
                    </div>
                </div>

                <div class="stores-grid">
                    <!-- Store cards will be dynamically added here -->
                </div>

                <div class="pagination">
                    <!-- Pagination will be dynamically added here -->
                </div>
            </section>
        </div>
    </main>

    <!-- Account Type Modal -->
    <div class="modal" id="accountTypeModal">
        <div class="modal-content">
            <button class="modal-close" id="closeModal">×</button>
            <h2 class="modal-title">تسجيل الدخول</h2>
            <p class="modal-description" style="display: none;">اختار نوع حسابك من بين اختيارين للحصول على شهادة تحقق</p>
            <div class="account-type-buttons">
                <button class="account-type-btn merchant-btn">حساب تاجر</button>
                <button class="account-type-btn visitor-btn">حساب زائر</button>
            </div>
            <a href="#" class="login-link">ليس لديك حساب؟ إنشاء حساب</a>
        </div>
    </div>

   
</body>
</html>
