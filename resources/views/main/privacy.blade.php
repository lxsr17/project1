<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سياسة الخصوصية - منصة تحقق</title>
  
    <link rel="stylesheet" href="{{ asset('css/privacy.css') }}">
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
        <main class="privacy-page">
            <div class="page-header">
                <h1 class="page-title">سياسة الخصوصية</h1>
            </div>

            <div class="privacy-container">
                <!-- Privacy content sections -->
                <div class="privacy-section">
                    <h2 class="section-title">أولاً: الخصوصية وسرية المعلومات</h2>
                    <div class="section-content">
                        <ol>
                            <li>يضع موقع ("تحقق") سرية معلومات مستخدميه وزواره ضمن أهم الأولويات، وتبذل إدارة الموقع كل جهودها لتقديم خدمة ذات جودة عالية لكل المستخدمين.</li>
                            <li>لا يقوم موقع ("تحقق") بجمع معلومات شخصية عن المستخدمين الزائرين أو المتصفحين للموقع إلا إذا اختاروا تحديداً وبمعرفتهم تقديم هذه المعلومات.</li>
                            <li>يجب على المستخدمين الاطلاع بشكل مستمر على شروط ومبادئ الخصوصية وسرية المعلومات لمعرفة أية تحديثات تتم عليها.</li>
                        </ol>
                    </div>
                </div>

                <div class="privacy-section">
                    <h2 class="section-title">ثانياً: أمن المعلومات الشخصية</h2>
                    <div class="section-content">
                        <ol>
                            <li>تم إعداد هذه السياسة لمساعدة المستخدمين والزوار على تفهم طبيعة البيانات التي يتم جمعها منهم عند زيارة الموقع وكيفية التعامل معها.</li>
                            <li>تقوم إدارة موقع ("تحقق") باتخاذ الإجراءات والتدابير المناسبة والملائمة للمحافظة على المعلومات التي لديها بشكل آمن.</li>
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
    <script type="module" src="{{ asset('js/privacy.js') }}"></script>
</body>
</html>