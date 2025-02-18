<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>قائمة الأنشطة</title>
</head>
<body>

    <h2>جميع الأنشطة التجارية</h2>

    <a href="{{ route('businesses.create') }}">إضافة نشاط جديد</a>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table border="1">
        <tr>
            <th>الاسم</th>
            <th>اسم المالك</th>
            <th>البريد الإلكتروني</th>
            <th>الفئة</th>
            <th>الموقع</th>
            <th>الوصف</th>
        </tr>
        @foreach ($businesses as $business)
        <tr>
            <td>{{ $business->name }}</td>
            <td>{{ $business->owner_name }}</td>
            <td>{{ $business->email }}</td>
            <td>{{ $business->category }}</td>
            <td>{{ $business->location }}</td>
            <td>
                <a href="{{ route('businesses.show', $business->id) }}">عرض</a> |
                <a href="{{ route('businesses.edit', $business->id) }}">تعديل</a> |
                <form action="{{ route('businesses.destroy', $business->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">حذف</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

</body>
</html>
