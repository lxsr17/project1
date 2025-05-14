@php
    $isStoreOwner = Auth::guard('store_owner')->check();
    $isVisitor = Auth::guard('web')->check();
@endphp

<aside class="sidebar">
    <nav>
        <ul class="nav-menu">

            {{--  روابط التاجر --}}
            @if ($isStoreOwner)
                <li class="nav-item">
                    <a href="{{ route('merchant-dashboard') }}" class="nav-link {{ request()->routeIs('merchant-dashboard') ? 'active' : '' }}">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/home.svg" alt="">
                        <span>لوحة التحكم</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('my-businesses') }}" class="nav-link {{ request()->routeIs('my-businesses') ? 'active' : '' }}">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/briefcase.svg" alt="">
                        <span>أعمالي</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('subscriptions') }}" class="nav-link {{ request()->routeIs('subscriptions') ? 'active' : '' }}">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/credit-card.svg" alt="">
                        <span>اشتراكاتي</span>
                    </a>
                </li>
            @endif

            {{--  روابط الزائر --}}
            @if ($isVisitor)
                <li class="nav-item">
                    <a href="{{ route('visitor-dashboard') }}" class="nav-link {{ request()->routeIs('visitor-dashboard') ? 'active' : '' }}">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/home.svg" alt="">
                        <span>الصفحة الرئيسية</span>
                    </a>
                </li>
            @endif

            {{--  روابط مشتركة --}}
            @if ($isStoreOwner || $isVisitor)
                <li class="nav-item">
                    <a href="{{ route('stores_login_Marchent') }}" class="nav-link {{ request()->routeIs('stores_login_Marchent') ? 'active' : '' }}">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/store.svg" alt="">
                        <span>متاجر تحقق</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/circle-info.svg" alt="">
                        <span>عن تحقق</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('faq') }}" class="nav-link {{ request()->routeIs('faq') ? 'active' : '' }}">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/book.svg" alt="">
                        <span>الأسئلة الشائعة</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('privacy') }}" class="nav-link {{ request()->routeIs('privacy') ? 'active' : '' }}">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/shield.svg" alt="">
                        <span>سياسة الخصوصية</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('terms') }}" class="nav-link {{ request()->routeIs('terms') ? 'active' : '' }}">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/book-open.svg" alt="">
                        <span>شروط الاستخدام</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('contact_login_Marchent') }}" class="nav-link {{ request()->routeIs('contact_login_Marchent') ? 'active' : '' }}">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/phone.svg" alt="">
                        <span>تواصل معنا</span>
                    </a>
                </li>
            @endif

        </ul>
    </nav>
</aside>
@if(auth('store_owner')->check() && auth('store_owner')->user()->status === 'suspended')
    @include('components.account-suspended-modal', ['role' => 'تاجر'])
@elseif(auth('web')->check() && auth('web')->user()->status === 'suspended')
    @include('components.account-suspended-modal', ['role' => 'زائر'])
@endif

