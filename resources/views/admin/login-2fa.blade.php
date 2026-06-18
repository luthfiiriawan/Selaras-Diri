<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi 2FA | Selaras Diri</title>
    <link rel="icon" type="image/svg+xml" href="/images/logo.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="grid min-h-dvh place-items-center bg-sd-paper bg-[linear-gradient(135deg,rgba(235,139,123,0.16),rgba(166,176,178,0.12))] p-6 text-sd-ink">
    <div class="grid w-[min(520px,100%)] gap-7 rounded-lg border border-sd-ink/10 bg-sd-surface p-8 shadow-sd-md">
        <div class="flex items-center gap-3 font-extrabold text-sd-primary-dark">
            <img src="/images/logo.svg" alt="Selaras Diri" class="h-12 w-auto">
            <span>Selaras Diri CMS</span>
        </div>

        <div>
            <p class="eyebrow">Dua Faktor Autentikasi (2FA)</p>
            <h1 class="m-0 font-serif text-4xl leading-tight">Masukkan kode verifikasi dari Google Authenticator Anda.</h1>
        </div>

        @if ($errors->any())
            <p class="m-0 rounded-lg border border-sd-danger/20 bg-[#fff5f3] p-4 font-bold text-sd-danger">{{ $errors->first() }}</p>
        @endif

        <form action="{{ route('admin.login.2fa.verify') }}" method="POST" class="grid gap-4">
            @csrf
            <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft">
                <span>Kode OTP 6-Digit</span>
                <input class="min-h-12 w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-mono text-center text-2xl font-bold tracking-widest text-sd-ink" 
                       type="text" 
                       name="code" 
                       inputmode="numeric" 
                       pattern="[0-9]*" 
                       maxlength="6" 
                       placeholder="123456" 
                       required 
                       autofocus 
                       autocomplete="one-time-code">
            </label>
            <button class="btn btn-primary" type="submit">Verifikasi & Masuk</button>
        </form>
        
        <form action="{{ route('admin.logout') }}" method="POST" class="text-center">
            @csrf
            <button type="submit" class="text-sm font-extrabold text-sd-rose hover:underline bg-transparent border-0 cursor-pointer">Batal dan Keluar</button>
        </form>
    </div>
</body>
</html>
