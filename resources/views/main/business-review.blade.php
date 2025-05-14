<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مراجعة البيانات - منصة تحقق</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add-business.css') }}">
    <link rel="stylesheet" href="{{ asset('css/business-review.css') }}">
</head>
<header>
            @include('main.user-header')
        </header>
<body>
<div class="dashboard">

    @include('layouts.sidebar')

    <main class="add-business-page">
        <div class="steps-container">

            <!-- Progress Steps -->
            <div class="progress-steps">
                <div class="step completed"><div class="step-number">1</div><span class="step-text">بيانات العمل</span></div>
                <div class="step completed"><div class="step-number">2</div><span class="step-text">بيانات التواصل</span></div>
                <div class="step completed"><div class="step-number">3</div><span class="step-text">سياسة الاسترجاع</span></div>
                <div class="step completed"><div class="step-number">4</div><span class="step-text">البيانات الإضافية</span></div>
                <div class="step active"><div class="step-number">5</div><span class="step-text">المراجعة</span></div>
            </div>

            <!-- Review Form -->
            <form action="{{ route('business.submit') }}" method="POST">
                @csrf
                <div class="review-content">

                    <!-- بيانات العمل -->
                    <div class="review-section">
                        <div class="section-header">
                            <h3><img src="/icons/store.svg" alt=""> بيانات العمل</h3>
                            <a href="{{ route('add-business') }}" class="edit-btn">تعديل</a>
                        </div>
                        <div class="section-content">
                        <p><strong>الاسم (عربي):</strong> {{ $business->name_ar }}</p>
                        <p><strong>الاسم (إنجليزي):</strong> {{ $business->name_en }}</p>
                        <p><strong>التصنيف الرئيسي:</strong> {{ $business->main_category }}</p>
                        <p><strong>التصنيف الفرعي:</strong> {{ $business->sub_category }}</p>

                            
                        </div>
                    </div>

                    <!-- بيانات التواصل -->
                    @php $contact = session('business.contact'); @endphp
                    <div class="review-section">
                        <div class="section-header">
                            <h3><img src="/icons/contact.svg" alt=""> بيانات التواصل</h3>
                            <a href="{{ route('business-contact') }}" class="edit-btn">تعديل</a>
                        </div>
                        <div class="section-content">
                            @if($contact)
                                <p><strong>الهاتف:</strong> {{ $contact['phone'] }}</p>
                                <p><strong>البريد الإلكتروني:</strong> {{ $contact['email'] }}</p>
                                @if (isset($contact['address']))
                                   <p><strong>العنوان:</strong> {{ $contact['address'] }}</p>
                                  @endif

                            @else
                                <p>لم يتم إدخال بيانات التواصل.</p>
                            @endif
                        </div>
                    </div>

                    <!-- سياسة الاسترجاع -->
                    <div class="review-section">
                        <div class="section-header">
                            <h3><img src="/icons/policy.svg" alt=""> سياسة الاسترجاع</h3>
                            <a href="{{ route('business-policies') }}" class="edit-btn">تعديل</a>
                        </div>
                        <div class="section-content">
                            <p><strong>السياسة:</strong> {{ $business->return_policy }}</p>
                            <p><strong>أيام الاسترجاع:</strong> {{ $business->return_days }}</p>
                            <p><strong>أيام الاستبدال:</strong> {{ $business->exchange_days }}</p>
                        </div>
                    </div>

                    <!-- البيانات الإضافية -->
                    <div class="review-section">
                        <div class="section-header">
                            <h3><img src="/icons/social.svg" alt=""> البيانات الإضافية</h3>
                            <a href="{{ route('business-additional') }}" class="edit-btn">تعديل</a>
                        </div>
                        <div class="section-content">
                            <p><strong>تويتر:</strong> {{ $business->twitter }} @if($business->show_twitter) (ظاهر في المتجر) @endif</p>
                            <p><strong>انستقرام:</strong> {{ $business->instagram }} @if($business->show_instagram) (ظاهر في المتجر) @endif</p>
                            <p><strong>تيك توك:</strong> {{ $business->tiktok }} @if($business->show_tiktok) (ظاهر في المتجر) @endif</p>
                            <p><strong>الموقع الإلكتروني:</strong> {{ $business->website }}</p>
                            <p><strong>تطبيق Android:</strong> {{ $business->android_app }}</p>
                            <p><strong>تطبيق iOS:</strong> {{ $business->ios_app }}</p>
                            <p><strong>واتساب:</strong> {{ $business->whatsapp }}</p>
                            <p><strong>تليجرام:</strong> {{ $business->telegram }}</p>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('business-additional') }}" class="btn-back">السابق</a>
                        <button type="submit" class="btn-submit">إنشاء العمل</button>
                    </div>

                </div>
            </form>
        </div>
    </main>
</div>


<script type="module" src="{{ asset('js/business-review.js') }}"></script>


<script>
  fetch('./user-header')
    .then(response => response.text())
    .then(data => {
      document.getElementById('user-header-container').innerHTML = data;
    });
</script>


</body>
</html>
