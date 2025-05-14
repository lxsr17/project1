<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>معلومات المتجر - لوحة التحكم</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/admin-store-details.css') }}">
</head>
<body>

<div class="container">
    <h1>معلومات المتجر</h1>

    {{-- البيانات الأساسية --}}
    <div class="section">
        <h2>البيانات الأساسية</h2>
        <div class="field"><span class="label">رقم المتجر (ID):</span><span class="value">{{ $store->id }}</span></div>
        <div class="field"><span class="label">اسم المتجر:</span><span class="value">{{ $store->business_name }}</span></div>
        <div class="field"><span class="label">نوع العمل:</span><span class="value">{{ $store->business_type ?? '-' }}</span></div>
        <div class="field"><span class="label">الوصف:</span><span class="value">{{ $store->description ?? '-' }}</span></div>
        <div class="field"><span class="label">الحالة:</span><span class="value status-{{ $store->status }}">{{ $store->status }}</span></div>
        <div class="field"><span class="label">تاريخ الإنشاء:</span><span class="value">{{ $store->created_at }}</span></div>
        <div class="field"><span class="label">تاريخ التحديث:</span><span class="value">{{ $store->updated_at }}</span></div>
    </div>

    {{-- معلومات الاتصال --}}
    <div class="section">
        <h2>معلومات الاتصال</h2>
        <div class="field"><span class="label">الهاتف 1:</span><span class="value">{{ $store->phone1 ?? '-' }}</span></div>
        <div class="field"><span class="label">الهاتف 2:</span><span class="value">{{ $store->phone2 ?? '-' }}</span></div>
        <div class="field"><span class="label">البريد الإلكتروني:</span><span class="value">{{ $store->email ?? '-' }}</span></div>
        <div class="field"><span class="label">المدينة:</span><span class="value">{{ $store->city ?? '-' }}</span></div>
        <div class="field"><span class="label">العنوان:</span><span class="value">{{ $store->address ?? '-' }}</span></div>
    </div>

    {{-- السياسات --}}
    <div class="section">
        <h2>السياسات</h2>
        <div class="field"><span class="label">سياسة الإرجاع:</span><span class="value">{{ $store->return_policy ?? 'لا يوجد شيء هنا' }}</span></div>
        <div class="field"><span class="label">السماح بالإرجاع:</span><span class="value">{{ $store->no_return_allowed ? 'لا' : 'نعم' }}</span></div>
        <div class="field"><span class="label">أيام الإرجاع:</span><span class="value">{{ $store->return_days ?? '-' }}</span></div>
        <div class="field"><span class="label">أيام الاستبدال:</span><span class="value">{{ $store->exchange_days ?? '-' }}</span></div>
    </div>

    {{-- روابط التواصل --}}
    <div class="section">
        <h2>روابط التواصل</h2>
        <div class="field"><span class="label">تويتر:</span><span class="value">{{ $store->show_twitter && $store->twitter ? $store->twitter : 'غير مفعل' }}</span></div>
        <div class="field"><span class="label">إنستقرام:</span><span class="value">{{ $store->show_instagram && $store->instagram ? $store->instagram : 'غير مفعل' }}</span></div>
        <div class="field"><span class="label">تيك توك:</span><span class="value">{{ $store->show_tiktok && $store->tiktok ? $store->tiktok : 'غير مفعل' }}</span></div>
        <div class="field"><span class="label">واتساب:</span><span class="value">{{ $store->whatsapp ?? '-' }}</span></div>
        <div class="field"><span class="label">تلغرام:</span><span class="value">{{ $store->telegram ?? '-' }}</span></div>
        <div class="field"><span class="label">موقع إلكتروني:</span><span class="value">{{ $store->website ?? '-' }}</span></div>
        <div class="field"><span class="label">تطبيق أندرويد:</span><span class="value">{{ $store->android_app ?? '-' }}</span></div>
        <div class="field"><span class="label">تطبيق iOS:</span><span class="value">{{ $store->ios_app ?? '-' }}</span></div>
    </div>

    <div class="section">
    <h2>المستندات</h2>

    <div class="field">
        <span class="label">رابط المتجر:</span>
        <span class="value">{{ $store->link_type ?? '-' }}</span>
    </div>

    {{-- السجل التجاري --}}
    <div class="field">
        <span class="label">السجل التجاري:</span>
        @if ($store->commercial_registration_document)
            <iframe src="{{ asset('storage/' . $store->commercial_registration_document) }}" class="file-preview" frameborder="0"></iframe>
        @else
            <span class="value text-muted">غير مرفق</span>
        @endif
    </div>

    {{-- وثيقة العمل الحر --}}
    <div class="field">
        <span class="label">وثيقة العمل الحر:</span>
        @if ($store->freelancer_document)
            <iframe src="{{ asset('storage/' . $store->freelancer_document) }}" class="file-preview" frameborder="0"></iframe>
        @else
            <span class="value text-muted">غير مرفقة</span>
        @endif
    </div>

    {{-- شعار المتجر --}}
    <div class="field">
        <span class="label">شعار المتجر:</span>
        @if ($store->logo)
            <iframe src="{{ asset('storage/' . $store->logo) }}" class="file-preview" frameborder="0"></iframe>
        @else
            <span class="value text-muted">لا يوجد شعار</span>
        @endif
    </div>
</div>

<div class="form-actions" style="display: flex; gap: 10px; margin-top: 30px;">
    {{-- زر الموافقة --}}
    <form method="POST" action="{{ route('admin.stores.approve', $store->id) }}" onsubmit="return confirm('هل أنت متأكد من الموافقة على هذا المتجر؟');">
        @csrf
        <button type="submit" class="btn btn-success">موافقة</button>
    </form>

    {{-- زر الرفض --}}
    <form method="POST" action="{{ route('admin.stores.reject', $store->id) }}" onsubmit="return confirm('هل أنت متأكد من رفض هذا المتجر؟');">
        @csrf
        <button type="submit" class="btn btn-danger">رفض</button>
    </form>
</div>


    <a href="{{ route('admin.dashboard') }}" class="back-btn">← العودة للوحة التحكم</a>
</div>

</body>
</html>
