@extends('layouts.app')

@section('title', 'قائمة التوثيق')

@section('content')
<div class="container">
    <h2>قائمة التوثيق</h2>
    <a href="{{ route('authentication.create') }}" class="btn btn-success mb-3">إضافة توثيق جديد</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>معرف المستخدم</th>
                <th>معرف المشرف</th>
                <th>معرف صاحب المتجر</th>
                <th>المصادقة الثنائية</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($authentications as $auth)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $auth->user_id }}</td>
                <td>{{ $auth->admin_id }}</td>
                <td>{{ $auth->store_owner_id }}</td>
                <td>{{ $auth->two_factor_auth }}</td>
                <td>
                    <form action="{{ route('authentication.destroy', $auth->id) }}" method="POST" style="display:inline;">
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
