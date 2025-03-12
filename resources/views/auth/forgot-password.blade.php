<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>استعادة كلمة المرور - منصة تحقق</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forgot-password.css') }}">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="https://maroof.sa/Content/themes/Maroof/images/logo.png" alt="تحقق">
            </div>
            <ul class="nav-links">
                <li><a href="./index.html">الرئيسية</a></li>
                <li><a href="./stores.html">متاجر تحقق</a></li>
                <li><a href="./contact.html">تواصل معنا</a></li>
            </ul>
            <div class="auth-buttons">
                <button class="btn btn-outline" id="loginBtn">تسجيل الدخول</button>
                <button class="btn btn-primary" id="createAccountBtn">إنشاء حساب</button>
            </div>
        </nav>
    </header>

    <main class="forgot-password-page">
        <div class="forgot-password-container">
            <h2 class="forgot-password-title">استعادة كلمة المرور</h2>
            
            <!-- Email Form -->
            <form id="emailForm" class="forgot-password-form">
                <div class="form-group">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <button type="submit" class="btn btn-primary submit-btn">إرسال رمز التحقق</button>
            </form>

            <!-- Verification Code Form -->
            <form id="verificationForm" class="forgot-password-form" style="display: none;">
                <div class="form-group">
                    <label for="verificationCode">رمز التحقق</label>
                    <div class="verification-code-inputs">
                        <input type="number" class="verification-code-input" min="0" max="9" required>
                        <input type="number" class="verification-code-input" min="0" max="9" required>
                        <input type="number" class="verification-code-input" min="0" max="9" required>
                        <input type="number" class="verification-code-input" min="0" max="9" required>
                        <input type="number" class="verification-code-input" min="0" max="9" required>
                        <input type="number" class="verification-code-input" min="0" max="9" required>
                    </div>
                    <p class="verification-timer">يمكنك طلب رمز جديد خلال <span id="timer">02:00</span></p>
                </div>
                <button type="submit" class="btn btn-primary submit-btn">تحقق من الرمز</button>
                <button type="button" id="resendCode" class="btn btn-outline resend-btn" disabled>إعادة إرسال الرمز</button>
            </form>

            <!-- New Password Form -->
            <form id="newPasswordForm" class="forgot-password-form" style="display: none;">
                <div class="form-group">
                    <label for="newPassword">كلمة المرور الجديدة</label>
                    <input type="password" id="newPassword" name="newPassword" required>
                    <div class="password-requirements">
                        <div class="requirement" data-requirement="length">8 أحرف على الأقل</div>
                        <div class="requirement" data-requirement="uppercase">حرف كبير واحد على الأقل</div>
                        <div class="requirement" data-requirement="lowercase">حرف صغير واحد على الأقل</div>
                        <div class="requirement" data-requirement="number">رقم واحد على الأقل</div>
                        <div class="requirement" data-requirement="special">رمز خاص واحد على الأقل (!@#$%^&*)</div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirmNewPassword">تأكيد كلمة المرور الجديدة</label>
                    <input type="password" id="confirmNewPassword" name="confirmNewPassword" required>
                </div>
                <button type="submit" class="btn btn-primary submit-btn">تغيير كلمة المرور</button>
            </form>
        </div>
    </main>
    <script type="module" src="{{ asset('js/forgot-password.js') }}"></script>
</body>
</html>