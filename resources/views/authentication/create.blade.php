@extends('layouts.app')

@section('title', 'إضافة توثيق جديد')

@section('content')
<div class="container">
    <h2>إضافة توثيق جديد</h2>
    <form action="{{ route('authentication.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">معرف المستخدم</label>
            <input type="number" name="user_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">معرف المشرف</label>
            <input type="number" name="admin_id" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">معرف صاحب المتجر</label>
            <input type="number" name="store_owner_id" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">المصادقة الثنائية</label>
            <input type="text" name="two_factor_auth" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">إضافة</button>
    </form>
</div>
@endsection

