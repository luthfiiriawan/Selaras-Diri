<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CMS Login | Selaras Diri</title>
    <link rel="icon" type="image/svg+xml" href="/images/logo.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="grid min-h-dvh place-items-center bg-sd-paper bg-[linear-gradient(135deg,rgba(235,139,123,0.16),rgba(166,176,178,0.12))] p-6 text-sd-ink">
    <div class="grid w-[min(520px,100%)] gap-7 rounded-lg border border-sd-ink/10 bg-sd-surface p-8 shadow-sd-md">
        <a class="flex w-fit items-center gap-3 font-extrabold text-sd-primary-dark" href="{{ route('home') }}">
            <img src="/images/logo.svg" alt="Selaras Diri" class="h-12 w-auto">
            <span>Selaras Diri CMS</span>
        </a>

        <div>
            <p class="eyebrow">Admin Area</p>
            <h1 class="m-0 font-serif text-4xl leading-tight">Masuk untuk mengelola konten website.</h1>
        </div>

        @if (session('status'))
            <p class="m-0 rounded-lg border border-sd-primary/20 bg-sd-sage/15 p-4 font-bold text-sd-primary">{{ session('status') }}</p>
        @endif
        @if ($errors->any())
            <p class="m-0 rounded-lg border border-sd-danger/20 bg-[#fff5f3] p-4 font-bold text-sd-danger">{{ $errors->first() }}</p>
        @endif

        <form action="{{ route('admin.authenticate') }}" method="POST" class="grid gap-4">
            @csrf
            <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft">
                <span>Email</span>
                <input class="min-h-12 w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" type="email" name="email" value="{{ old('email', config('cms.admin_email')) }}" autocomplete="username" required>
            </label>
            <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft">
                <span>Password</span>
                <input class="min-h-12 w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" type="password" name="password" autocomplete="current-password" required>
            </label>
            <button class="btn btn-primary" type="submit">Masuk CMS</button>
        </form>
    </div>
</body>
</html>
