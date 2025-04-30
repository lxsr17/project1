<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل دخول الإدمن</title>
    <link rel="stylesheet" href="{{ asset('css/admin-login.css') }}">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
        form div {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
        }
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>تسجيل دخول الإدمن</h2>

    @if ($errors->any())
        <div class="error-message">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf
        <div>
            <label for="email">البريد الإلكتروني</label>
            <input type="email" name="email" id="email" required autofocus>
        </div>
        <div>
            <label for="password">كلمة المرور</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit">دخول</button>
    </form>
</div>

</body>
</html>
