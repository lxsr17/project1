@extends('layouts.app')

@section('title', 'إضافة فئة جديدة')

@section('content')
<div class="container">
    <h2>إضافة فئة جديدة</h2>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">اسم الفئة</label>
            <input type="text" name="category_name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">إضافة</button>
    </form>
</div>
@endsection

