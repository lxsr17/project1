<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة عمل جديد - منصة تحقق</title>
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
                    <div class="step active">
                        <div class="step-number">1</div>
                        <span class="step-text">بيانات العمل</span>
                    </div>
                    <div class="step">
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
                    <form id="addBusinessForm">
                        <div class="form-section">
                            <h3 class="form-section-title">
                                <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/store.svg" alt="">
                                شعار العمل (اختياري)
                            </h3>
                            <div class="form-grid">
                                <div class="form-group full-width">
                                    <label for="businessLogo">الشعار</label>
                                    <input type="file" id="businessLogo" name="businessLogo" accept="image/*">
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h3 class="form-section-title">
                                <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/info-circle.svg" alt="">
                                بيانات العمل
                            </h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="businessNameAr">اسم العمل - اللغة العربية</label>
                                    <input type="text" id="businessNameAr" name="businessNameAr" required>
                                </div>

                                <div class="form-group">
                                    <label for="businessNameEn">اسم العمل - اللغة الإنجليزية</label>
                                    <input type="text" id="businessNameEn" name="businessNameEn" required>
                                </div>

                                <div class="form-group">
                                    <label for="mainCategory">نوع العمل الرئيسي</label>
                                    <select id="mainCategory" name="mainCategory" required>
                                        <option value="">اختر التصنيف</option>
                                        <option value="retail">متجر تجزئة</option>
                                        <option value="wholesale">متجر جملة</option>
                                        <option value="services">خدمات</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="subCategory">تصنيف العمل الفرعي</label>
                                    <select id="subCategory" name="subCategory" required>
                                        <option value="">اختر التصنيف</option>
                                        <option value="">علي مرزوق </option>
                                    </select>
                                </div>

                                <div class="form-group full-width">
                                    <label for="businessDescription">وصف العمل</label>
                                    <textarea id="businessDescription" name="businessDescription" required></textarea>
                                </div>
                            </div>
                        </div>
<!--
                        <div class="form-section">
                            <h3 class="form-section-title">
                                <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/link.svg" alt="">
                                ربط العمل
                            </h3>
                            <div class="link-options">
                                <div class="link-option" data-type="commercial">
                                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/store.svg" alt="">
                                    <h4>الربط بالسجل التجاري</h4>
                                    <p>يتطلب وجود سجل تجاري والحصول على شهادة تحقق</p>
                                    <div class="upload-section" style="display: none;">
                                        <label for="commercialRegistry" class="upload-label">
                                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/upload.svg" alt="">
                                            <span>رفع السجل التجاري</span>
                                        </label>
                                        <input type="file" id="commercialRegistry" name="commercialRegistry" accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                        <div class="file-info" style="display: none;">
                                            <span class="file-name"></span>
                                            <button type="button" class="remove-file">×</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="link-option" data-type="freelance">
                                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/file-contract.svg" alt="">
                                    <h4>الربط بوثيقة العمل الحر</h4>
                                    <p>يتطلب وجود وثيقة عمل حر والحصول على شهادة تحقق</p>
                                    <div class="upload-section" style="display: none;">
                                        <label for="freelanceDoc" class="upload-label">
                                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/upload.svg" alt="">
                                            <span>رفع وثيقة العمل الحر</span>
                                        </label>
                                        <input type="file" id="freelanceDoc" name="freelanceDoc" accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                        <div class="file-info" style="display: none;">
                                            <span class="file-name"></span>
                                            <button type="button" class="remove-file">×</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="link-option" data-type="later">
                                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/clock.svg" alt="">
                                    <h4>الربط لاحقاً</h4>
                                    <p>لن يتم إصدار شهادة تحقق حتى يتم الربط بالسجل التجاري أو وثيقة العمل الحر</p>
                                </div>
                            </div>
                        </div>
-->

                        <div class="form-actions">
                            <button type="button" class="btn-cancel" id="cancelBtn">إلغاء</button>
                            <button type="submit" class="btn-next">التالي</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script type="module" src="{{ asset('js/user-header.js') }}"></script>
    <script type="module" src="{{ asset('js/add-business.js') }}"></script>

</body>
</html>