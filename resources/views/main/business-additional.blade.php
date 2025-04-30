<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>البيانات الإضافية - منصة تحقق</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add-business.css') }}">
    <link rel="stylesheet" href="{{ asset('css/business-additional.css') }}">
</head>
<header>
            @include('main.user-header')
        </header>
<body>

@php session()->forget('_old_input'); @endphp


<div class="dashboard">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="add-business-page">
            <div class="steps-container">
                <!-- Progress Steps -->
                <div class="progress-steps">
                    <div class="step completed">
                        <div class="step-number">1</div>
                        <span class="step-text">بيانات العمل</span>
                    </div>
                    <div class="step completed">
                        <div class="step-number">2</div>
                        <span class="step-text">بيانات التواصل</span>
                    </div>
                    <div class="step completed">
                        <div class="step-number">3</div>
                        <span class="step-text">سياسة الاسترجاع والشحن</span>
                    </div>
                    <div class="step active">
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
                <form id="businessAdditionalForm" action="{{ route('business-additional.store') }}" method="POST">
                @csrf
                        <div class="form-section">
                            <h3 class="form-section-title">
                                <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/share-nodes.svg" alt="">
                                التواصل الإلكتروني (يجب إضافة حساب واحد على الأقل)
                            </h3>
                            
                            <!-- Twitter -->
                            <div class="social-input-group">
                                <div class="social-icon">
                                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/brands/twitter.svg" alt="Twitter">
                                </div>
                                <div class="input-wrapper">
                                    <input type="text" id="twitter" name="twitter" placeholder="أدخل رابط حساب تويتر">
                                    <div class="input-actions">
                                        <button type="button" class="help-btn" title="مساعدة">
                                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/circle-info.svg" alt="Help">
                                        </button>
                                        <div class="checkbox-wrapper">
                                            <input type="checkbox" id="showTwitter" name="showTwitter">
                                            <label for="showTwitter">العرض من داخل المتجر</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Instagram -->
                            <div class="social-input-group">
                                <div class="social-icon">
                                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/brands/instagram.svg" alt="Instagram">
                                </div>
                                <div class="input-wrapper">
                                    <input type="text" id="instagram" name="instagram" placeholder="أدخل رابط حساب انستقرام">
                                    <div class="input-actions">
                                        <button type="button" class="help-btn" title="مساعدة">
                                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/circle-info.svg" alt="Help">
                                        </button>
                                        <div class="checkbox-wrapper">
                                            <input type="checkbox" id="showInstagram" name="showInstagram">
                                            <label for="showInstagram">العرض من داخل المتجر</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TikTok -->
                            <div class="social-input-group">
                                <div class="social-icon">
                                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/brands/tiktok.svg" alt="TikTok">
                                </div>
                                <div class="input-wrapper">
                                    <input type="text" id="tiktok" name="tiktok" placeholder="أدخل رابط حساب تيك توك">
                                    <div class="input-actions">
                                        <button type="button" class="help-btn" title="مساعدة">
                                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/circle-info.svg" alt="Help">
                                        </button>
                                        <div class="checkbox-wrapper">
                                            <input type="checkbox" id="showTiktok" name="showTiktok">
                                            <label for="showTiktok">العرض من داخل المتجر</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h3 class="form-section-title">
                                <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/mobile-screen.svg" alt="">
                                منصات العمل
                            </h3>
                            
                            <!-- Website -->
                            <div class="platform-input-group">
                                <label>الموقع الإلكتروني</label>
                                <div class="input-wrapper">
                                    <input type="url" id="website" name="website" placeholder="أدخل رابط الموقع الإلكتروني">
                                    <button type="button" class="help-btn" title="مساعدة">
                                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/circle-info.svg" alt="Help">
                                    </button>
                                </div>
                            </div>

                            <!-- Android App -->
                            <div class="platform-input-group">
                                <label>رابط تحميل التطبيق نظام Android</label>
                                <div class="input-wrapper">
                                    <input type="url" id="androidApp" name="androidApp" placeholder="أدخل رابط تحميل التطبيق">
                                    <button type="button" class="help-btn" title="مساعدة">
                                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/circle-info.svg" alt="Help">
                                    </button>
                                </div>
                            </div>

                            <!-- iOS App -->
                            <div class="platform-input-group">
                                <label>رابط تحميل التطبيق نظام iOS</label>
                                <div class="input-wrapper">
                                    <input type="url" id="iosApp" name="iosApp" placeholder="أدخل رابط تحميل التطبيق">
                                    <button type="button" class="help-btn" title="مساعدة">
                                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/circle-info.svg" alt="Help">
                                    </button>
                                </div>
                            </div>

                            <!-- WhatsApp -->
                            <div class="platform-input-group">
                                <label>محادثة واتساب</label>
                                <div class="input-wrapper">
                                    <input type="url" id="whatsapp" name="whatsapp" placeholder="https://wa.me/xxxxxxxxxxxx">
                                    <button type="button" class="help-btn" title="مساعدة">
                                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/circle-info.svg" alt="Help">
                                    </button>
                                </div>
                            </div>

                            <!-- Telegram -->
                            <div class="platform-input-group">
                                <label>محادثة تليجرام</label>
                                <div class="input-wrapper">
                                    <input type="url" id="telegram" name="telegram" placeholder="https://t.me/username">
                                    <button type="button" class="help-btn" title="مساعدة">
                                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/circle-info.svg" alt="Help">
                                    </button>
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

    <script type="module" src="{{ asset('js/business-additional.js') }}"></script>

    <script>
  fetch('./user-header')
    .then(response => response.text())
    .then(data => {
      document.getElementById('user-header-container').innerHTML = data;
    });
</script>


</body>
</html>