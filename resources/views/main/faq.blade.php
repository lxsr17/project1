<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الأسئلة الشائعة - منصة تحقق</title>
   
    <link rel="stylesheet" href="{{ asset('css/faq.css') }}">
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
                        <a href="./my-businesses" class="nav-link">
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
                        <a href="./faq" class="nav-link active">
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
        <main class="faq-page">
            <div class="page-header">
                <h1 class="page-title">الأسئلة الشائعة</h1>
                <!-- Admin Controls -->
                <div class="admin-controls" id="adminControls" style="display: none;">
                    <button class="btn btn-primary" id="addFaqBtn">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/plus.svg" alt="">
                        إضافة سؤال جديد
                    </button>
                </div>
            </div>

            <div class="faq-container">
                <div class="faq-list" id="faqList">
                    <!-- FAQ items will be dynamically inserted here -->
                </div>
            </div>
        </main>
    </div>

    <!-- Add/Edit FAQ Modal -->
    <div class="modal" id="faqModal">
        <div class="modal-content">
            <button class="modal-close" id="closeModal">×</button>
            <h2 class="modal-title" id="modalTitle">إضافة سؤال جديد</h2>
            <form id="faqForm">
                <input type="hidden" id="faqId" name="faqId">
                <div class="form-group">
                    <label for="question">السؤال</label>
                    <input type="text" id="question" name="question" required>
                </div>
                <div class="form-group">
                    <label for="answer">الإجابة</label>
                    <textarea id="answer" name="answer" rows="6" required></textarea>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-outline" id="cancelBtn">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>

    
    <script type="module" src="{{ asset('js/user-header.js') }}"></script>
    <script type="module" src="{{ asset('js/faq.js') }}"></script>
</body>
</html>