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
        <div class="store-header card" style="position: relative;">
            
    {{-- رقم المتجر + QR في الزاوية --}}
    <div class="store-side-box">
        
        <div class="store-number-label">
            رقم المتجر: {{ $store->id }}
        </div>
        <div class="store-qr">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode(url()->current()) }}" alt="QR المتجر">
        </div>
        @if(Auth::guard('web')->check()) 
            {{-- الزر للزائر للإبلاغ عن المتجر --}}
            <button onclick="openReportModal('store', {{ $store->id }})" class="btn btn-danger" style="margin-left: 1rem;">
                إبلاغ عن المتجر
            </button>
        @endif

    </div>

    {{-- الشعار --}}
    <div class="store-logo-wrapper">
        @php
            $hasRealLogo = $store->logo && file_exists(public_path('storage/' . ltrim($store->logo, '/')));
            $logoPath = $hasRealLogo ? asset('storage/' . ltrim($store->logo, '/')) : asset('images/placeholder.png');
        @endphp

        <img src="{{ $logoPath }}" alt="{{ $store->business_name }}" class="store-logo-img">

        @if($store->commercial_registration_document)
            <img src="{{ asset('images/frames/gold-frame.png') }}" alt="ذهبي" class="store-frame">
        @elseif($store->freelancer_document)
            <img src="{{ asset('images/frames/silver-frame.png') }}" alt="فضي" class="store-frame">
        @endif
    </div>

    {{-- معلومات المتجر --}}
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
                    <img src="{{ asset('images/gold-badge.png') }}" alt="موثق بالسجل التجاري">
                    <span>موثق بالسجل التجاري</span>
                </div>
            @elseif ($store->freelancer_document)
                <div class="badge verified">
                    <img src="{{ asset('images/silver-badge.png') }}" alt="موثق بعمل حر">
                    <span>موثق بعمل حر</span>
                </div>
            @else
                <div class="badge verified">
                    <img src="{{ asset('images/blue-badge.png') }}" alt="غير موثق">
                    <span>غير موثق</span>
                </div>
            @endif
        </div>
    </div>
</div>



<!-- زر البلاغ -->


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

<section class="card" id="review-section">
    <h2>التقييمات والمراجعات</h2>

    {{-- ملخص التقييم --}}
    <div class="review-summary" style="display: flex; gap: 2rem; flex-wrap: wrap;">
        {{-- التقييم العام --}}
        <div class="average-rating" style="text-align: center;">
            <div style="font-size: 2rem; font-weight: bold;">
                {{ number_format($store->reviews->avg('rating') ?? 0, 1) }}
            </div>
            <div class="stars" style="font-size: 1.2rem; color: #ffc107;">
                @for ($i = 1; $i <= 5; $i++)
                    <span style="color: {{ $i <= round($store->reviews->avg('rating')) ? '#ffc107' : '#ccc' }}">&#9733;</span>
                @endfor
            </div>
            <div style="margin-top: 4px; font-size: 0.9rem; color: #777;">
                إجمالي التقييمات {{ $store->reviews->count() }}
            </div>
        </div>

        {{-- توزيع النجوم --}}
        <div class="rating-distribution" style="flex: 1;">
            @for ($i = 5; $i >= 1; $i--)
                @php
                    $count = $store->reviews->where('rating', $i)->count();
                    $percentage = $store->reviews->count() > 0 ? ($count / $store->reviews->count()) * 100 : 0;
                @endphp
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                    <span style="width: 16px;">{{ $i }}</span>
                    <div style="flex: 1; height: 8px; background: #eee; border-radius: 4px;">
                        <div style="width: {{ $percentage }}%; height: 100%; background: #ffc107; border-radius: 4px;"></div>
                    </div>
                    <span>⭐</span>
                </div>
            @endfor
        </div>

        {{-- دعوة للتقييم --}}
        <div class="review-cta" style="text-align: center; flex: 1; min-width: 200px;">
            <p style="font-weight: bold;">قم بكتابة مراجعة لهذا المتجر</p>
            <small style="color: #777;">شارك آراءك مع الآخرين</small>

            @auth('web')
                <form method="POST" action="{{ route('store.review') }}" style="margin-top: 20px;">
                    @csrf
                    <input type="hidden" name="store_id" value="{{ $store->id }}">

                    <textarea name="comment" rows="4" placeholder="اكتب تعليقك هنا..." style="width: 100%; border-radius: 8px; border: 1px solid #ccc; padding: 8px;"></textarea>

                        <div style="margin: 10px 0;">أضف تقييم</div>

                        <div class="rating-stars-dynamic">
    @for ($i = 5; $i >= 1; $i--)
        <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}">
        <label for="star{{ $i }}">&#9733;</label>
    @endfor
</div>

@if ($errors->has('rating'))
    <div style="color: red; font-size: 0.9rem; margin-top: 5px;">
        {{ $errors->first('rating') }}
    </div>
@endif


                    <button type="submit" class="btn btn-primary" style="margin-top: 10px;">إرسال التقييم</button>
                </form>
            @elseif(Auth::guard('store_owner')->check())
                <!-- التاجر لا يمكنه التقييم -->
            @else
                <a href="{{ route('login') }}" class="btn btn-warning" style="margin-top: 15px;">قم بتسجيل الدخول لإضافة تقييم</a>
            @endauth
        </div>
    </div>




    {{-- قائمة التقييمات --}}
    @if($store->reviews->count() > 0)
    <h3 style="margin-top: 30px;">آراء الزوار:</h3>
    @foreach($store->reviews as $review)
        <div class="review-item">
            <div class="review-header">
                @php
                    $userName = $review->user->first_name ?? 'مستخدم';
                    $isVisitorOwner = Auth::guard('web')->check() && Auth::id() === $review->user_id;
                    $isStoreOwner = Auth::guard('store_owner')->check() && Auth::guard('store_owner')->id() === $store->store_owner_id;
                @endphp

                <div class="review-user-info">
                    <img src="{{ asset('images/default-user.png') }}" alt="مستخدم">
                    <strong>{{ $userName }}</strong>
                </div>

                <span class="stars">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= $review->rating ? 'star-filled' : 'star-empty' }}">&#9733;</span>
                    @endfor
                </span>

                @if($isVisitorOwner)
                    <form method="POST" action="{{ route('review.delete', $review->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-review-btn">حذف</button>
                    </form>
                @endif

                @if(Auth::guard('store_owner')->check()) 
                    <button onclick="openReportModal('review', {{ $review->id }})" class="btn btn-warning" style="margin-left: 1rem;">
                        إبلاغ عن مراجعة
                    </button>
                @endif
            </div>
            <p class="review-comment">{{ $review->comment }}</p>
            <span class="review-date">{{ $review->created_at->format('Y-m-d') }}</span>
        </div>
    @endforeach
@else
    <p style="margin-top: 1rem;">لا توجد تقييمات حتى الآن.</p>
@endif


</section>

    </div>
</main>

<!-- مودال الإبلاغ عن متجر -->
<div id="reportModal" class="modal" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 999;">
    <div class="modal-content" style="background: white; padding: 20px; margin: 10% auto; width: 90%; max-width: 500px; border-radius: 10px; position: relative;">
        <span onclick="closeReportModal()" style="position:absolute; top:10px; left:15px; cursor:pointer;">&times;</span>
        <h3>تقديم بلاغ</h3>
        <form method="POST" action="{{ route('reports.store') }}">
            @csrf
            <input type="hidden" name="type" id="reportType">
            <input type="hidden" name="entity_id" id="reportEntityId">
            <label for="description">سبب البلاغ:</label>
            <textarea name="description" id="reportDescription" placeholder="اكتب التفاصيل..." style="width: 100%; margin-top: 10px;" rows="3" required></textarea>
            <div style="margin-top: 15px; text-align: left;">
                <button type="submit" class="btn btn-primary">إرسال</button>
                <button type="button" class="btn btn-secondary" onclick="closeReportModal()">إلغاء</button>
            </div>
        </form>
    </div>
</div>



<!-- Modal البلاغ -->
<div id="reportModal" class="modal" style="display: none;">
    <div class="modal-box">
        <span class="close-btn" onclick="closeReportModal()">&times;</span>
        <h3 style="margin-bottom: 10px;">إرسال بلاغ</h3>
        <form method="POST" action="{{ route('reports.store') }}">
            @csrf
            <input type="hidden" name="type" value="review">
            <input type="hidden" name="entity_id" id="reportEntityId">
            <label>سبب البلاغ:</label>
            <textarea name="description" required style="width: 100%; height: 80px;"></textarea>
            <br>
            <button type="submit" style="margin-top: 10px;">إرسال</button>
        </form>
    </div>
</div>



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


<!-- مودال البلاغ -->
<div id="reportModal" class="modal" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 999;">
    <div class="modal-content" style="background: white; padding: 20px; margin: 10% auto; width: 90%; max-width: 500px; border-radius: 10px; position: relative;">
        <span onclick="closeReportModal()" style="position:absolute; top:10px; left:15px; cursor:pointer;">&times;</span>
        <h3>تقديم بلاغ</h3>
        <p><strong>المستخدم:</strong> <span id="reportedUserName"></span></p>
        <form id="reportForm">
            @csrf
            <input type="hidden" name="user_id" id="reportedUserId">
            <input type="hidden" name="entity_id" id="entityId">

            <label><input type="radio" name="type" value="محتوى مسيء" required> محتوى مسيء</label><br>
            <label><input type="radio" name="type" value="سبام" required> سبام</label><br>
            <label><input type="radio" name="type" value="أخرى" required> أخرى</label><br>

            <textarea name="description" id="reportDescription" placeholder="اكتب التفاصيل..." style="display:none; width: 100%; margin-top: 10px;" rows="3"></textarea>

            <div style="margin-top: 15px; text-align: left;">
                <button type="submit" class="btn btn-primary">إرسال</button>
                <button type="button" class="btn btn-secondary" onclick="closeReportModal()">إلغاء</button>
            </div>
        </form>
    </div>
</div>


<script>
    function openReportModal(type, entityId) {
    document.getElementById('reportType').value = type;
    document.getElementById('reportEntityId').value = entityId;
    document.getElementById('reportModal').style.display = 'flex';
}


    function closeReportModal() {
        document.getElementById('reportModal').style.display = 'none';
    }

    // إغلاق عند الضغط خارج الصندوق
    window.onclick = function(event) {
        const modal = document.getElementById('reportModal');
        if (event.target == modal) {
            closeReportModal();
        }
    }
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const openBtn = document.getElementById('openReportModal');
    const modal = document.getElementById('reportModal');
    const entityInput = document.getElementById('reportEntityId');

    if (openBtn) {
        openBtn.addEventListener('click', function () {
            const storeId = this.getAttribute('data-store-id');
            entityInput.value = storeId;
            modal.style.display = 'block';
        });
    }

    closeBtn.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    window.addEventListener('click', function (e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});
</script>

<script>
    @if ($errors->has('rating') || $errors->has('comment'))
        window.onload = function () {
            const reviewSection = document.getElementById('review-section');
            if (reviewSection) {
                reviewSection.scrollIntoView({ behavior: 'smooth' });
            }
        };
    @endif
</script>


</body>
</html>
