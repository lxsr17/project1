<aside class="sidebar">
    <nav>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/home.svg" alt="">
                    <span>الرئيسية</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.stores.index') }}" class="nav-link {{ request()->routeIs('admin.stores.*') ? 'active' : '' }}">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/store.svg" alt="">
                    <span>المتاجر</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/users.svg" alt="">
                    <span>المستخدمين</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/flag.svg" alt="">
                    <span>البلاغات</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.notifications.index') }}" class="nav-link {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/bell.svg" alt="">
                    <span>الإشعارات</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/gear.svg" alt="">
                    <span>الإعدادات</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>