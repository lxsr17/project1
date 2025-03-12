<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - منصة تحقق</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
<script type="module" src="{{ asset('js/login.js') }}"></script>

    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="/logo.svg" alt="تحقق">
            </div>
            <ul class="nav-links">
                <li><a href="/">الرئيسية</a></li>
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
                </div>

                <div class="form-group">
                    <label for="password">كلمة المرور</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary login-btn">تسجيل الدخول</button>
                
                <div class="form-footer">
                    <a href="./forgot-password" class="forgot-password">نسيت كلمة المرور؟</a>
                    <p class="register-link">ليس لديك حساب؟ <a href='./register' id="showRegisterOptions">إنشاء حساب جديد</a></p>
                </div>
            </form>
        </div>
    </main>

    <div class="modal" id="accountTypeModal">
        <div class="modal-content">
            <button class="modal-close" id="closeModal">×</button>
            <h2 class="modal-title">تسجيل الدخول</h2>
            <p class="modal-description">اختر نوع الحساب</p>
            <div class="account-type-buttons">
                <button class="account-type-btn merchant-btn" id="merchantLoginBtn">حساب تاجر</button>
                <button class="account-type-btn visitor-btn" id="visitorLoginBtn">حساب زائر</button>
            </div>
        </div> 
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

</body>
</html>