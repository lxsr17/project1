@extends('layouts.app') <!-- ربط القالب الأساسي -->

@section('title', 'إضافة مشرف جديد') <!-- عنوان الصفحة -->

@section('content') <!-- يبدأ محتوى الصفحة -->
<div class="container">
    <h2>إضافة مشرف جديد</h2>
    <form action="{{ route('admins.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">اسم المستخدم</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">البريد الإلكتروني</label> <!-- حقل البريد الإلكتروني -->
            <input type="email" name="email" class="form-control" required> <!-- حقل البريد الإلكتروني -->
        </div>
        <div class="mb-3">
            <label class="form-label">كلمة المرور</label>   <!-- حقل كلمة المرور -->
            <input type="password" name="password" class="form-control" required>   <!-- حقل كلمة المرور -->
        </div>
        <div class="mb-3">
            <label class="form-label">اسم المشرف</label>
            <input type="text" name="admin_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">رقم الهاتف</label>
            <input type="text" name="phone" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">إضافة</button>
    </form>
</div>
@endsection <!-- ينتهي محتوى الصفحة -->

