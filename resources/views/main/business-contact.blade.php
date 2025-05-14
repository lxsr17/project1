<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بيانات التواصل - منصة تحقق</title>

    <link rel="stylesheet" href="{{ asset('css/styles/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add-business.css') }}">
    <link rel="stylesheet" href="{{ asset('css/business-contact.css') }}">
</head>

<header>
            @include('main.user-header')
        </header>

<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
        @include('layouts.sidebar')
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
                <form id="businessContactForm" action="{{ route('business-contact') }}" method="POST">
                         @csrf
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
                                    <label for="phone">رقم المتجر </label>
                                    <input type="tel" id="phone" name="phone" pattern="05[0-9]{8}" maxlength="10" placeholder="05XXXXXXXX" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="city">المدينة</label>
                                    <input type="text" id="city" name="city" class="form-control" placeholder="ادخل اسم المدينة" required>
                                </div>

                                <div class="form-group" id="customerServicePhoneGroup">
                                    <label for="customerServicePhone">رقم جوال خدمة العملاء (اختياري)</label>
                                    <input type="tel" id="customerServicePhone" name="customerServicePhone" pattern="05[0-9]{8}" maxlength="10" placeholder="05XXXXXXXX">
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
    <script type="module" src="{{ asset('js/business-contact.js') }}"></script>

    <script>
  fetch('./user-header')
    .then(response => response.text())
    .then(data => {
      document.getElementById('user-header-container').innerHTML = data;
    });
</script>

</body>
</html>