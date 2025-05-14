<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - منصة تحقق</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
<header>
    <nav class="navbar">
        <div class="logo">
            <img src="{{ asset('images/TAHAQAQ_icon.png') }}" alt="تحقق" />
        </div>
        <ul class="nav-links">
            <li><a href="/" class="active">الرئيسية</a></li>
            <li><a href="{{ route('stores') }}">متاجر تحقق</a></li>
            <li><a href="{{ route('contact') }}">تواصل معنا</a></li>
        </ul>
        <div class="auth-buttons">
            <button class="btn btn-outline" id="loginBtn">تسجيل الدخول</button>
            <button class="btn btn-primary" id="createAccountBtn">إنشاء حساب</button>
        </div>
    </nav>
</header>

    <main class="login-page">
        <div class="login-container">
            <h2 class="login-title">تسجيل الدخول</h2>
            <form id="loginForm" class="login-form">
                <div class="form-group">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" required>
                    <span class="error-message" id="emailError"></span>
                </div>

                <div class="form-group">
                    <label for="password">كلمة المرور</label>
                    <input type="password" id="password" name="password" required>
                    <span class="error-message" id="passwordError"></span>
                </div>

                <div class="error-message" id="loginError"></div>

                <button type="submit" class="btn btn-primary login-btn">تسجيل الدخول</button>
                
                <div class="form-footer">
                    <a href="/forgot-password" class="forgot-password">نسيت كلمة المرور؟</a>
                    <p class="register-link">ليس لديك حساب؟ <a href="/register">إنشاء حساب جديد</a></p>
                </div>
            </form>
        </div>
    </main>

    <script type="module" src="{{ asset('js/main.js') }}"></script>
    <script type="module" src="{{ asset('js/login.js') }}"></script>
<script>
    document.getElementById('createAccountBtn').onclick = function() {
        window.location.href = "{{ route('register') }}";
    };
</script>

</body>
</html>
