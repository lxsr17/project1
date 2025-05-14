<div id="suspendedModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 9999; display: flex; align-items: center; justify-content: center;">
    <div style="background: white; padding: 2rem; border-radius: 10px; max-width: 400px; text-align: center;">
        <h2>🚫 حسابك موقوف</h2>
        @php
            $name = auth('store_owner')->check()
                ? auth('store_owner')->user()->username
                : (auth('web')->check() ? auth('web')->user()->username : 'المستخدم');
        @endphp

        <p>عزيزي {{ $name }}، تم إيقاف حسابك من قبل الإدارة ولا يمكنك استخدام المنصة حالياً.</p>

        <p style="margin-top: 1rem;">
            يرجى التواصل مع
            <a href="{{ route('contact') }}" style="color: #007bff; text-decoration: underline;">الدعم الفني</a>
            للمزيد من التفاصيل.
        </p>

        <a href="{{ route('logout') }}" class="btn btn-danger mt-3"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            تسجيل الخروج
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>
