<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>شروط الاستخدام - منصة معروف</title>
    
    <link rel="stylesheet" href="{{ asset('css/terms.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">

</head>
<body>
<header>
            @include('main.user-header')
        </header>

        
    <div class="dashboard">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="terms-page">
            <div class="page-header">
                <h1 class="page-title">شروط وأحكام استخدام منصة تحقق</h1>
            </div>

            <div class="terms-container">
                <!-- Terms content sections -->
                <div class="terms-section">
                    <h2 class="section-title">أولاً: التعريفات</h2>
                    <div class="section-content">
                        <p>ما لم يقتض السياق خلاف ذلك، يكون للمصطلحات والعبارات المعرفة أدناه المعاني المبينة مقابل كل منها:</p>
                        <dl class="definition-list">
                            <dt>القانون الواجب التطبيق:</dt>
                            <dd>الأنظمة واللوائح وما في حكمها النافذة في المملكة العربية السعودية وكافة مرجعياتها الملزمة الصادرة عن الجهات المختصة.</dd>

                            <dt>موقع/ منصة تحقق:</dt>
                            <dd>منصة إلكترونية مخصصة للتعريف بالمتاجر الإلكترونية، ولعرض المنتجات، وتسهيل التواصل مع التجار.</dd>
                        </dl>
                    </div>
                </div>

                <div class="terms-section">
                    <h2 class="section-title">ثانياً: الأحكام المنظمة للاستعمال</h2>
                    <div class="section-content">
                        <ol>
                            <li>يعتبر تواجد أي شخص في الموقع و/أو استخدام أي من المنافع و/ أو الخدمات و/أو المزايا التي يوفرها الموقع، قبولاً بهذه الأحكام والشروط.</li>
                            <li>يصرح المستخدم بأنه كامل الأهلية بتاريخ استخدامه للموقع أو الإعلان أو إجراء البحث أو الشراء (البيع).</li>
                        </ol>
                    </div>
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
    <script type="module" src="{{ asset('js/terms.js') }}"></script>
</body>
</html>