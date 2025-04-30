<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة تحكم الإدمن</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- CSS ملفات التنسيق --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-stores.css') }}">
    <link rel="stylesheet" href="{{ asset('css/rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin-reports.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin-notifications.css') }}">

</head>
<body>

    {{--  القائمة الجانبية --}}
    @include('admin.sidebar')

    {{--  الهيدر --}}
    @include('admin.user-header')

    {{--  محتوى الصفحة --}}
    <main class="admin-content" style="margin-right: 250px; padding: 20px;">
        @yield('content')
    </main>

</body>
</html>
