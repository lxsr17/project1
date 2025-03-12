<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - منصة تحقق</title>
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
                        <a href="./merchant-dashboard.html" class="nav-link active">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/home.svg" alt="">
                            <span>الصفحة الرئيسية</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./my-businesses.html" class="nav-link">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/briefcase.svg" alt="">
                            <span>أعمالي</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./subscriptions.html" class="nav-link">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/credit-card.svg" alt="">
                            <span>اشتراكاتي</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./stores.html" class="nav-link">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/store.svg" alt="">
                            <span>متاجر تحقق</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./about.html" class="nav-link">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/circle-info.svg" alt="">
                            <span>عن تحقق</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./faq.html" class="nav-link">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/book.svg" alt="">
                            <span>الأسئلة الشائعة</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./privacy.html" class="nav-link">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/shield.svg" alt="">
                            <span>سياسة الخصوصية</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./terms.html" class="nav-link">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/book-open.svg" alt="">
                            <span>شروط الاستخدام</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./contact.html" class="nav-link">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/phone.svg" alt="">
                            <span>تواصل معنا</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header">
                <h1 class="page-title">خدمات تحقق الإلكترونية</h1>
                <p class="page-description">تعرف على الخدمات التي تساعدك على إدارة تجارتك الإلكترونية</p>
            </div>
        </main>
    </div>

    <script type="module" src="{{ asset('js/user-header.js') }}"></script>
    <script type="module" src="{{ asset('js/merchant-dashboard.js') }}"></script>

    
</body>
</html>