<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $pageBody ?? $settings['hero_subtitle'] }}">

    <title>{{ ($pageTitle ?? 'Ruang Bertumbuh dan Pulih') . ' | ' . $settings['site_name'] }}</title>
    <link rel="icon" type="image/png" href="/images/brand/selaras-diri-logo.png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="public-site">
    <a class="skip-link" href="#main">Lewati ke konten utama</a>

    <header class="site-header" aria-label="Navigasi utama">
        <a class="brand" href="{{ route('home') }}" aria-label="{{ $settings['site_name'] }}">
            <img class="brand-logo" src="/images/brand/selaras-diri-logo-cropped.png" alt="" aria-hidden="true">
        </a>

        <nav class="nav-links">
            <a @class(['is-active' => ($activeNav ?? '') === 'about']) href="{{ route('about') }}">Tentang</a>
            <a @class(['is-active' => ($activeNav ?? '') === 'services']) href="{{ route('services') }}">Layanan</a>
            <a @class(['is-active' => ($activeNav ?? '') === 'psychologists']) href="{{ route('psychologists') }}">Psikolog</a>
            <a @class(['is-active' => ($activeNav ?? '') === 'events']) href="{{ route('events') }}">Event</a>
        </nav>

        <a class="header-cta" href="{{ $bookingUrl }}" target="_blank" rel="noopener">Booked Konseling</a>
    </header>

    <main id="main">
        @yield('content')
    </main>

    @php
        $phoneDisplay = $settings['contact_phone'] ?? '+6282115724455';
        $phoneDigits = preg_replace('/\D+/', '', $phoneDisplay);
        $phoneHref = str_starts_with(trim($phoneDisplay), '+') ? '+' . $phoneDigits : $phoneDigits;
        $email = $settings['email'] ?? 'selarasdiri99@gmail.com';
        $instagram = $settings['instagram'] ?? '@SELARAS_DIRI';
        $instagramHandle = ltrim(trim($instagram), '@');
    @endphp

    <footer class="footer">
        <div class="footer-brand">
            <a class="footer-logo" href="{{ route('home') }}" aria-label="{{ $settings['site_name'] }}">
                <img src="/images/brand/selaras-diri-logo-cropped.png" alt="" aria-hidden="true">
            </a>
            <p>{{ $settings['footer_tagline'] }}</p>
            <a class="button button-primary footer-cta" href="{{ $bookingUrl }}" target="_blank" rel="noopener">Chat WhatsApp</a>
        </div>

        <nav class="footer-nav" aria-label="Navigasi footer">
            <p class="eyebrow">Menu</p>
            <a href="{{ route('about') }}">Tentang</a>
            <a href="{{ route('services') }}">Layanan</a>
            <a href="{{ route('psychologists') }}">Psikolog</a>
            <a href="{{ route('events') }}">Event</a>
        </nav>

        <div class="footer-contact">
            <p class="eyebrow">Kontak</p>
            <dl>
                <div>
                    <dt>Telpon</dt>
                    <dd><a href="tel:{{ $phoneHref }}">{{ $phoneDisplay }}</a></dd>
                </div>
                <div>
                    <dt>Email</dt>
                    <dd><a href="mailto:{{ $email }}">{{ $email }}</a></dd>
                </div>
                <div>
                    <dt>Instagram</dt>
                    <dd>
                        @if ($instagramHandle !== '')
                            <a href="https://www.instagram.com/{{ $instagramHandle }}" target="_blank" rel="noopener">{{ $instagram }}</a>
                        @else
                            {{ $instagram }}
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} {{ $settings['site_name'] }}.</span>
            <a href="{{ route('admin.login') }}">CMS</a>
        </div>
    </footer>
</body>
</html>
