<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الأسئلة الشائعة - منصة تحقق</title>
   
    <link rel="stylesheet" href="{{ asset('css/faq.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">

</head>
<body>


<header>
        @include('main.user-header')
    </header>

    <div class="dashboard">
        <aside class="sidebar">
            @include('layouts.sidebar')
        </aside>

        <main class="faq-page">
        <div class="page-header">
                <h1 class="page-title">الاسئلة الشائعة</h1>
            </div>
            <div class="faq-container">
                <div class="faq-list">

                    @php
                        $faqs = [
                            ['سؤال' => 'هل خدمة تحقق مجانية؟ وهل يوجد شروط للتسجيل؟', 'إجابة' => 'الخدمة مجانية وشروط التسجيل وجود سجل تجاري أو وثيقة العمل الحر.'],
                            ['سؤال' => 'كيف أسجل في تحقق؟', 'إجابة' => 'تستطيع التسجيل في تحقق من خلال الرابط التالي: https://.sa'],
                            ['سؤال' => 'ماهي الشهادة الذهبية ؟', 'إجابة' => 'المتاجر الإلكترونية التي لديها سجل تجاري ستحصل على أيقونة تحقق الذهبية.'],
                            ['سؤال' => 'ما الفائدة من التسجيل في تحقق؟', 'إجابة' => '- تحقق تزيد من انتشار متجرك الإلكتروني ووصولك لفئتك المستهدفة. - كتاجر تحصل على شهادة تحقق. - كمشتري تطلع على معلومات المتاجر وتقييمات العملاء.'],
                            ['سؤال' => 'أنا تاجر وليس لدي سجل تجاري، هل أستطيع التسجيل في تحقق؟', 'إجابة' => 'نعم، بشرط ربطه بالسجل التجاري أو وثيقة العمل الحر ليظهر في المتاجر.'],
                            ['سؤال' => 'هل أستطيع تقييم المنتجات بدون التسجيل؟', 'إجابة' => 'نعم، من خلال تسجيل الدخول بحساباتك على تويتر أو فيسبوك أو قوقل.'],
                            ['سؤال' => 'هل يمكنني البيع من خلال تحقق؟', 'إجابة' => 'لا، تحقق تهدف فقط للتواصل بين المتاجر والعملاء حالياً.'],
                            ['سؤال' => 'كيف أكتب تعليق أو تقييم؟', 'إجابة' => 'من خلال صفحة المتجر في تحقق، في أسفل الصفحة.'],
                            ['سؤال' => 'من يستطيع التقييم في تحقق؟', 'إجابة' => 'أي شخص من خلال الموقع أو حسابات التواصل الاجتماعي.'],
                            ['سؤال' => 'كيف يتم احتساب التقييم؟', 'إجابة' => 'نسبة رضا المستهلكين = عدد التقييمات الإيجابية ÷ إجمالي التقييمات.'],
                            ['سؤال' => 'لماذا يُطلب رقم الجوال؟', 'إجابة' => 'ليصبح المعرف الخاص بك في تحقق.'],
                            ['سؤال' => 'هل يمكنني تعديل أو حذف تقييمي؟', 'إجابة' => 'نعم، من صفحة المتجر الذي قيّمتَه.'],
                            ['سؤال' => 'هل يتم التأكد من التقييمات؟', 'إجابة' => 'نعم، من قبل فريق تحقق، ويتم حذف التقييمات غير اللائقة.'],
                            ['سؤال' => 'لماذا لا أستطيع التقييم؟', 'إجابة' => 'ربما وصلت للحد اليومي (10 تقييمات في اليوم).'],
                        ];
                    @endphp

                    @foreach ($faqs as $faq)
                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFaq(this)">
                                <div class="question-text">{{ $faq['سؤال'] }}</div>
                                <div class="faq-toggle">
                                    <img src="https://cdn-icons-png.flaticon.com/512/32/32195.png" alt="">
                                </div>
                            </div>
                            <div class="faq-answer">
                                {{ $faq['إجابة'] }}
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleFaq(element) {
            const faqItem = element.parentElement;
            faqItem.classList.toggle('active');
        }
    </script>
    
    <script type="module" src="{{ asset('js/faq.js') }}"></script>
    <script>
  fetch('./user-header')
    .then(response => response.text())
    .then(data => {
      document.getElementById('user-header-container').innerHTML = data;
    });
</script>


</body>
</html>