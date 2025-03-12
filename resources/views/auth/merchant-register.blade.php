<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب تاجر - منصة تحقق</title>
    <link rel="stylesheet" href="{{ asset('css/merchant-register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="  " alt="تحقق">
            </div>
            <ul class="nav-links">
                <li><a href="{{ route('index') }}">الرئيسية</a></li>
                <li><a href="{{ route('stores') }}">متاجر تحقق</a></li>
                <li><a href="{{ route('contact') }}">تواصل معنا</a></li>
            </ul>
            <div class="auth-buttons">
                <a href="{{ route('login') }}" class="btn btn-outline">تسجيل الدخول</a>
                <a href="{{ route('register') }}" class="btn btn-primary">إنشاء حساب</a>
            </div>
        </nav>
    </header>

    <main class="register-page">
        <div class="register-container">
            <h2 class="register-title">إنشاء حساب تاجر جديد</h2>
            <form method="POST" action="{{ route('merchant.store') }}" class="register-form">
                @csrf
                <div class="form-grid">
                    <!-- المعلومات الشخصية -->
                    <div class="form-section full-width">
                        <h3>المعلومات الشخصية</h3>
                        <div class="section-grid">
                            <div class="form-group">
                                <label for="first_name">الاسم الأول</label>
                                <input type="text" id="first_name" name="first_name" maxlength="50" required>
                            </div>

                            <div class="form-group">
                                <label for="last_name">اسم العائلة</label>
                                <input type="text" id="last_name" name="last_name" maxlength="50" required>
                            </div>

                            <div class="form-group">
                                <label for="username">اسم المستخدم</label>
                                <input type="text" id="username" name="username" maxlength="50" required>
                            </div>

                            <div class="form-group">
                                <label for="email">البريد الإلكتروني</label>
                                <input type="email" id="email" name="email" maxlength="100" required>
                            </div>

                            <div class="form-group">
                                <label for="password">كلمة المرور</label>
                                <input type="password" id="password" name="password" required>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">تأكيد كلمة المرور</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required>
                            </div>

                            <div class="form-group">
                                <label for="birthdate">تاريخ الميلاد</label>
                                <input type="date" id="birthdate" name="birthdate" required>
                            </div>

                            <div class="form-group">
                                <label for="phone">رقم الجوال</label>
                                <input type="tel" id="phone" name="phone" pattern="05[0-9]{8}" minlength="10" maxlength="10" placeholder="05XXXXXXXX" required>
                            </div>

                            <div class="form-group">
                                <label>الجنس</label>
                                <div class="radio-group">
                                    <label class="radio-label">
                                        <input type="radio" name="sex" value="Male" required>
                                        <span>ذكر</span>
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" name="sex" value="Female" required>
                                        <span>أنثى</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- العنوان -->
                    <div class="form-section full-width">
                        <h3>العنوان</h3>
                        <div class="section-grid">
                            <div class="form-group">
                                <label for="city">المدينة</label>
                                <input type="text" id="city" name="city" maxlength="50" required>
                            </div>

                            <div class="form-group">
                                <label for="street">العنوان</label>
                                <input type="text" id="street" name="street" maxlength="100" required>
                            </div>

                            <div class="form-group">
                                <label for="neighborhood">الحي</label>
                                <input type="text" id="neighborhood" name="neighborhood" maxlength="100" required>
                            </div>

                            <div class="form-group">
                                <label for="state">المنطقة</label>
                                <input type="text" id="state" name="state" maxlength="50" required>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary register-btn">إنشاء الحساب</button>
            </form>
        </div>
    </main>

</body>
</html>
