<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>قائمة الأنشطة</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            direction: rtl;
            text-align: right;
        }
        a {
            text-align: right;
            display: block;
        }
    </style>
</head>
<body class="container mt-5">

    <h2 class="mb-4">جميع الأنشطة التجارية</h2>

    <a href="{{ route('stores.create') }}" class="btn btn-primary mb-3">إضافة نشاط جديد</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>الاسم</th>
                <th>اسم المالك</th>
                <th>البريد الإلكتروني</th>
                <th>الفئة</th>
                <th>الموقع</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stores as $store)
            <tr>
                <td>{{ $store->name }}</td>
                <td>{{ $store->owner_name }}</td>
                <td>{{ $store->email }}</td>
                <td>{{ $store->category }}</td>
                <td>{{ $store->location }}</td>
                <td>
                    <a href="{{ route('stores.show', $store->id) }}" class="btn btn-info btn-sm">عرض</a>
                    <a href="{{ route('stores.edit', $store->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                    <form action="{{ route('stores.destroy', $store->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا النشاط؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
