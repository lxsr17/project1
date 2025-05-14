<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أعمالي - منصة تحقق</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/my-businesses.css') }}">
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header>
        @include('main.user-header')
    </header>

    <div class="dashboard">
        <aside class="sidebar">
            @include('layouts.sidebar')
        </aside>

        <main class="businesses-page">
            <div class="page-header">
                <h1 class="page-title">أعمالي</h1>
                <a href="{{ route('add-business') }}" class="add-business-btn" id="addBusinessBtn">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/plus.svg" alt="">
                    <span>إضافة عمل جديد</span>
                </a>
            </div>

            <p class="results-count">تم العثور على {{ count($businesses) }} متجر</p>

            <div class="businesses-grid">
                @forelse ($businesses as $business)
                    @php
                        $names = explode(' / ', $business->business_name);
                        $businessNameAr = $names[0] ?? '';
                        $statusText = match($business->status) {
                            'draft' => 'غير مكتمل',
                            'pending' => 'قيد المراجعة',
                            'approved' => 'معتمد',
                            'rejected' => 'مرفوض',
                            default => 'غير معروف',
                        };
                    @endphp
                    <div class="business-card" onclick="window.location.href='{{ route('store-details', $business->id) }}'">
    @php
        $hasRealLogo = $business->logo && file_exists(public_path('storage/' . ltrim($business->logo, '/')));
        $logoPath = $hasRealLogo ? asset('storage/' . ltrim($business->logo, '/')) : asset('images/placeholder.png');
    @endphp

    <div class="business-logo" style="position: relative; width: 120px; height: 120px;">
        <img src="{{ $logoPath }}" alt="{{ $businessNameAr }}" style="width: 100%; height: 100%; object-fit: cover;">

        @if ($business->commercial_registration_document)
            <img src="{{ asset('images/frames/gold-frame.png') }}" alt="ذهبي" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
        @elseif ($business->freelancer_document)
            <img src="{{ asset('images/frames/silver-frame.png') }}" alt="فضي" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
        @endif


                    </div>
                        <div class="business-info">
                            <div class="business-header">
                                <div>
                                    <h3 class="business-name">{{ $businessNameAr }}</h3>
                                    <p class="store-category">{{ $business->business_type }}</p>
                                </div>
                                <span class="business-status {{ $business->status }}">{{ $statusText }}</span>
                            </div>
                            <div class="store-rating">
                                <span class="stars">★★★★★</span>
                                <span class="rating-count">لا يوجد تقييم بعد</span>
                            </div>
                            <div class="business-actions" onclick="event.stopPropagation();">
                                <a class="action-btn edit-btn" href="{{ route('business.edit', $business->id) }}">
                                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/pen.svg" alt="">
                                    تعديل
                                </a>
                                <button class="action-btn share-btn" onclick="copyShareLink('{{ $business->id }}')">
                                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/share-nodes.svg" alt="">
                                    مشاركة
                                </button>
                                <form method="POST" action="{{ route('business.destroy', $business->id) }}" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="action-btn delete-btn delete-confirm">
                                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/trash.svg" alt=""/>
                                        حذف
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/store.svg" alt="Empty state" class="empty-icon">
                        <h2>لا يوجد لديك أي أعمال حالياً</h2>
                        <p>ابدأ بإضافة عملك الأول على منصة تحقق</p>
                        
                    </div>
                @endforelse
            </div>
        </main>
    </div>

    <!-- Modal تأكيد الحذف -->
    <div id="deleteModal" class="modal" style="display: none;">
        <div class="modal-content">
            <p>هل أنت متأكد أنك تريد حذف هذا المتجر؟ لا يمكن التراجع عن هذا الإجراء.</p>
            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 1rem;">
                <button id="cancelDeleteBtn" style="padding: 0.5rem 1rem;">إلغاء</button>
                <button id="confirmDeleteBtn" style="padding: 0.5rem 1rem; background-color: #dc3545; color: white;">حذف</button>
            </div>
        </div>
    </div>

    <script>
        function copyShareLink(id) {
            const shareUrl = `${window.location.origin}/store-details/${id}`;
            const tempInput = document.createElement('input');
            tempInput.value = shareUrl;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            Swal.fire('تم النسخ!', 'تم نسخ رابط المتجر إلى الحافظة.', 'success');
        }
    </script>

    <script type="module" src="{{ asset('js/my-businesses.js') }}"></script>
    <script type="module" src="{{ asset('js/modal.js') }}"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const addBusinessBtn = document.getElementById('addBusinessBtn');
        const businessesCount = {{ count($businesses) }};

        addBusinessBtn.addEventListener('click', function (e) {
            if (businessesCount >= 4) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'تنبيه!',
                    text: 'لا يمكنك إضافة أكثر من ٤ أعمال.',
                    confirmButtonText: 'حسنًا'
                });
            }
        });
    });
    </script>
</body>
</html>
