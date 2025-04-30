<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل المتجر - منصة تحقق</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/store-details.css') }}">
</head>

<body data-guest="{{ Auth::guest() ? 'true' : 'false' }}" data-visitor="{{ Auth::guard('web')->check() ? 'true' : 'false' }}">

@if(Auth::guard('store_owner')->check() || Auth::guard('web')->check())
    @include('main.user-header')
@endif

@if(Auth::guard('store_owner')->check() || Auth::guard('web')->check())
    <aside class="sidebar">
        @include('layouts.sidebar')
    </aside>
@endif



<main class="store-details-page">


<!-- زر الرجوع -->
<div class="back-button-container" style="margin: 1rem 0; text-align: left;">
    <a href="{{ url()->previous() }}" class="btn-back" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background-color: #f0f0f0; border-radius: 8px; color: #333; text-decoration: none; font-weight: 500; transition: background-color 0.3s; direction: ltr;" onmouseover="this.style.backgroundColor='#e0e0e0'" onmouseout="this.style.backgroundColor='#f0f0f0'">
        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/arrow-left.svg" alt="رجوع" style="width: 16px; height: 16px; transform: scaleX(-1);">
        <span>رجوع</span>
    </a>
</div>


        <!-- رأس المتجر -->
        <div class="store-header card">
   <div class="store-logo-wrapper">
   @php
    $hasRealLogo = $store->logo && file_exists(public_path('storage/' . ltrim($store->logo, '/')));
    $logoPath = $hasRealLogo ? asset('storage/' . ltrim($store->logo, '/')) : asset('images/placeholder.png');
@endphp

<img src="{{ $logoPath }}" alt="{{ $store->business_name }}" class="store-logo-img">


    @if($store->commercial_registration_document)
        <img 
            src="{{ asset('images/frames/gold-frame.png') }}" 
            alt="ذهبي" 
            class="store-frame"
        >
    @elseif($store->freelancer_document)
        <img 
            src="{{ asset('images/frames/silver-frame.png') }}" 
            alt="فضي" 
            class="store-frame"
        >
    @endif
</div>


    <div class="store-main-info">
        <h1>{{ $store->business_name }}</h1>
        <p>{{ $store->business_type }}</p>

        <div class="rating">
            <strong>{{ $store->reviews->avg('rating') ?? 0 }}/5</strong>
            <span class="stars">
                @for ($i = 1; $i <= 5; $i++)
                    <span class="star" style="color: {{ $i <= floor($store->reviews->avg('rating')) ? '#ffc107' : '#e0e0e0' }}">&#9733;</span>
                @endfor
            </span>
            <span>({{ $store->reviews->count() }} تقييم)</span>
        </div>

        <div class="store-badges">
            @if ($store->commercial_registration_document)
                <div class="badge verified">
                    <img src="{{ asset('images/gold-badge.png') }}" alt="موثق بالسجل التجاري" style="width: 24px; height: 24px;">
                    <span>موثق بالسجل التجاري</span>
                </div>
            @elseif ($store->freelancer_document)
                <div class="badge verified">
                    <img src="{{ asset('images/silver-badge.png') }}" alt="موثق بعمل حر" style="width: 24px; height: 24px;">
                    <span>موثق بعمل حر</span>
                </div>
            @else
                <div class="badge verified">
                    <img src="{{ asset('images/blue-badge.png') }}" alt="غير موثق" style="width: 24px; height: 24px;">
                    <span>غير موثق</span>
                </div>
            @endif
        </div>
    </div>
</div>

        <!-- وصف المتجر -->
    <section class="card">
        <div class="tabs-header">
            <button class="tab-button active" data-tab="description">وصف العمل</button>
            <button class="tab-button" data-tab="policy">سياسة الاستبدال والاسترجاع</button>
        </div>

        <div class="tab-content active" id="description">
            <p>{{ $store->description ?? 'لا يوجد وصف للعمل' }}</p>
        </div>

        <div class="tab-content" id="policy">
            <p>{{ $store->return_policy ?? 'لا توجد سياسة استبدال واسترجاع مضافة.' }}</p>
        </div>
    </section>


        <!-- بيانات التواصل -->
        <section class="card">
            <h2>بيانات التواصل</h2>
            <ul class="contact-list">
                <li><strong>البريد الإلكتروني:</strong> {{ $store->email ?? 'غير متوفر' }}</li>
                <li><strong>رقم الجوال:</strong> {{ $store->phone1 ?? 'غير متوفر' }}</li>
                <li><strong>المدينة:</strong> {{ $store->city ?? 'غير متوفر' }}</li>
            </ul>
        </section>

        <!-- روابط التواصل الاجتماعي -->
        @if($store->twitter || $store->instagram || $store->tiktok || $store->website)
        <section class="card">
            <h2>روابط المتجر</h2>
            <div class="social-links">
                @if($store->twitter && $store->show_twitter)
                    <a href="{{ $store->twitter }}" target="_blank"><img src="{{ asset('images/icons/twitter.png') }}" alt="تويتر"></a>
                @endif
                @if($store->instagram && $store->show_instagram)
                    <a href="{{ $store->instagram }}" target="_blank"><img src="{{ asset('images/icons/instagram.png') }}" alt="انستقرام"></a>
                @endif
                @if($store->tiktok && $store->show_tiktok)
                    <a href="{{ $store->tiktok }}" target="_blank"><img src="{{ asset('images/icons/tiktok.png') }}" alt="تيك توك"></a>
                @endif
                @if($store->website)
                    <a href="{{ $store->website }}" target="_blank"><img src="{{ asset('images/icons/website.png') }}" alt="الموقع"></a>
                @endif
            </div>
        </section>
        @endif

        <!-- التقييمات -->
        <section class="card">
            <h2>آراء العملاء</h2>
            <div class="modal" id="reviewModal">
    <div class="modal-content">
        <button class="close-button" id="closeModal">&times;</button>
        <h2>إضافة تقييم</h2>
        <form id="reviewForm">
            @csrf
            <input type="hidden" name="rating" id="ratingInput">
            <div id="starRating" style="margin: 10px 0;">
                <span class="star" data-value="1">&#9733;</span>
                <span class="star" data-value="2">&#9733;</span>
                <span class="star" data-value="3">&#9733;</span>
                <span class="star" data-value="4">&#9733;</span>
                <span class="star" data-value="5">&#9733;</span>
            </div>
            <textarea name="reviewText" placeholder="اكتب تعليقك هنا..." rows="4" required></textarea>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 15px;">
                <button type="button" class="btn btn-secondary" id="cancelReview">إلغاء</button>
                <button type="submit" class="btn btn-primary">إرسال التقييم</button>
            </div>
        </form>
    </div>
</div>



@php
use Illuminate\Support\Facades\Auth;
@endphp

@if(Auth::guard('web')->check())
<form method="POST" action="{{ route('store.review') }}" style="margin-top: 30px;">
        @csrf
        <input type="hidden" name="store_id" value="{{ $store->id }}">

        <label for="comment">اضف تعليق </label>
        <textarea name="comment" rows="5" style="width: 100%; background:200,200,200;  border: 2px solidrgb black ;"></textarea>
        
        <label style="display: block; margin-top: 15px;">اضف تقييم </label>
        <div class="rating-stars" style="display: flex; gap: 10px; margin-bottom: 15px;">
            @for ($i = 1; $i <= 5; $i++)
            <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}">
            <label for="star{{ $i }}">⭐</label>
            @endfor
        </div>
        
        <button type="submit" class="btn btn-primary">إرسال التقييم</button>
                </form>
                @elseif(Auth::guard('store_owner')->check())
                <!-- التاجر لا يمكنه التقييم -->
            @else
            <div style="margin-top: 20px;">
                <a href="{{ route('login') }}" class="btn btn-warning">قم بتسجيل الدخول لإضافة تقييم</a>
            </div>
            @endif

            @if($store->reviews && $store->reviews->count())
            <h3 style="margin-top: 30px;">آراء الزوار:</h3>
            @foreach($store->reviews as $review)
            
            @endforeach
            @endif
            @if($store->reviews->count() > 0)
                @foreach($store->reviews as $review)
                    <div class="review-item">
                        <div class="review-header">
                        <strong>{{ $review->user->first_name ?? 'مستخدم' }}</strong>
                        <span class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <span style="color: {{ $i <= $review->rating ? '#ffc107' : '#ddd' }}">&#9733;</span>
                                @endfor
                            </span>
                        </div>
                        <p class="review-comment">{{ $review->comment }}</p>
                        <span class="review-date">{{ $review->created_at->format('Y-m-d') }}</span>
                    </div>
                @endforeach
            @else
                <p>لا توجد تقييمات حتى الآن.</p>
            @endif
        </section>
    </div>
</main>


<!-- مودال التقييم -->

            <script>
            function copyStoreLink() {
                const url = window.location.href;
                navigator.clipboard.writeText(url).then(function() {
                    alert('تم نسخ رابط المتجر!');
                });
            }
            </script>
            
            <script>
            document.querySelectorAll('.tab-button').forEach(button => {
                button.addEventListener('click', () => {
                    const tab = button.getAttribute('data-tab');
            
                    document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
                    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
            
                    button.classList.add('active');
                    document.getElementById(tab).classList.add('active');
                });
            });
            </script>
            
            <script type="module" src="{{ asset('js/user-header.js') }}"></script>
            <script type="module" src="{{ asset('js/store-details.js') }}"></script>

</body>
</html>
