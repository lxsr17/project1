<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة نشاط جديد</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <style>
    body {
        direction: rtl;
        text-align: right;
    }
    label, input, textarea {
        display: block;
        text-align: right;
    }
</style>
<style>
    body {
        direction: rtl;
        text-align: right;
    }
</style>
<style>
    body {
        direction: rtl;
        text-align: right;
    }
    a {
        text-align: right;
        display: block;
    }
    .center-align {
    text-align: center;
}

</style>

</head>
<body class="container mt-5 text-end">

<h2 class="mb-4 center-align">إضافة نشاط جديد</h2>


  


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('stores.store') }}" method="POST">
        @csrf
        <div class="mb-3 text-end">
            <label class="form-label">اسم النشاط:</label>
            <input type="text" name="name" class="form-control text-end" required>
        </div>

        <div class="mb-3 text-end">
            <label class="form-label">اسم المالك:</label>
            <input type="text" name="owner_name" class="form-control text-end" required>
        </div>

        <div class="mb-3 text-end">
            <label class="form-label">البريد الإلكتروني:</label>
            <input type="email" name="email" class="form-control text-end" required>
        </div>

        <div class="mb-3 text-end">
            <label class="form-label">رقم الهاتف:</label>
            <input type="text" name="phone" class="form-control text-end">
        </div>

        <div class="mb-3 text-end">
            <label class="form-label">الوصف:</label>
            <textarea name="description" class="form-control text-end"></textarea>
        </div>

        <div class="mb-3 text-end">
            <label class="form-label">الفئة:</label>
            <input type="text" name="category" class="form-control text-end" required>
        </div>

        <div class="mb-3 text-end">
            <label class="form-label">الموقع:</label>
            <input type="text" name="location" class="form-control text-end">
        </div>

        <button type="submit" class="btn btn-success">إضافة</button>
    </form>

</body>
</html>
