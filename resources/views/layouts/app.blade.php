<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'موقعي Laravel')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- شريط التنقل -->
    <nav>
        <ul>
            <li><a href="{{ url('/') }}">الرئيسية</a></li>
            <li><a href="{{ url('/search') }}">البحث</a></li>
            <li><a href="{{ url('/login') }}">تسجيل الدخول</a></li>
            <li><a href="{{ url('/register') }}">إنشاء حساب</a></li>
        </ul>
    </nav>

    <!-- محتوى الصفحة -->
    <div class="container">
        @yield('content')
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
