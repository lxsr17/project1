<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أعمالي - منصة تحقق</title>
    <link rel="stylesheet" href="{{ asset('css/my-businesses.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <nav>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="./merchant-dashboard" class="nav-link">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/home.svg" alt="">
                            <span>الصفحة الرئيسية</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./my-businesses" class="nav-link active">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/briefcase.svg" alt="">
                            <span>أعمالي</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./subscriptions" class="nav-link">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/credit-card.svg" alt="">
                            <span>اشتراكاتي</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./stores" class="nav-link">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/store.svg" alt="">
                            <span>متاجر تحقق</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./about" class="nav-link">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/circle-info.svg" alt="">
                            <span>عن تحقق</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./faq" class="nav-link">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/book.svg" alt="">
                            <span>الأسئلة الشائعة</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./privacy" class="nav-link">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/shield.svg" alt="">
                            <span>سياسة الخصوصية</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./terms" class="nav-link">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/book-open.svg" alt="">
                            <span>شروط الاستخدام</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./contact" class="nav-link">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/phone.svg" alt="">
                            <span>تواصل معنا</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="businesses-page">
            <div class="page-header">
                <h1 class="page-title">أعمالي</h1>
                <button class="add-business-btn" id="addBusinessBtn">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/plus.svg" alt="">
                    <span>إضافة عمل جديد</span>
                </button>
            </div>

            <p class="results-count">تم العثور على 0 متجر</p>

            <div class="businesses-grid">
                <!-- Empty state message -->
                <div class="empty-state">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/store.svg" alt="Empty state" class="empty-icon">
                    <h2>لا يوجد لديك أي أعمال حالياً</h2>
                    <p>ابدأ بإضافة عملك الأول على منصة تحقق</p>
                    <button class="btn btn-primary" onclick="window.location.href='./add-business'">إضافة عمل جديد</button>
                </div>
            </div>
        </main>
    </div>

    <script type="module" src="{{ asset('js/user-header.js') }}"></script>
    <script type="module" src="{{ asset('js/my-businesses.js') }}"></script>
</body>
</html>