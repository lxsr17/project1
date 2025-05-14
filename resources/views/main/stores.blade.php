<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>متاجر تحقق</title>
    <link rel="stylesheet" href="{{ asset('css/stores.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<!-- Header with Auth Buttons -->
<header>
    <nav class="navbar">
        <div class="logo">
            <img src="{{ asset('images/TAHAQAQ_icon.png') }}" alt="تحقق" />
        </div>
        <ul class="nav-links">
            <li><a href="/" class="active">الرئيسية</a></li>
            <li><a href="{{ route('stores') }}">متاجر تحقق</a></li>
            <li><a href="{{ route('contact') }}">تواصل معنا</a></li>
        </ul>
        <div class="auth-buttons">
            <button class="btn btn-outline" id="loginBtn">تسجيل الدخول</button>
            <button class="btn btn-primary" id="createAccountBtn">إنشاء حساب</button>
        </div>
    </nav>
</header>
<!-- Main Content -->
<main class="stores-page guest-view">
    <div class="search-section">
        <div class="search-container" style="display: flex; align-items: center; justify-content: center; gap: 50px; margin-top: 60px; flex-direction: row-reverse;">
            
            <!-- أيقونة المتجر (على اليمين) -->
            <div class="icon-wrapper">
                <img src="{{ asset('images/market-icon.png') }}" alt="أيقونة المتجر" style="width: 300px; height: auto;">
            </div>

            <!-- نموذج البحث (على اليسار) -->
            <form id="stores-search-form"
                  method="GET"
                  action="{{ route('stores') }}"
                  style="display: flex; flex-direction: column; align-items: flex-end;">

                <div style="display: flex; align-items: center; background: #fff; border-radius: 30px; padding: 5px 10px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
                    <button type="submit"
                            class="search-btn"
                            style="border: none; background: linear-gradient(to left, #0072ff, #00c6a2); color: white; padding: 10px 25px; border-radius: 50px; margin-left: 10px;">
                        بحث
                    </button>

                    <input type="text"
                           name="q"
                           value="{{ request('q') }}"
                           placeholder="ابحث باسم المتجر أو رقم معروف"
                           style="padding: 10px 20px; border: none; border-radius: 30px; width: 300px; font-size: 16px;">
                </div>

            </form>
        </div>
    </div>

    <div class="stores-content">
    <aside class="filters-sidebar">
    <form method="GET" action="{{ route('stores') }}">
        <div class="filter-section">
            <h3>نوع الشهادة</h3>
            <div class="certificate-type">
                <label><input type="radio" name="certificate" value="gold" {{ request('certificate') == 'gold' ? 'checked' : '' }}><span class="certificate-label gold">الشهادة الذهبية</span></label>
                <label><input type="radio" name="certificate" value="silver" {{ request('certificate') == 'silver' ? 'checked' : '' }}><span class="certificate-label silver">الشهادة الفضية</span></label>
            </div>
        </div>

        <div class="filter-section">
            <h3>تصنيف العمل</h3>
            <select class="filter-select" name="category">
                <option value="">اختر التصنيف</option>
                <option value="electronics" {{ request('category') == 'electronics' ? 'selected' : '' }}>إلكترونيات</option>
                <option value="fashion" {{ request('category') == 'fashion' ? 'selected' : '' }}>أزياء</option>
                <option value="food" {{ request('category') == 'food' ? 'selected' : '' }}>مأكولات</option>
                <option value="design" {{ request('category') == 'design' ? 'selected' : '' }}>تصميم وطباعة</option>
            </select>
        </div>

        <div class="filter-section">
            <h3>الموقع</h3>
            <select class="filter-select" name="city">
                <option value="">اختر المدينة</option>
                <option value="riyadh" {{ request('city') == 'riyadh' ? 'selected' : '' }}>الرياض</option>
                <option value="jeddah" {{ request('city') == 'jeddah' ? 'selected' : '' }}>جدة</option>
                <option value="dammam" {{ request('city') == 'dammam' ? 'selected' : '' }}>الدمام</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary filter-apply">تطبيق التصفية</button>
    </form>
</aside>


        <section class="stores-list">
            <div class="stores-header">
                <h2>متاجر تحقق</h2>
                <div class="stores-stats">
                    <span>عدد النتائج: {{ $stores->total() }}</span>
                    <div class="sort-options">
<a href="{{ route('stores', ['sort' => 'latest']) }}">الأحدث</a>
<a href="{{ route('stores', ['sort' => 'rating']) }}">الأفضل تقييماً</a>
<a href="{{ route('stores', ['sort' => 'reviews']) }}">الأكثر تقييماً</a>

                    </div>
                </div>
            </div>
            <div class="stores-grid">
    @forelse($stores as $store)
        @php
            $totalRatings = $store->reviews->sum('rating');
            $reviewsCount = $store->reviews->count();
            $averageRating = $reviewsCount > 0 ? round($totalRatings / $reviewsCount, 1) : 0;

            $hasRealLogo = $store->logo && file_exists(public_path('storage/' . ltrim($store->logo, '/')));
            $logoPath = $hasRealLogo ? asset('storage/' . ltrim($store->logo, '/')) : asset('images/placeholder.png');
        @endphp

        <div class="store-card" onclick="window.location.href='{{ url("store-details/".$store->id) }}'">
            <div class="store-logo-wrapper" style="position: relative;">
                <img src="{{ $logoPath }}" alt="{{ $store->business_name }}" class="store-logo-img" style="width: 80px; height: 80px; object-fit: cover;">

                @if($store->commercial_registration_document)
                    <img src="{{ asset('images/frames/gold-frame.png') }}" alt="ذهبي" class="store-frame" style="position: absolute; top: 0; left: 0; width: 80px; height: 80px;">
                @elseif($store->freelancer_document)
                    <img src="{{ asset('images/frames/silver-frame.png') }}" alt="فضي" class="store-frame" style="position: absolute; top: 0; left: 0; width: 80px; height: 80px;">
                @endif
            </div>

            <div class="store-info">
                @php
                    $names = explode(' / ', $store->business_name);
                    $types = explode(' - ', $store->business_type);
                @endphp

                <h3>{{ $names[0] ?? '' }}</h3>
                <p class="store-category">{{ $types[0] ?? 'غير محدد' }}</p>

                <div class="store-rating">
                    <span class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            <span style="color:{{ $i <= floor($averageRating) ? '#ffc107' : '#ddd' }}">★</span>
                        @endfor
                    </span>
                    <span class="rating-count">{{ $averageRating }} ({{ $reviewsCount }} تقييم)</span>
                </div>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/store.svg" alt="Empty state" class="empty-icon">
            <h2>لا يوجد متاجر حالياً</h2>
            <p>لم يتم إضافة أي متاجر بعد</p>
        </div>
    @endforelse
</div>


            <div class="pagination">
                {{ $stores->links() }}
            </div>
        </section>
    </div>
</main>

<!-- Modal -->
<div class="modal" id="accountTypeModal">
    <div class="modal-content">
        <button class="modal-close" id="closeModal">×</button>
        <h2 class="modal-title">تسجيل الدخول</h2>
        <p class="modal-description" style="display: none;">اختار نوع حسابك للحصول على شهادة تحقق</p>
        <div class="account-type-buttons">
            <button class="account-type-btn merchant-btn">حساب تاجر</button>
            <button class="account-type-btn visitor-btn">حساب زائر</button>
        </div>
        <a href="#" class="login-link">ليس لديك حساب؟ إنشاء حساب</a>
    </div>
</div>

<script type="module" src="{{ asset('js/main.js') }}"></script>
<script type="module" src="{{ asset('js/stores.js') }}"></script>

</body>
</html>
