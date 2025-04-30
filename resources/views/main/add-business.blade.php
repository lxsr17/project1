<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة عمل جديد - منصة تحقق</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add-business.css') }}">
</head>
<body>

@php
    $storeOwner = Auth::guard('store_owner')->user();
@endphp

<header>
    @include('main.user-header')
</header>

<div class="dashboard">
    @include('layouts.sidebar')

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
                <form id="addBusinessForm" action="{{ route('business.storeStep1') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- شعار العمل -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <img src="{{ asset('images/icons/store.svg') }}" alt="">
                            شعار العمل (اختياري)
                        </h3>
                        <div class="form-grid">
                            <div class="form-group full-width logo-upload-wrapper">
                                <label for="businessLogo">الشعار</label>
                                <div class="logo-input-preview">
                                    <input type="file" id="businessLogo" name="businessLogo" accept="image/*">
                                    <img id="logoPreview" src="#" alt="معاينة الشعار" style="display: none;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- بيانات العمل -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <img src="{{ asset('images/icons/info-circle.svg') }}" alt="">
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
                                </select>
                            </div>
                            <div class="form-group full-width">
                                <label for="businessDescription">وصف العمل</label>
                                <textarea id="businessDescription" name="businessDescription" required></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ربط العمل -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <img src="{{ asset('images/icons/link.svg') }}" alt="">
                            ربط العمل
                        </h3>
                        <div id="linkError" style="color: red; margin-top: 10px; display: none; font-size: 0.9rem;"></div>
                        <div class="link-options">
                            <div class="link-option" data-type="commercial">
                                <img src="{{ asset('https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/store.svg') }}" alt="">
                                <h4>الربط بالسجل التجاري</h4>
                                <p>يتطلب وجود سجل تجاري والحصول على شهادة تحقق</p>
                                <div class="upload-section" style="display:none;">
                                    <label for="commercialRegistry" class="upload-label">
                                        <img src="{{ asset('https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/upload.svg') }}" alt="">
                                        <span>رفع السجل التجاري</span>
                                    </label>
                                    <input type="file" id="commercialRegistry" name="commercialRegistry" accept=".pdf,.jpg,.jpeg,.png" style="display:none;">
                                </div>
                            </div>

                            <div class="link-option" data-type="freelance">
                                <img src="{{ asset('https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/file-contract.svg') }}" alt="">
                                <h4>الربط بوثيقة العمل الحر</h4>
                                <p>يتطلب وجود وثيقة عمل حر والحصول على شهادة تحقق</p>
                                <div class="upload-section" style="display:none;">
                                    <label for="freelanceDoc" class="upload-label">
                                        <img src="{{ asset('https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/upload.svg') }}" alt="">
                                        <span>رفع وثيقة العمل الحر</span>
                                    </label>
                                    <input type="file" id="freelanceDoc" name="freelanceDoc" accept=".pdf,.jpg,.jpeg,.png" style="display:none;">
                                </div>
                            </div>

                            <div class="link-option" data-type="later">
                                <img src="{{ asset('https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/clock.svg') }}" alt="">
                                <h4>الربط لاحقاً</h4>
                                <p>لن يتم إصدار شهادة تحقق حتى يتم الربط بالسجل التجاري أو وثيقة العمل الحر</p>
                            </div>
                        </div>

                        <input type="hidden" id="linkType" name="linkType">
                    </div>

                    <!-- أزرار الإرسال -->
                    <div class="form-actions">
                        <button type="button" class="btn-cancel" id="cancelBtn">إلغاء</button>
                        <button type="submit" class="btn-next">التالي</button>
                    </div>

                </form>
            </div>
        </div>
    </main>
</div>

<!-- سكربتات الصفحة -->
<script type="module" src="{{ asset('js/user-header.js') }}"></script>
<script type="module" src="{{ asset('js/add-business.js') }}"></script>

</body>
</html>
