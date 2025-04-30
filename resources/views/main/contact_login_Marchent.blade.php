<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تواصل معنا - منصة تحقق</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/merchant-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
</head>

<body>
<header>
            @include('main.user-header')
        </header>
<div class="dashboard">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <main class="contact-page guest-view">
        <div class="contact-container">
            <div class="contact-info">
                <h2>نسعد بتواصلك معنا</h2>
                <p>تواصلوا معنا عبر قنواتنا الرسمية</p>
                <div class="social-links">
                    <a href="https://www.instagram.com/" class="social-link">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/brands/instagram.svg" alt="Instagram">
                    </a>
                    <a href="https://x.com/" class="social-link">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/brands/twitter.svg" alt="Twitter">
                    </a>
                    <a href="https://youtube.com/" class="social-link">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/brands/youtube.svg" alt="YouTube">
                    </a>
                    <a href="https://gmail.com/" class="social-link">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/envelope.svg" alt="Email">
                    </a>
                </div>
            </div>
            <div class="contact-form-container">
                <form id="contactForm" class="contact-form">
                    <div class="form-group">
                        <label for="fullName">الاسم بالكامل</label>
                        <input type="text" id="fullName" name="fullName" placeholder="الاسم بالكامل" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">رقم الجوال</label>
                        <input type="tel" id="phone" name="phone" placeholder="05XXXXXXXX" pattern="05[0-9]{8}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">البريد الإلكتروني</label>
                        <input type="email" id="email" name="email" placeholder="ex@email.com" required>
                    </div>
                    <div class="form-group">
                        <label for="reason">سبب الاتصال</label>
                        <select id="reason" name="reason" required>
                            <option value="">اختر</option>
                            <option value="inquiry">استفسار عام</option>
                            <option value="complaint">شكوى</option>
                            <option value="suggestion">اقتراح</option>
                            <option value="technical">مشكلة تقنية</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message">الرسالة</label>
                        <textarea id="message" name="message" placeholder="اكتب الرسالة هنا" required></textarea>
                    </div>
                    <div class="g-recaptcha" data-sitekey="your-recaptcha-site-key"></div>
                    <button type="submit" class="btn btn-primary submit-btn">إرسال</button>
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
    <script type="module" src="{{ asset('js/contact.js') }}"></script>
    </body>
</html>