<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
@php
    $storeOwner = Auth::guard('store_owner')->user();
@endphp


<header class="user-header">
<div class="logo">
    <img src="{{ asset('images/TAHAQAQ_icon.png') }}" alt="تحقق" />
</div>
    <div class="user-controls">
        <div class="notifications-icon" id="notificationsIcon">
            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/bell.svg" alt="الإشعارات">
            <div class="notifications-badge"></div>
        </div>
        <div class="user-info-container" id="userInfoContainer">
            @php
                $user = Auth::guard('store_owner')->user() ?? Auth::guard('web')->user();
            @endphp

            @if ($user)
                <span>{{ $user->username ?? $user->name }}</span>
                <span>{{ $user->email }}</span>
            @else
                <span>زائر</span>
            @endif

            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/chevron-down.svg" alt="القائمة" class="dropdown-arrow">

            <div class="user-dropdown" id="userDropdown">
                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/user.svg" alt="">
                    الملف الشخصي
                </a>
                <div class="dropdown-divider"></div>
                <a href="/" class="dropdown-item danger" id="deleteAccount">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/trash.svg" alt="">
                    حذف الحساب
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('store.logout') }}" class="dropdown-item danger">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/right-from-bracket.svg" alt="">
                    تسجيل الخروج
                </a>
            </div>
        </div>
    </div>
</header>

<!-- Notifications Preview Modal -->
<div class="modal" id="notificationsModal">
    <div class="modal-content notifications-preview">
        <button class="modal-close" id="closeNotificationsModal">×</button>
        <h3 class="modal-title">الإشعارات</h3>
        <div class="notifications-list">
            <!-- Notifications will be dynamically added here -->
        </div>
        <div class="modal-footer">
            <a href="/notifications" class="btn btn-primary">عرض كل الإشعارات</a>
        </div>
    </div>
</div>

<!-- ✅ سكربت لتفعيل الـ dropdown -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const userInfo = document.getElementById('userInfoContainer');
    const dropdown = document.getElementById('userDropdown');

    if (userInfo && dropdown) {
        userInfo.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('active');
        });

        document.addEventListener('click', function (e) {
            if (!userInfo.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });
    }
});
</script>

<!-- ✅ سكربت إضافي لو عندك ملف JS -->
<script src="{{ asset('js/user-header.js') }}"></script>

</body>
</html>
