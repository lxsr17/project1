<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اشتراكاتي - منصة تحقق</title>
    <link rel="stylesheet" href="{{ asset('css/subscriptions.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">

</head>
<body>
<header>
    @include('main.user-header')
</header>

<div class="dashboard">
    @include('layouts.sidebar')

    <main class="subscriptions-page">
        <div class="page-header">
            <h1 class="page-title">اشتراكاتي</h1>
        </div>

        <div class="subscriptions-container">
            <div class="empty-state">
                <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/credit-card.svg" alt="Empty state" class="empty-icon">
                <h2>لا يوجد لديك اشتراكات حالياً</h2>
                <p>يمكنك الاشتراك في خدماتنا المميزة لتطوير أعمالك</p>
                <a href="{{ route('subscription.plans') }}" class="btn btn-primary">عرض الباقات</a>
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
    <script type="module" src="{{ asset('js/subscriptions.js') }}"></script>

</body>
</html>