<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الإشعارات - منصة تحقق</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
</head>
<body>

    <!-- الهيدر -->
    <header>
        @include('main.user-header')
    </header>

    <div class="dashboard">

        <!-- الشريط الجانبي -->
        <aside class="sidebar">
            @include('layouts.sidebar')
        </aside>

        <!-- المحتوى الرئيسي -->
        <main class="notifications-page">
            <div class="page-header">
                <h1 class="page-title">الإشعارات</h1>
            </div>

            <div class="notifications-container">
                <!-- التبويبات -->
                <div class="notifications-tabs">
                    <a href="{{ route('notifications.page') }}" class="tab-btn {{ request('type') === null ? 'active' : '' }}">الكل</a>
                    <a href="{{ route('notifications.page', ['type' => 'admin']) }}" class="tab-btn {{ request('type') === 'admin' ? 'active' : '' }}">تنبيهات الإدارة</a>
                    <a href="{{ route('notifications.page', ['type' => 'review']) }}" class="tab-btn {{ request('type') === 'review' ? 'active' : '' }}">الردود على التعليقات</a>
                </div>

                

                <!-- قائمة الإشعارات -->
                <div class="notification-list">
                    @forelse($notifications as $notification)
                        <div class="notification-item {{ $notification->is_read ? '' : 'unread' }}">
                            <div class="notification-header">
                                <div class="notification-icon">
                                    <img src="{{ asset('images/bell.svg') }}" alt="icon">
                                </div>
                                <div class="notification-info">
                                    <h3 class="notification-title">{{ $notification->title }}</h3>
                                    <div class="notification-meta">
                                        <span>{{ $notification->created_at->diffForHumans() }}</span>
                                        <span>{{ $notification->type === 'admin' ? 'من الإدارة' : 'نظام' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="notification-content">
                                <p>{{ $notification->message }}</p>

                                @if ($notification->type === 'review' && $notification->target === 'store')
                                    <a href="{{ route('store.details', $notification->target_id) }}" class="go-to-store-btn">
                                        الذهاب إلى المتجر
                                    </a>
                                @endif
                            </div>

                        </div>
                    @empty
                        <div class="empty-state">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/bell-slash.svg" alt="">
                            <p>لا توجد إشعارات حالياً</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>

    <script>
  fetch('./user-header')
    .then(response => response.text())
    .then(data => {
      document.getElementById('user-header-container').innerHTML = data;
    });
</script>
<script type="module" src="{{ asset('js/notifications.js') }}"></script>
</body>
</html>