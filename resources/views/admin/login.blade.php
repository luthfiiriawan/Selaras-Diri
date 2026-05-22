<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CMS Login | Selaras Diri</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-auth">
    <main class="login-shell">
        <section class="login-panel">
            <a class="brand" href="{{ route('home') }}">
                <span class="brand-mark">SD</span>
                <span>Selaras Diri CMS</span>
            </a>

            <div>
                <p class="eyebrow">Admin Area</p>
                <h1>Masuk untuk mengelola konten website.</h1>
            </div>

            @if (session('status'))
                <p class="notice">{{ session('status') }}</p>
            @endif

            @if ($errors->any())
                <p class="notice notice-error">{{ $errors->first() }}</p>
            @endif

            <form action="{{ route('admin.authenticate') }}" method="POST" class="cms-form">
                @csrf
                <label>
                    <span>Email</span>
                    <input type="email" name="email" value="{{ old('email', config('cms.admin_email')) }}" autocomplete="username" required>
                </label>
                <label>
                    <span>Password</span>
                    <input type="password" name="password" autocomplete="current-password" required>
                </label>
                <button class="button button-primary" type="submit">Masuk CMS</button>
            </form>
        </section>
    </main>
</body>
</html>
