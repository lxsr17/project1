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
use App\Http\Controllers\Notification_Controller;



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

Route::post('/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('store.review');


// ✅ تسجيل دخول الإدمن
Route::get('/admin.login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin.login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin.logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ✅ تسجيل حساب إدمن جديد
Route::get('/admin/register', [AdminAuthController::class, 'showAdminRegisterForm'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'adminRegister'])->name('admin.register.submit');



Route::prefix('admin')->middleware(['auth:admin', 'admin.session.timeout'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::view('/notifications', 'admin.admin-notifications')->name('admin.notifications');
    Route::view('/reports', 'admin.admin-reports')->name('admin.reports');
    Route::view('/stores', 'admin.admin-stores')->name('admin.stores');
    Route::view('/users', 'admin.admin-users')->name('admin.users');
    Route::view('/settings', 'admin.admin-settings')->name('admin.settings');

    // صفحات إضافية
    Route::view('/main', 'admin.admin')->name('admin.main');
    Route::view('/create', 'admin.create')->name('admin.create');
    Route::view('/edit', 'admin.edit')->name('admin.edit');
    Route::view('/index', 'admin.index')->name('admin.index');
    Route::view('/login', 'admin.login')->name('admin.login.view');
    Route::view('/register', 'admin.register')->name('admin.register.view');
    Route::view('/sidebar', 'admin.sidebar')->name('admin.sidebar');
});

Route::prefix('admin/stores')->name('admin.stores.')->middleware('auth:admin')->group(function () {
    Route::get('/{id}/details', [StoreController::class, 'show'])->name('details');
    Route::patch('/{id}/suspend', [StoreController::class, 'suspend'])->name('suspend');
    Route::patch('/{id}/resume', [StoreController::class, 'resume'])->name('resume');
    Route::delete('/{id}/delete', [StoreController::class, 'destroy'])->name('delete');
    Route::post('/{id}/notify', [StoreController::class, 'notify'])->name('notify');
});


Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::get('/admin/stores', [BusinessController::class, 'adminIndex'])->name('admin.stores');

Route::post('/admin/stores/{id}/approve', [AdminController::class, 'approveLicense'])->name('admin.stores.approve');
Route::post('/admin/stores/{id}/reject', [AdminController::class, 'rejectLicense'])->name('admin.stores.reject');

Route::get('/admin/stores/{id}/view', [AdminController::class, 'viewStore']);

Route::get('/admin/stores/{id}/details', [AdminController::class, 'showStoreDetails'])->name('admin.stores.details');

Route::post('/admin/stores/{id}/approve', [StoreController::class, 'approve'])->name('admin.stores.approve');
Route::post('/admin/stores/{id}/reject', [StoreController::class, 'reject'])->name('admin.stores.reject');


Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users')->middleware('auth:admin');

Route::prefix('admin/users')->name('admin.users.')->middleware('auth:admin')->group(function () {
    Route::patch('{id}/suspend', [AdminController::class, 'suspendUser'])->name('suspend');
    Route::patch('{id}/resume', [AdminController::class, 'resumeUser'])->name('resume');
    Route::delete('{id}/delete', [AdminController::class, 'deleteUser'])->name('delete');
});

Route::post('/reports', [ReportController::class, 'store'])->name('reports.store')->middleware('auth');
Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports');


Route::post('/admin/reports/{id}/action', [ReportController::class, 'takeAction'])->name('admin.reports.action');


Route::middleware('auth:web')->get('/recent-reviews', [ReviewController::class, 'recentReviews']);

Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('review.delete');
Route::delete('/review/{id}', [ReviewController::class, 'destroy'])->name('review.delete');

Route::get('/redirect-after-login', function () {
    // تقدر تفحص نوع المستخدم وتوجهه بشكل يدوي هنا
    if (auth('web')->check()) {
        return redirect()->route('visitor-dashboard');
    } elseif (auth('store_owner')->check()) {
        return redirect()->route('merchant-dashboard');
    } elseif (auth('admin')->check()) {
        return redirect()->route('admin-dashboard');
    }
    return redirect('/');
});


// المسار لتنفيذ إجراء على البلاغ
Route::post('/reports/{id}/action', [ReportController::class, 'takeAction'])->name('reports.action');


Route::middleware(['admin'])->group(function () {
    Route::get('/admin/notifications', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('admin.notifications.index');
    Route::delete('/admin/notifications/{id}', [App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('admin.notifications.destroy');
});
// مسار صفحة الإشعارات في لوحة التحكم
Route::prefix('admin')->middleware(['admin'])->group(function () {
    Route::get('/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('admin.notifications');
});

Route::get('/notifications/fetch', [\App\Http\Controllers\Admin\NotificationController::class, 'fetch'])->middleware(['auth:store_owner,web']);
Route::post('/admin/stores/send-notification', [StoreController::class, 'sendNotificationAjax'])->name('admin.stores.notify.ajax');
Route::post('/admin/stores/{id}/notify', [StoreController::class, 'notify'])->name('admin.stores.notify');
Route::get('/store/{id}', [\App\Http\Controllers\StoreController::class, 'show'])->name('store.details');
Route::post('/admin/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'store'])->middleware('admin');
Route::get('/admin/stores', [StoreController::class, 'adminStores'])->name('admin.stores');

Route::middleware(['auth:web,store_owner'])->group(function () {
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
});
// ✅ auth.php
require __DIR__.'/auth.php';
// ✅ مسارات الإشعارات المشتركة (تاجر/زائر)
Route::middleware(['auth:web,store_owner'])->group(function () {
    Route::get('/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'userNotifications'])->name('notifications.page');
    Route::get('/notifications/fetch', [\App\Http\Controllers\Admin\NotificationController::class, 'fetch'])->name('notifications.fetch');
    Route::post('/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'store'])->name('notifications.store');
});


// ✅ مسارات الإشعارات للإدمن
Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('admin.notifications');
    Route::post('/notifications', [NotificationController::class, 'store'])->name('admin.notifications.store');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('admin.notifications.destroy');
});

// ✅ مسارات إدارة المستخدمين للإدمن
Route::prefix('admin/users')->middleware(['auth:admin'])->name('admin.users.')->group(function () {
    Route::patch('/{id}/suspend', [AdminController::class, 'suspendUser'])->name('suspend');
    Route::patch('/{id}/resume', [AdminController::class, 'resumeUser'])->name('resume');
    Route::delete('/{id}', [AdminController::class, 'deleteUser'])->name('delete');
});

// عرض صفحة الإشعارات للمستخدم (تاجر أو زائر)
Route::get('/notifications', [Notification_Controller::class, 'userNotifications'])->name('notifications.page');

// جلب الإشعارات بشكل ديناميكي (مثلاً عبر AJAX)
Route::get('/notifications/fetch', [Notification_Controller::class, 'fetch'])->middleware(['auth:store_owner,web']);
