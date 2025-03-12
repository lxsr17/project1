@extends('layouts.app')

@section('title', 'قائمة المشرفين')

@section('content')
<div class="container">
    <h2>قائمة المشرفين</h2>
    <a href="{{ route('admins.create') }}" class="btn btn-success mb-3">إضافة مشرف جديد</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>رقم الهاتف</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $admin)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $admin->admin_name }}</td>
                <td>{{ $admin->email }}</td>
                <td>{{ $admin->phone }}</td>
                <td>
                    <a href="{{ route('admins.edit', $admin->id) }}" class="btn btn-warning">تعديل</a>
                    <form action="{{ route('admins.destroy', $admin->id) }}" method="POST" style="display:inline;">
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
