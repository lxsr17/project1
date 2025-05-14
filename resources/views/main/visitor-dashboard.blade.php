<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>لوحة تحكم الزائر - منصة تحقق</title>

    <!-- ملفات CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/visitor-dashboard.css') }}">
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
                <h1 class="page-title">مرحباً بك في منصة تحقق</h1>
                <p class="page-description">
                    اكتشف أفضل المتاجر الإلكترونية وشارك تقييماتك مع الآخرين.
                </p>
            </div>

            <!-- ✅ قسم البحث -->
            <section class="search-section">
                <div class="search-container">
                    <form id="stores-search-form" class="search-form">
                        <input type="text" name="q" placeholder="ابحث باسم المتجر أو رقم تحقق">
                        <button type="submit" class="search-btn">بحث</button>
                    </form>
                </div>
            </section>

            <!-- ✅ آخر التقييمات -->
            <section class="recent-reviews">
                <h2>آخر التقييمات</h2>
                <div class="reviews-grid" id="recentReviews">
                    <!-- سيتم تعبئة التقييمات ديناميكياً عبر JS -->
                </div>
            </section>
            
        </main>

<script type="module" src="{{ asset('js/visitor-dashboard.js') }}"></script>
<script>
  fetch('./user-header')
    .then(response => response.text())
    .then(data => {
      document.getElementById('user-header-container').innerHTML = data;
    });
</script>


</body>
</html>
