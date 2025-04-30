<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سياسة الاسترجاع والشحن - منصة تحقق</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add-business.css') }}">
    <link rel="stylesheet" href="{{ asset('css/business-policies.css') }}">
</head>
<header>
            @include('main.user-header')
        </header>
<body>
 
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
                    <div class="step active">
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
                <form id="businessPoliciesForm" action="{{ route('business-policies') }}" method="POST">
                             @csrf
                        <div class="form-section">
                            <h3 class="form-section-title">
                                <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/rotate-left.svg" alt="">
                                سياسة الاستبدال والاسترجاع
                            </h3>
                            <div class="form-grid">
                                <div class="form-group full-width">
                                    <label for="returnPolicy">سياسة الاستبدال والاسترجاع</label>
                                    <textarea id="returnPolicy" name="returnPolicy" rows="4" placeholder="اكتب سياسة الاستبدال والاسترجاع هنا"></textarea>
                                </div>
                                <div class="form-group full-width">
                                    <div class="checkbox-group">
                                        <input type="checkbox" id="noReturn" name="noReturn">
                                        <label for="noReturn">لا يمكن الاستبدال والاسترجاع وفقاً لطبيعة المنتج أو الخدمة المقدمة</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="returnDays">عدد أيام الاسترجاع</label>
                                    <input type="number" id="returnDays" name="returnDays" min="0" value="0">
                                </div>
                                <div class="form-group">
                                    <label for="exchangeDays">عدد أيام الاستبدال</label>
                                    <input type="number" id="exchangeDays" name="exchangeDays" min="0" value="0">
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
    <script src="{{ asset('js/business-policies.js') }}"></script>

    
    <script>
  fetch('./user-header')
    .then(response => response.text())
    .then(data => {
      document.getElementById('user-header-container').innerHTML = data;
    });
</script>


</body>
</html>