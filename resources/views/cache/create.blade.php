@extends('layouts.app')

@section('title', 'إضافة بيانات كاش')

@section('content')
<div class="container">
    <h2>إضافة بيانات كاش جديدة</h2>
    <form action="{{ route('cache.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">المفتاح</label>
            <input type="text" name="key" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">القيمة</label>
            <textarea name="value" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">تاريخ انتهاء الصلاحية</label>
            <input type="datetime-local" name="expiration" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">إضافة</button>
    </form>
</div>
@endsection
