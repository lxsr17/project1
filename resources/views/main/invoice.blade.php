<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة الدفع - منصة تحقق</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
    <link rel="stylesheet" href="{{ asset('css/subscriptions.css') }}">
</head>
<body>

@php
    $user = Auth::guard('store_owner')->user() ?? Auth::guard('web')->user();
    $plan = request('plan');
    $planName = $plan === 'premium' ? 'الباقة المميزة' : ($plan === 'ultra' ? 'الباقة الاحترافية' : 'باقة غير معروفة');
    $planPrice = $plan === 'premium' ? '20' : ($plan === 'ultra' ? '50' : '0');
@endphp

<header>
    @include('main.user-header')
</header>

<div class="dashboard">
    @include('layouts.sidebar')

    <main class="invoice-wrapper">
        <div class="invoice-box">
            <h1 class="invoice-title">فاتورة الاشتراك</h1>

            <div class="invoice-details">
                <p><strong>الاسم:</strong> {{ $user?->first_name }} {{ $user?->last_name }}</p>
                <p><strong> البريد الإلكتروني :</strong> {{ $user?->email }}</p>
                <p><strong>رقم الجوال:</strong> {{ $user?->phone }}</p>
                <p><strong>الباقة:</strong> {{ $planName }}</p>
                <p><strong>السعر:</strong> {{ $planPrice }} ريال / شهرياً</p>
                <p><strong>تاريخ الفاتورة:</strong> {{ now()->format('Y-m-d') }}</p>
            </div>

            <div class="invoice-actions">
                <form action="{{ route('payment.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="plan" value="{{ $plan }}">
                    <button type="submit" class="btn-pay">الدفع الآن</button>
                </form>
            </div>
        </div>
    </main>
</div>



<script>
  fetch('./user-header')
    .then(response => response.text())
    .then(data => {
      document.getElementById('user-header-container').innerHTML = data;
    });
</script>

<script src="{{ asset('js/invoice.js') }}"></script>
</body>
</html>
