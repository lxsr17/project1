<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>متاجر تحقق</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stores_login_Marchent.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
</head>

<body>

    <!-- ✅ الهيدر -->
    <header>
        @include('main.user-header')
    </header>

    <div class="dashboard">
        <!-- ✅ السايد بار -->
        <aside class="sidebar">
            @include('layouts.sidebar')
        </aside>

        <!-- ✅ المحتوى الرئيسي -->
        <main class="stores-page guest-view">
            <div class="search-section">
                <div class="search-container">
                    <form id="stores-search-form" class="search-form" method="GET" action="{{ route('stores_login_Marchent') }}">
                        <div class="search-input-wrapper">
                            <input type="text" placeholder="ابحث باسم المتجر أو برقم تحقق" name="q" value="{{ request('q') }}">
                        </div>
                        <button type="submit" class="search-btn">بحث</button>
                    </form>
                </div>
            </div>

            <div class="stores-content">
                <aside class="filters-sidebar">
                    <form method="GET" action="{{ route('stores_login_Marchent') }}">
                        <div class="filter-section">
                            <h3>نوع الشهادة</h3>
                            <div class="certificate-type">
                                <label class="custom-radio gold">
                                    <input type="radio" name="certificate" value="gold" {{ request('certificate') == 'gold' ? 'checked' : '' }}>
                                    <span>الشهادة الذهبية</span>
                                </label>
                                <label class="custom-radio silver">
                                    <input type="radio" name="certificate" value="silver" {{ request('certificate') == 'silver' ? 'checked' : '' }}>
                                    <span>الشهادة الفضية</span>
                                </label>
                            </div>

                        </div>

                        <div class="filter-section">
                            <h3>تصنيف العمل</h3>
                            <select class="filter-select" name="category">
                                <option value="">اختر التصنيف</option>
                                <option value="إلكترونيات وأجهزة" {{ request('category') == 'إلكترونيات وأجهزة' ? 'selected' : '' }}>إلكترونيات وأجهزة</option>
                                <option value="أزياء وملابس" {{ request('category') == 'أزياء وملابس' ? 'selected' : '' }}>أزياء وملابس</option>
                                <option value="مأكولات ومشروبات" {{ request('category') == 'مأكولات ومشروبات' ? 'selected' : '' }}>مأكولات ومشروبات</option>
                                <option value="مستحضرات تجميل" {{ request('category') == 'مستحضرات تجميل' ? 'selected' : '' }}>مستحضرات تجميل</option>
                                <option value="أثاث ومفروشات" {{ request('category') == 'أثاث ومفروشات' ? 'selected' : '' }}>أثاث ومفروشات</option>
                                <option value="كتب وقرطاسية" {{ request('category') == 'كتب وقرطاسية' ? 'selected' : '' }}>كتب وقرطاسية</option>
                                <option value="هدايا وألعاب" {{ request('category') == 'هدايا وألعاب' ? 'selected' : '' }}>هدايا وألعاب</option>
                                <option value="رياضة ولياقة" {{ request('category') == 'رياضة ولياقة' ? 'selected' : '' }}>رياضة ولياقة</option>
                                <option value="منتجات منزلية" {{ request('category') == 'منتجات منزلية' ? 'selected' : '' }}>منتجات منزلية</option>
                                <option value="مجوهرات واكسسوارات" {{ request('category') == 'مجوهرات واكسسوارات' ? 'selected' : '' }}>مجوهرات واكسسوارات</option>
                                <option value="أخرى" {{ request('category') == 'أخرى' ? 'selected' : '' }}>أخرى</option>
                            </select>
                        </div>

                       <div class="filter-section">
    <h3>نوع العمل الرئيسي</h3>
    <select class="filter-select" name="business_type" onchange="this.form.submit()">
        <option value="">اختر التصنيف</option>
        <option value="retail" {{ request('business_type') == 'retail' ? 'selected' : '' }}>متجر تجزئة</option>
        <option value="wholesale" {{ request('business_type') == 'wholesale' ? 'selected' : '' }}>متجر جملة</option>
        <option value="services" {{ request('business_type') == 'services' ? 'selected' : '' }}>خدمات</option>
    </select>
</div>


                        <button class="btn btn-primary filter-apply">تطبيق التصفية</button>
                    </form>
                </aside>

                <section class="stores-list">
                    <div class="stores-header">
                        <h2>متاجر تحقق</h2>
                        <div class="stores-stats">
                            <span>عدد النتائج: {{ $stores->total() }}</span>
                            <div class="sort-options">
                                <a href="{{ route('stores_login_Marchent', ['sort' => 'latest']) }}">محو التصفيات</a>
                                <a href="{{ route('stores_login_Marchent', ['sort' => 'rating']) }}">الأفضل تقييماً</a>
                                <a href="{{ route('stores_login_Marchent', ['sort' => 'reviews']) }}">الأكثر تقييماً</a>
                            </div>
                        </div>
                    </div>

                    <div class="stores-grid">
                        @forelse($stores as $store)
                        @php
                        $totalRatings = $store->reviews->sum('rating');
                        $reviewsCount = $store->reviews->count();
                        $averageRating = $reviewsCount > 0 ? round($totalRatings / $reviewsCount, 1) : 0;
                        $logoPath = $store->business_logo
                        ? asset('storage/' . ltrim($store->business_logo, '/'))
                        : asset('images/placeholder.png');

                        @endphp

                        <div class="store-card" onclick="window.location.href='{{ route('store.details', $store->id) }}'">
    <div class="store-logo-wrapper" style="position: relative;">
        <img src="{{ $store->logo ? asset('storage/' . ltrim($store->logo, '/')) : asset('images/placeholder.png') }}"
     alt="{{ $store->business_name }}"
     class="store-logo-img"
     style="width: 80px; height: 80px; object-fit: cover;">



        @if($store->commercial_registration_document)
            <img src="{{ asset('images/frames/gold-frame.png') }}" 
                 alt="ذهبي" 
                 class="store-frame" 
                 style="position: absolute; top: 0; left: 0; width: 80px; height: 80px;">
        @elseif($store->freelancer_document)
            <img src="{{ asset('images/frames/silver-frame.png') }}" 
                 alt="فضي" 
                 class="store-frame" 
                 style="position: absolute; top: 0; left: 0; width: 80px; height: 80px;">
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

                    <div class="custom-pagination-wrapper">
                        <div class="custom-pagination-arrows">
                            @if ($stores->onFirstPage())
                            <span class="arrow disabled">&#x276E;</span>
                            @else
                            <a href="{{ $stores->previousPageUrl() }}" class="arrow">&#x276E;</a>
                            @endif

                            <span class="page-number">{{ $stores->currentPage() }}</span>

                            @if ($stores->hasMorePages())
                            <a href="{{ $stores->nextPageUrl() }}" class="arrow">&#x276F;</a>
                            @else
                            <span class="arrow disabled">&#x276F;</span>
                            @endif
                        </div>
                    </div>



                </section>
            </div>
        </main>
    </div>

    <!-- ✅ سكربتات -->
    <script type="module" src="{{ asset('js/stores.js') }}"></script>
    <script src="{{ asset('js/user-header.js') }}"></script>
</body>

</html>