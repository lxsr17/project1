<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تم إنشاء العمل بنجاح - منصة تحقق</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/business-success.css') }}">
</head>
<header>
            @include('main.user-header')
        </header>
<body>

<div class="dashboard">
        <!-- Sidebar -->
        @include('layouts.sidebar')
        
        <!-- Main Content -->
        <main class="success-page">
            <div class="success-container">
                <div class="success-icon">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/check.svg" alt="Success">
                </div>
                <h1 class="success-title">تم إضافة عملك بنجاح!</h1>
                <p class="success-message">تهانينا! تم إضافة عملك بنجاح. الرجاء ربط عملك بالسجل التجاري أو وثيقة العمل الحر للحصول على شهادة تحقق من منصة تحقق</p>
                
                <div class="success-note">
                    <h3>
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/info-circle.svg" alt="">
                        ملاحظة مهمة
                    </h3>
                    <p>يتطلب الحصول على شهادة تحقق من منصة معروف ربط عملك بأحد الخيارات التالية:</p>
                    <ul>
                        <li>الربط بالسجل التجاري</li>
                        <li>الربط بوثيقة العمل الحر</li>
                    </ul>
                </div>

                <div class="action-buttons">
                    <a href="./my-businesses" class="btn btn-outline">الذهاب إلى أعمالي</a>
                </div>
            </div>
        </main>
    </div>

    <script type="module" src="{{ asset('js/business-success.js') }}"></script>


    <script>
  fetch('./user-header')
    .then(response => response.text())
    .then(data => {
      document.getElementById('user-header-container').innerHTML = data;
    });
</script>

</body>
</html>