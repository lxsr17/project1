@extends('layouts.app')

@section('title', 'قائمة الكاش')

@section('content')
<div class="container">
    <h2>قائمة بيانات الكاش</h2>
    <a href="{{ route('cache.create') }}" class="btn btn-success mb-3">إضافة بيانات كاش جديدة</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>المفتاح</th>
                <th>القيمة</th>
                <th>تاريخ الانتهاء</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($caches as $cache)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $cache->key }}</td>
                <td>{{ $cache->value }}</td>
                <td>{{ $cache->expiration }}</td>
                <td>
                    <form action="{{ route('cache.destroy', $cache->key) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
