<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم التاجر - منصة تحقق</title>

    <!-- ملفات CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
</head>
<body>
    <div class="dashboard">

        <!-- ✅ الهيدر -->
        <header>
            @include('main.user-header')
        </header>

        <!-- ✅ الشريط الجانبي -->
        @include('layouts.sidebar')

        <!-- ✅ المحتوى الرئيسي -->
        <main class="main-content">
            <div class="page-header">
                <h1 class="page-title">لوحة تحكم التاجر</h1>
                <p class="page-description">
                    إدارة متجرك بكل سهولة عبر منصة تحقق.
                </p>
            </div>
        </main>

    </div>

    <!-- ملفات JavaScript -->
    <script type="module" src="{{ asset('js/user-header.js') }}"></script>
    <script type="module" src="{{ asset('js/merchant-dashboard.js') }}"></script>
    <script type="module" src="{{ asset('js/notifications.js') }}"></script>

</body>
</html>
