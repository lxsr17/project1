<!DOCTYPE html>
<html lang="ar">
<head>
<link rel="stylesheet" href="{{ asset('css/admin-register.css') }}">
    <meta charset="UTF-8">
    <title>تسجيل إدمن جديد</title>
</head>
<body>
    <h2>تسجيل إدمن جديد</h2>

    <form method="POST" action="{{ route('admin.register.submit') }}">
        @csrf

        <div>
            <label>اسم المستخدم</label>
            <input type="text" name="username" required>
        </div>

        <div>
            <label>الاسم الكامل</label>
            <input type="text" name="admin_name" required>
        </div>

        <div>
            <label>رقم الجوال</label>
            <input type="text" name="phone" required>
        </div>

        <div>
            <label>الجنس</label>
            <select name="sex" required>
                <option value="Male">ذكر</option>
                <option value="Female">أنثى</option>
            </select>
        </div>

        <div>
            <label>البريد الإلكتروني</label>
            <input type="email" name="email" required>
        </div>

        <div>
            <label>كلمة المرور</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label>تأكيد كلمة المرور</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit">تسجيل</button>
    </form>
</body>
</html>
