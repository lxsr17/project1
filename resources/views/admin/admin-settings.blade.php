<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>لوحة التحكم - الإعدادات</title>
  <!-- Bootstrap RTL -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <!-- أيقونات Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-header.css') }}">
</head>
<body>
<header>
            @include('admin.admin-header')
        </header>
  <div class="dashboard">
    <!-- الشريط الجانبي -->
    <nav class="sidebar">
    @include('admin.sidebar')
    </nav>

    <!-- المحتوى الرئيسي -->
    <div class="main-content">
      <h2 class="mb-4">الإعدادات</h2>

      <!-- التبويبات -->
      <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">الإعدادات العامة</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" type="button" role="tab">إعدادات التواصل والتنبيهات</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab">إعدادات الأمان</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="updates-tab" data-bs-toggle="tab" data-bs-target="#updates" type="button" role="tab">إعدادات التحديثات والتحكم الديناميكي</button>
        </li>
      </ul>

      <!-- محتوى التبويبات -->
      <div class="tab-content" id="settingsTabsContent">
        <!-- الإعدادات العامة -->
        <div class="tab-pane fade show active" id="general" role="tabpanel">
          <form>
            <label>اسم الموقع</label>
            <input type="text" class="form-control" placeholder="منصة تحقق">
            <label>وصف الموقع</label>
            <input type="text" class="form-control" placeholder="منصة للتحقق من المتاجر">
            <label>البريد الإلكتروني</label>
            <input type="email" class="form-control" placeholder="example@domain.com">
            <label>رقم الهاتف</label>
            <input type="text" class="form-control" placeholder="+966 12 345 6789">
            <button type="submit" class="btn btn-primary">حفظ الإعدادات</button>
          </form>
        </div>

        <!-- إعدادات التواصل والتنبيهات -->
        <div class="tab-pane fade" id="notifications" role="tabpanel">
          <form>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="emailNotif">
              <label class="form-check-label" for="emailNotif">تفعيل إشعارات البريد الإلكتروني</label>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="pushNotif">
              <label class="form-check-label" for="pushNotif">تفعيل الإشعارات المنبثقة</label>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="newStoreNotif">
              <label class="form-check-label" for="newStoreNotif">إشعار عند إضافة متجر جديد</label>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="newReportNotif">
              <label class="form-check-label" for="newReportNotif">إشعار عند وجود بلاغ جديد</label>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="newUserNotif">
              <label class="form-check-label" for="newUserNotif">إشعار عند تسجيل مستخدم جديد</label>
            </div>
            <button type="submit" class="btn btn-primary">حفظ الإعدادات</button>
          </form>
        </div>

        <!-- إعدادات الأمان -->
        <div class="tab-pane fade" id="security" role="tabpanel">
          <form>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="twoFactor">
              <label class="form-check-label" for="twoFactor">تفعيل المصادقة الثنائية</label>
            </div>
            <label>مدة انتهاء الجلسة (دقائق)</label>
            <input type="number" class="form-control" value="30">
            <label>مدة صلاحية كلمة المرور (أيام)</label>
            <input type="number" class="form-control" value="90">
            <label>الحد الأدنى لطول كلمة المرور</label>
            <input type="number" class="form-control" value="8">
            <button type="submit" class="btn btn-primary">حفظ الإعدادات</button>
          </form>
        </div>

        <!-- إعدادات التحديثات والتحكم الديناميكي -->
        <div class="tab-pane fade" id="updates" role="tabpanel">
          <form>
            <label>تحديثات تلقائية</label>
            <select class="form-select">
              <option>مفعلة</option>
              <option>غير مفعلة</option>
            </select>
            <label>فحص التحديثات كل (أيام)</label>
            <input type="number" class="form-control" value="7">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="dynamicControl">
              <label class="form-check-label" for="dynamicControl">تمكين التحكم الديناميكي</label>
            </div>
            <button type="submit" class="btn btn-primary">حفظ الإعدادات</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
