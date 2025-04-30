<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\NotificationController;
use App\Models\Notification;


use App\Http\Controllers\BusinessController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\StoreOwnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ✅ الصفحة الرئيسية
Route::get('/', fn() => view('main.index'))->name('index');

// ✅ تسجيل الدخول والخروج
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout-store', [ProfileController::class, 'logout'])->name('store.logout');

// ✅ تسجيل الزائر والتاجر
Route::get('/register', fn() => view('auth.register'))->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
Route::get('/merchant-register', [StoreOwnerController::class, 'create'])->name('merchant.register');
Route::post('/merchant-register', [StoreOwnerController::class, 'store'])->name('merchant.store');

// ✅ لوحة تحكم
Route::get('/merchant-dashboard', fn() => view('main.merchant-dashboard'))->middleware('auth:store_owner')->name('merchant-dashboard');
Route::get('/visitor-dashboard', fn() => view('main.visitor-dashboard'))->middleware('auth:web')->name('visitor-dashboard');

// ✅ الصفحات العامة (عن، سياسة، شروط)
Route::get('/about', fn() => view('main.about'))->name('about');
Route::get('/faq', fn() => view('main.faq'))->name('faq');
Route::get('/privacy', fn() => view('main.privacy'))->name('privacy');
Route::get('/terms', fn() => view('main.terms'))->name('terms');

// ✅ صفحات للمسجلين فقط (تاجر أو زائر)
Route::middleware(['auth:web,store_owner'])->group(function () {
    Route::get('/stores_login_Marchent', [StoreController::class, 'index'])->name('stores_login_Marchent');
    Route::get('/contact_login_Marchent', fn() => view('main.contact_login_Marchent'))->name('contact_login_Marchent');
});

// ✅ صفحات للزوار فقط (غير المسجلين)
Route::middleware('guest')->group(function () {
    Route::get('/stores', [StoreController::class, 'index'])->name('stores');
    Route::get('/contact', fn() => view('main.contact'))->name('contact');
    Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');
});

// ✅ تفاصيل المتجر وبحث المتاجر
Route::get('/store-details/{id}', [StoreController::class, 'show'])->name('store-details');
Route::get('/search-stores', [StoreController::class, 'searchStores'])->name('search.stores');

// ✅ ملف المستخدم
Route::get('/profile', [ProfileController::class, 'profile'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// ✅ صفحات خاصة بالتاجر
Route::middleware('auth:store_owner')->group(function () {
    Route::get('/subscriptions', fn() => view('main.subscriptions'))->name('subscriptions');
    Route::get('/my-businesses', [BusinessController::class, 'myBusinesses'])->name('my-businesses');

    // إضافة عمل
    Route::get('/add-business', fn() => view('main.add-business'))->name('add-business');
    Route::post('/add-business', [BusinessController::class, 'storeStep1'])->name('business.storeStep1');

    Route::get('/business-contact', fn() => view('main.business-contact'))->name('business-contact');
    Route::post('/business-contact', [BusinessController::class, 'storeContact'])->name('business-contact');

    Route::get('/business/additional', fn() => view('main.business-additional'))->name('business-additional');
    Route::post('/business-additional', [BusinessController::class, 'storeAdditional'])->name('business-additional.store');

    Route::get('/business-policies', fn() => view('main.business-policies'))->name('business-policies');
    Route::post('/business-policies', [BusinessController::class, 'storePolicies'])->name('business-policies');

    Route::get('/business-review', [BusinessController::class, 'review'])->name('business-review');
    Route::post('/business/submit', [BusinessController::class, 'submit'])->name('business.submit');

    Route::get('/business-success', fn() => view('main.business-success'))->name('business-success');

    // تعديل وحذف
    Route::get('/edit-business/{id}', [BusinessController::class, 'edit'])->name('business.edit');
    Route::match(['put', 'patch'], '/edit-business/{id}', [BusinessController::class, 'update'])->name('business.update');
    Route::delete('/business/{id}', [BusinessController::class, 'destroy'])->name('business.destroy');
});

// ✅ أدوات للمطور
Route::get('/notifications', fn() => view('main.notifications'))->name('notifications');
Route::get('/user-header', fn() => view('main.user-header'))->name('user-header');

Route::get('/check-login', function () {
    return [
        'web_logged_in' => Auth::guard('web')->check(),
        'store_owner_logged_in' => Auth::guard('store_owner')->check(),
        'user' => Auth::guard('web')->user(),
        'store_owner' => Auth::guard('store_owner')->user(),
    ];
});

Route::get('/test-auth', function () {
    return response()->json([
        'web_logged_in' => Auth::guard('web')->check(),
        'store_owner_logged_in' => Auth::guard('store_owner')->check(),
        'store_owner' => Auth::guard('store_owner')->user(),
        'default_user' => Auth::user(),
    ]);
});
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

//  الجلسات
Route::get('/sessions', [SessionController::class, 'index']);
Route::post('/logout-all-sessions', [SessionController::class, 'destroyAll']);
Route::get('/profile/sessions', [SessionController::class, 'sessions'])->name('profile.sessions');
Route::post('/profile/logout-sessions', [SessionController::class, 'logoutAll'])->name('profile.logout.sessions');
Route::get('/sessions', function () {
    $user = Auth::guard('store_owner')->user() ?? Auth::guard('web')->user();

    if (!$user) {
        return response()->json([], 401);
    }

    $sessions = DB::table('sessions')
                ->where('user_id', $user->id)
                ->get(['id', 'ip_address', 'user_agent', 'last_activity', DB::raw('FROM_UNIXTIME(last_activity) as updated_at'), DB::raw('FROM_UNIXTIME(last_activity) as created_at')]);

    // تضيف العمر الافتراضي للجلسة (حسب config/session.php)
    $lifetime = config('session.lifetime');

    $sessions = $sessions->map(function($session) use ($lifetime) {
        $session->lifetime = $lifetime;
        return $session;
    });

    return response()->json($sessions);
});
/////////////

Route::get('/subscription-plans', fn() => view('main.sub'))->name('subscription.plans');




//  عرض صفحة الفاتورة (تستقبل الباقة عبر GET)
Route::get('/invoice', function () {
    return view('main.invoice');
})->name('invoice');

//  تنفيذ الدفع الوهمي (لاحقاً تربطه ببوابة دفع حقيقية)
Route::post('/payment-process', function () {
    return redirect()->route('subscriptions')->with('success', 'تم الدفع بنجاح!');
})->name('payment.process');



// ✅ تسجيل دخول الإدمن
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ✅ تسجيل حساب إدمن جديد
Route::get('/admin/register', [AdminAuthController::class, 'showAdminRegisterForm'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'adminRegister'])->name('admin.register.submit');

// ✅ لوحات الإدمن (تتطلب تسجيل دخول وصلاحية)
Route::prefix('admin')->middleware(['auth:admin', 'admin.session.timeout'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('admin.notifications');
    
});
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard', [
        'storesCount' => \App\Models\Store::count(),
        'pendingStores' => \App\Models\Store::where('status', 'pending')->count(),
        'usersCount' => \App\Models\User::count(),
        'merchantCount' => \App\Models\Store::distinct('store_owner_id')->count(),
        'pendingApprovals' => \App\Models\Store::where('status', 'pending')->get(),
        'unreadCount' => Notification::where('is_read', false)->count(), 
        
    ]);
})->middleware(['auth:admin', \App\Http\Middleware\SessionTimeoutForAdmin::class])->name('admin.dashboard');
Route::get('/admin/stores', [\App\Http\Controllers\Admin\StoreController::class, 'index'])->name('admin.stores.index');
Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
Route::get('/admin/notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');
Route::get('/admin/stores', [StoreController::class, 'index'])->name('admin.stores.index');
Route::get('/admin/stores', [StoreController::class, 'adminIndex'])->name('admin.stores.index');

Route::get('notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');
Route::post('notifications', [NotificationController::class, 'store'])->name('admin.notifications.store');
Route::get('notifications/{id}', [NotificationController::class, 'show'])->name('admin.notifications.show');
Route::put('notifications/{id}', [NotificationController::class, 'update'])->name('admin.notifications.update');
Route::delete('notifications/{id}', [NotificationController::class, 'destroy'])->name('admin.notifications.destroy');

Route::post('/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('store.review');

 

// ✅ auth.php
require __DIR__.'/auth.php';
