<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي - منصة تحقق</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>
<body>
    @php
        $user = Auth::guard('store_owner')->user() ?? Auth::guard('web')->user();
    @endphp

    @if ($user)
    <div class="dashboard">


        <main class="profile-page">
            
<div class="page-header">
    <a href="{{ route('merchant-dashboard') }}" class="back-button-header">
         رجوع
    </a>
    <button id="darkModeToggle" class="dark-toggle-btn" title="تبديل الوضع الداكن">
    🌓
</button>


                <h1 class="page-title">الملف الشخصي</h1>
                <div class="profile-sections">
            </div>

            </div>

            <div class="profile-sections">
                <!-- البيانات الشخصية -->
                <section class="profile-section">
                    <div class="section-header">
                        <h2>
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/user.svg" alt="">
                            البيانات الشخصية
                        </h2>
                    </div>
                    <form id="personalInfoForm" class="profile-form" method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="firstName">الاسم الأول</label>
                                <input type="text" id="firstName" name="first_name" value="{{ $user?->first_name }}" required>
                            </div>

                            <div class="form-group">
                                <label for="lastName">اسم العائلة</label>
                                <input type="text" id="lastName" name="last_name" value="{{ $user?->last_name }}" required>
                            </div>

                            <div class="form-group">
                                <label for="email">البريد الإلكتروني</label>
                                <div class="verified-input">
                                    <input type="email" id="email" name="email" value="{{ $user?->email }}" readonly>
                                    <span class="verified-badge" style="display: {{ $user?->email_verified_at ? 'flex' : 'none' }}">
                                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/check.svg" alt="">
                                        تم التحقق
                                    </span>
                                    @if (!$user?->email_verified_at)
                                        <button type="button" class="verify-btn" id="verifyEmailBtn">تحقق</button>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone">رقم الجوال</label>
                                <div class="verified-input">
                                    <input type="tel" id="phone" name="phone" value="{{ $user?->phone }}" readonly>
                                    <span class="verified-badge" style="display: {{ $user?->phone_verified_at ? 'flex' : 'none' }}">
                                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/check.svg" alt="">
                                        تم التحقق
                                    </span>
                                    @if (!$user?->phone_verified_at)
                                        <button type="button" class="verify-btn" id="verifyPhoneBtn">تحقق</button>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="username">اسم المستخدم</label>
                                <input type="text" id="username" name="username" value="{{ $user?->username }}" required>
                            </div>
                            <div class="form-group">
                                <label for="birthdate">تاريخ الميلاد</label>
                                <input type="date" id="birthdate" name="birthdate" value="{{ $user?->birthdate }}" readonly>
                            </div>

                            <div class="form-group">
                                <label>الجنس</label>
                                <div class="radio-group">
                                    <label class="radio-label">
                                        <input type="radio" name="sex" value="male" {{ strtolower($user?->sex) === 'male' ? 'checked' : '' }} disabled>
                                        <span>ذكر</span>
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" name="sex" value="female" {{ strtolower($user?->sex) === 'female' ? 'checked' : '' }} disabled>
                                        <span>أنثى</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="city">المدينة</label>
                                <input type="text" id="city" name="city" value="{{ $user?->city }}" required>
                            </div>

                            <div class="form-group">
                                <label for="street">العنوان</label>
                                <input type="text" id="street" name="street" value="{{ $user?->street }}" required>
                            </div>
                        </div>

                        <div class="form-actions">
                        <a href="{{ auth()->guard('store_owner')->check() ? route('merchant-dashboard') : route('visitor-dashboard') }}" class="btn btn-outline">
                            العودة
                        </a>

                            <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                        </div>
                    </form>
                </section>
<!-- سجل الجلسات -->
<section class="profile-section">
    <div class="section-header">
        <h2>
            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/clock-rotate-left.svg" alt="">
            سجل العمليات
        </h2>
    </div>

    <div class="sessions-table">
        <div class="table-header">
            <div class="header-cell">نوع الجهاز</div>
            <div class="header-cell">عنوان IP</div>
            <div class="header-cell">بداية الجلسة</div>
            <div class="header-cell">آخر نشاط</div>
            <div class="header-cell">انتهاء الصلاحية</div>
        </div>

        <div id="sessionsContent">
            <div class="empty-state">يتم تحميل الجلسات...</div>
        </div>
    </div>

    <button class="btn btn-primary logout-all-btn">
        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/right-from-bracket.svg" alt="">
        الخروج من جميع الجلسات
    </button>
</section>

                <!-- معلومات الأمان -->
                <section class="profile-section">
                    <div class="section-header">
                        <h2>
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/shield-halved.svg" alt="">
                            معلومات الأمان
                        </h2>
                    </div>
                    <div class="security-info">
                        <p class="security-message">
                            للحصول على تجربة أسرع وأكثر أماناً، يوصى باستخدام تطبيق تحقق أو Face ID بدلاً من التحقق عبر الرسائل القصيرة SMS.
                        </p>
                        <button class="btn btn-primary add-verification-btn">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/plus.svg" alt="">
                            إضافة خيار تحقق
                        </button>
                    </div>
                </section>
            </div>
        </main>
    </div>
    @endif


    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleBtn = document.getElementById('darkModeToggle');
        const isDark = localStorage.getItem('darkMode') === 'enabled';

        if (isDark) {
            document.body.classList.add('dark-mode');
        }

        toggleBtn?.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');

            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('darkMode', 'enabled');
            } else {
                localStorage.removeItem('darkMode');
            }
        });
    });
</script>


    <script>
document.addEventListener('DOMContentLoaded', function () {
    const sessionsContent = document.getElementById('sessionsContent');

    fetch('/sessions')
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                sessionsContent.innerHTML = '';
                data.forEach(session => {
                    sessionsContent.innerHTML += `
                        <div class="table-row">
                            <div class="cell">${session.device || 'غير معروف'}</div>
                            <div class="cell">${session.ip_address || '-'}</div>
                            <div class="cell">${session.created_at || '-'}</div>
                            <div class="cell">${session.last_activity || '-'}</div>
                            <div class="cell">${session.expires_at || '-'}</div>
                        </div>
                    `;
                });
            } else {
                sessionsContent.innerHTML = `<div class="empty-state">لا توجد جلسات نشطة حالياً</div>`;
            }
        })
        .catch(() => {
            sessionsContent.innerHTML = `<div class="empty-state">حدث خطأ أثناء تحميل الجلسات</div>`;
        });
});
</script>

    <script type="module" src="{{ asset('js/profile.js') }}"></script>
</body>
</html>