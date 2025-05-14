<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عن تحقق - منصة تحقق</title>
    
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
</head>
<header>
            @include('main.user-header')
        </header>
<body>


    <div class="dashboard">
        <!-- Sidebar -->
        @include('layouts.sidebar')


        <!-- Main Content -->
        <main class="about-page">
            <div class="page-header">
                <h1 class="page-title">عن تحقق</h1>
                <!-- Admin Controls - Only visible for admin users -->
                <div class="admin-controls" id="adminControls" style="display: none;">
                    <button class="btn btn-primary" id="editContentBtn">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/pen.svg" alt="">
                        تعديل المحتوى
                    </button>
                </div>
            </div>

            <div class="about-content">
                <!-- About Section -->
                <section class="about-section">
                    <h2>تحقق</h2>
                    <div class="content-editable" id="aboutText">
                        <p>منصة تحقق لتطوير وتحفيز شركة ثقة تخدم المتعاملين في التجارة الإلكترونية سواء بائعين أو مشترين، حيث تمكنك المنصة من تسجيل متجرك الإلكتروني وربط حساباتك في منصات التواصل الاجتماعي في صفحة المتجر لتسهيل وصول العملاء لك. أما إذا كنت المشتري فالمنصة تستعرض لك العديد من المتاجر الإلكترونية في صفحة واحدة حيث يمكنك الاطلاع على بيانات المتجر وتقييمات العملاء السابقين قبل التعامل مع المتجر الإلكتروني ويمكنك أيضا من ترك تقييمك بعد التعامل مع التاجر.</p>
                    </div>
                </section>

                <!-- Features Section -->
                <section class="features-section">
                    <h2>فائدة تحقق</h2>
                    <div class="content-editable" id="featuresText">
                        <ul>
                            <li>خدمة تحقق تزيد من ثقة أعمالك التجارية أمام عملائك.</li>
                            <li>الخدمة تسهل لك الوصول للعملاء المستهدفين.</li>
                            <li>تقييم عملائك وتعليقاتهم في متجرك بشفافية وسيظهر جودة خدماتك أمام الجميع.</li>
                            <li>الخدمة مجانية وكل ما عليك هو التسجيل عبر الرابط https:// </li>
                            <li>يمكنك الاشتراك في معروف خلال ثوان معدودة.</li>
                            <li>بإمكانك ربط جميع حساباتك في مختلف المنصات الاجتماعية في متجرك بموقع معروف.</li>
                            <li>الخدمة سهلة وسريعة وبياناتك مضمونة.</li>
                            <li>بعد التسجيل في الخدمة ستحصل على شعار معروف.</li>
                            <li>الخدمة تمنحك فرصة تسويق متجرك الإلكتروني في منصات تحقق المختلفة.</li>
                            <li>عند التسجيل ستحصل على رمز الاستجابة السريعة الخاص بمتجرك.</li>
                        </ul>
                    </div>
                </section>

                <!-- Benefits Section -->
                <section class="benefits-section">
                    <h2>المميزات</h2>
                    <div class="content-editable" id="benefitsText">
                        <ul>
                            <li>بإمكانك الحصول على معلومات مهمة عن المتاجر الإلكترونية المسجلة في تحقق</li>
                            <li>بإمكانك الاطلاع على تقييم العملاء السابقين للمتاجر كما يمكنك أيضاً الاطلاع على تجاربهم مع التاجر.</li>
                            <li>خدمة تحقق مجانية وتسهل لك الوصول للمتاجر المسجلة في الخدمة.</li>
                            <li>الخدمة توفر لك إمكانية تقييم أي متجر إلكتروني مسجل في الخدمة والتعليق في متجره في تحقق</li>
                        </ul>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <!-- Edit Content Modal -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <button class="modal-close" id="closeModal">×</button>
            <h2 class="modal-title">تعديل المحتوى</h2>
            <form id="editContentForm">
                <div class="form-group">
                    <label for="editAboutText">عن تحقق</label>
                    <textarea id="editAboutText" name="aboutText" rows="6"></textarea>
                </div>
                <div class="form-group">
                    <label for="editFeaturesText">فائدة تحقق</label>
                    <textarea id="editFeaturesText" name="featuresText" rows="8"></textarea>
                </div>
                <div class="form-group">
                    <label for="editBenefitsText">المميزات</label>
                    <textarea id="editBenefitsText" name="benefitsText" rows="6"></textarea>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-outline" id="cancelEdit">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>

    
    <script type="module" src="{{ asset('js/about.js') }}"></script>

    <script>
  fetch('./user-header')
    .then(response => response.text())
    .then(data => {
      document.getElementById('user-header-container').innerHTML = data;
    });
</script>



</body>
</html>