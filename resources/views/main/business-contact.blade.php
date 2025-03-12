<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بيانات التواصل - منصة تحقق</title>
    <link rel="stylesheet" href="{{ asset('css/business-contact.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add-business.css') }}">
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
        <main class="add-business-page">
            <div class="steps-container">
                <!-- Progress Steps -->
                <div class="progress-steps">
                    <div class="step completed">
                        <div class="step-number">1</div>
                        <span class="step-text">بيانات العمل</span>
                    </div>
                    <div class="step active">
                        <div class="step-number">2</div>
                        <span class="step-text">بيانات التواصل</span>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <span class="step-text">سياسة الاسترجاع والشحن</span>
                    </div>
                    <div class="step">
                        <div class="step-number">4</div>
                        <span class="step-text">البيانات الإضافية</span>
                    </div>
                    <div class="step">
                        <div class="step-number">5</div>
                        <span class="step-text">المراجعة</span>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="form-content">
                    <form id="businessContactForm" class="contact-form">
                        <div class="form-section">
                            <h3 class="form-section-title">
                                <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/address-book.svg" alt="">
                                بيانات التواصل
                            </h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="email">البريد الإلكتروني</label>
                                    <input type="email" id="email" name="email" placeholder="Example@address.com" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone">رقم الجوال (الأساسي)</label>
                                    <input type="tel" id="phone" name="phone" pattern="05[0-9]{8}" placeholder="05XXXXXXXX" required>
                                    <div class="checkbox-group">
                                        <input type="checkbox" id="showPhone" name="showPhone">
                                        <label for="showPhone">إظهار رقم الجوال في صفحة المتجر</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="storePhone">رقم المتجر</label>
                                    <input type="tel" id="storePhone" name="storePhone" placeholder="800XXXXXXX أو 05XXXXXXXX">
                                    <span class="info-icon" title="رقم المتجر الذي سيظهر للعملاء">ⓘ</span>
                                </div>
                                <div class="form-group" id="customerServicePhoneGroup">
                                    <label for="customerServicePhone">رقم جوال خدمة العملاء (اختياري)</label>
                                    <input type="tel" id="customerServicePhone" name="customerServicePhone" pattern="05[0-9]{8}" placeholder="05XXXXXXXX">
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn-back" id="backBtn">السابق</button>
                            <button type="submit" class="btn-next">التالي</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script type="module" src="{{ asset('js/user-header.js') }}"></script>
    <script type="module" src="{{ asset('js/business-contact.js') }}"></script>
    
</body>
</html>