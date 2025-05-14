<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الباقات - منصة تحقق</title>
    <link rel="stylesheet" href="{{ asset('css/sub.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/subscriptions.css') }}">

</head>
<body>

<header>
    @include('main.user-header')
</header>

<div class="dashboard">
    @include('layouts.sidebar')


    <main class="plans-wrapper">

        <!-- صندوق العنوان -->
        <div class="plans-header">
            <h1 class="plans-title">الباقات المتاحة</h1>
            <p class="plans-description">اختر الباقة الأنسب لاحتياجاتك عبر منصة تحقق.</p>
        </div>

        <!-- الكروت -->
        <div class="plans-section">

            <div class="plan-card premium">
                <h3>الباقة المميزة <span class="badge">الأكثر شيوعاً</span></h3>
                <p class="price">20 ريال / شهرياً</p>
                <ul>
                    <li>متاجر أكثر تصل إلى 7 متاجر</li>
                    <li>رؤية عدد الزوار لكل متجر</li>
                </ul>
                <form action="{{ route('invoice') }}" method="GET" class="subscription-form">
    <input type="hidden" name="plan" value="premium">
    <button type="submit" class="btn-plan selected">ترقية للمميزة</button>
</form>
<div class="selection-message" style="display:none;">تم اختيار هذه الباقة. سيتم توجيهك قريبًا.</div>
            </div>


        <div class="plan-card ultra">
                <h3>الباقة الاحترافية</h3>
                <p class="price">50 ريال / شهرياً</p>
                <ul>
                    <li>جميع مزايا الباقة المميزة +</li>
                    <li>الوصول المبكر للميزات</li>
                    <li>إعلانات مميزة ضمن المنصة</li>
                    <li>متاجر غير محدودة</li>
                    <li>دعم فني على مدار الساعة</li>
                </ul>
                <form action="{{ route('invoice') }}" method="GET" class="subscription-form">
    <input type="hidden" name="plan" value="ultra">
    <button type="submit" class="btn-plan">ترقية للاحترافية</button>
</form>
<div class="selection-message" style="display:none;">تم اختيار هذه الباقة. سيتم توجيهك قريبًا.</div>
</div>

</div>

    </main>


<script>
  fetch('./user-header')
    .then(response => response.text())
    .then(data => {
      document.getElementById('user-header-container').innerHTML = data;
    });
</script>

<script src="{{ asset('js/sub.js') }}"></script>
</body>
</html>

