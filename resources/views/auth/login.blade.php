<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تسجيل الدخول - تحقق</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  
</head>
<body>
  <header class="sticky-top bg-white shadow-sm py-3">
    <div class="container d-flex align-items-center justify-content-between">
      <div class="logo d-flex align-items-center">
        
        <span class="ms-2 fw-bold fs-4">TAHQIQ</span>
      </div>
      <nav>
        <ul class="nav">
          <li class="nav-item"><a href="index.html" class="nav-link">الرئيسية</a></li>
          <li class="nav-item"><a href="#" class="nav-link">متاجر تحقق</a></li>
          <li class="nav-item"><a href="#" class="nav-link">تواصل معنا</a></li>
        </ul>
      </nav>
      <div class="auth">
        <a href="login.html" class="btn btn-primary rounded-pill ms-2">تسجيل الدخول</a>
        <a href="register.html" class="btn btn-outline-primary rounded-pill">إنشاء حساب</a>
      </div>
    </div>
  </header>

  <section class="py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <h1 class="text-center mb-4">تسجيل الدخول</h1>

          <!-- User Type Selection -->
          <div class="text-center mb-4">
            <button class="btn btn-primary m-2" id="guestLoginBtn">زائر</button>
            <button class="btn btn-secondary m-2" id="storeOwnerLoginBtn">صاحب متجر</button>
          </div>

          <!-- Guest Login Form -->
          <form id="guestLoginForm" style="display: none;">
            <div class="mb-3">
              <label for="guestEmail" class="form-label text-end d-block">البريد الإلكتروني</label>
              <input type="email" class="form-control" id="guestEmail" required>
            </div>
            <div class="mb-3">
              <label for="guestPassword" class="form-label text-end d-block">كلمة المرور</label>
              <input type="password" class="form-control" id="guestPassword" required>
            </div>
            <div class="mb-3 form-check text-end">
              <input type="checkbox" class="form-check-input" id="guestRememberMe">
              <label class="form-check-label" for="guestRememberMe">تذكرني</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">تسجيل الدخول كزائر</button>
          </form>

          <!-- Store Owner Login Form -->
          <form id="storeOwnerLoginForm" style="display: none;">
            <div class="mb-3">
              <label for="storeOwnerEmail" class="form-label text-end d-block">البريد الإلكتروني</label>
              <input type="email" class="form-control" id="storeOwnerEmail" required>
            </div>
            <div class="mb-3">
              <label for="storeOwnerPassword" class="form-label text-end d-block">كلمة المرور</label>
              <input type="password" class="form-control" id="storeOwnerPassword" required>
            </div>
            <div class="mb-3 form-check text-end">
              <input type="checkbox" class="form-check-input" id="storeOwnerRememberMe">
              <label class="form-check-label" for="storeOwnerRememberMe">تذكرني</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">تسجيل الدخول كصاحب متجر</button>
          </form>
        </div>
      </div>
    </div>
  </section>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const guestLoginBtn = document.getElementById('guestLoginBtn');
      const storeOwnerLoginBtn = document.getElementById('storeOwnerLoginBtn');
      const guestLoginForm = document.getElementById('guestLoginForm');
      const storeOwnerLoginForm = document.getElementById('storeOwnerLoginForm');

      guestLoginBtn.addEventListener('click', function() {
        guestLoginForm.style.display = 'block';
        storeOwnerLoginForm.style.display = 'none';
      });

      storeOwnerLoginBtn.addEventListener('click', function() {
        storeOwnerLoginForm.style.display = 'block';
        guestLoginForm.style.display = 'none';
      });
    });
  </script>
</body>
</html>
