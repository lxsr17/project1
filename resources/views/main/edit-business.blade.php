<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل بيانات العمل - منصة تحقق</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add-business.css') }}">
</head>
<header>
            @include('main.user-header')
        </header>
<body>

    <div class="dashboard">
        <aside class="sidebar">
            @include('layouts.sidebar')
        </aside>

        <main class="add-business-page">
            <div class="steps-container">
                <div class="page-header">
                    <h1 class="page-title">تعديل بيانات العمل</h1>
                </div>

                <div class="form-content">
                    <form id="editBusinessForm" action="{{ route('business.update', $business->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        @php
                            $names = explode(' / ', $business->business_name);
                            $name_ar = $names[0] ?? '';
                            $name_en = $names[1] ?? '';
                            $types = explode(' - ', $business->business_type);
                            $main_category = $types[0] ?? '';
                            $sub_category = $types[1] ?? '';
                        @endphp

                        <div class="form-section">
                            <h3 class="form-section-title">
                                <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/store.svg" alt="">
                                شعار العمل (اختياري)
                            </h3>
                            <div class="form-grid">
                                <div class="form-group full-width">
                                    <label for="businessLogo">الشعار</label>
                                    <input type="file" id="businessLogo" name="businessLogo" accept="image/*">
                                    @if($business->logo)
                                        <img src="{{ asset('storage/' . $business->logo) }}" alt="Current Logo" style="max-width: 100px;">
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h3 class="form-section-title">
                                <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/info-circle.svg" alt="">
                                بيانات العمل
                            </h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="businessNameAr">اسم العمل - اللغة العربية</label>
                                    <input type="text" id="businessNameAr" name="businessNameAr" value="{{ old('businessNameAr', $name_ar) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="businessNameEn">اسم العمل - اللغة الإنجليزية</label>
                                    <input type="text" id="businessNameEn" name="businessNameEn" value="{{ old('businessNameEn', $name_en) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="mainCategory">نوع العمل الرئيسي</label>
                                    <select id="mainCategory" name="mainCategory" required>
                                        <option value="">اختر التصنيف</option>
                                        <option value="retail" {{ old('mainCategory', $main_category) == 'retail' ? 'selected' : '' }}>متجر تجزئة</option>
                                        <option value="wholesale" {{ old('mainCategory', $main_category) == 'wholesale' ? 'selected' : '' }}>متجر جملة</option>
                                        <option value="services" {{ old('mainCategory', $main_category) == 'services' ? 'selected' : '' }}>خدمات</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="subCategory">تصنيف العمل الفرعي</label>
                                    <select id="subCategory" name="subCategory" data-selected="{{ old('subCategory', $sub_category) }}">
                                        <option value="">اختر التصنيف</option>
                                    </select>
                                </div>

                                <div class="form-group full-width">
                                    <label for="businessDescription">وصف العمل</label>
                                    <textarea id="businessDescription" name="businessDescription" required>{{ old('businessDescription', $business->description) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <div class="back-button-container" style="margin: 1rem 0; text-align: left;">
                                <a href="{{ url()->previous() }}" class="btn-back" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background-color: #f0f0f0; border-radius: 8px; color: #333; text-decoration: none; font-weight: 500; transition: background-color 0.3s; direction: ltr;" onmouseover="this.style.backgroundColor='#e0e0e0'" onmouseout="this.style.backgroundColor='#f0f0f0'">
                                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/arrow-left.svg" alt="رجوع" style="width: 16px; height: 16px; transform: scaleX(-1);">
                                    <span>رجوع</span>
                                </a>
                            </div>

                            <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                        </div>

                    </form>
                </div>
            </div>
        </main>
    </div>

    <script type="module" src="{{ asset('js/user-header.js') }}"></script>
    <script src="{{ asset('js/edit-business.js') }}"></script>
</body>
</html>
