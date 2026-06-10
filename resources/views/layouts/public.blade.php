<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $pageBody ?? $settings['hero_subtitle'] }}">
    <title>{{ ($pageTitle ?? 'Ruang Bertumbuh dan Pulih') . ' | ' . $settings['site_name'] }}</title>
    <link rel="icon" type="image/svg+xml" href="/images/logo.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sd-paper text-sd-ink">
    <a class="skip-link" href="#main">Lewati ke konten utama</a>

    <header class="sticky top-0 z-20 flex min-h-20 flex-wrap items-center justify-between gap-6 border-b border-sd-ink/10 bg-sd-paper/90 px-6 py-4 backdrop-blur-xl lg:px-[max(24px,calc((100vw-1160px)/2))]" aria-label="Navigasi utama">
        <a class="flex min-w-0 items-center gap-3 font-extrabold text-sd-primary-dark" href="{{ route('home') }}" aria-label="{{ $settings['site_name'] }}">
            <img src="/images/logo.svg" alt="{{ $settings['site_name'] }}" class="h-12 w-auto">
        </a>

        <nav class="order-3 flex w-full items-center gap-7 overflow-x-auto pb-1 text-[0.96rem] font-bold text-sd-ink-soft lg:order-none lg:w-auto lg:overflow-visible lg:pb-0">
            <a @class(['inline-flex min-h-11 items-center whitespace-nowrap rounded-full px-3 transition-colors hover:text-sd-rose', 'bg-sd-soft text-sd-primary' => ($activeNav ?? '') === 'about']) href="{{ route('about') }}">Tentang</a>
            <a @class(['inline-flex min-h-11 items-center whitespace-nowrap rounded-full px-3 transition-colors hover:text-sd-rose', 'bg-sd-soft text-sd-primary' => ($activeNav ?? '') === 'services']) href="{{ route('services') }}">Layanan</a>
            <a @class(['inline-flex min-h-11 items-center whitespace-nowrap rounded-full px-3 transition-colors hover:text-sd-rose', 'bg-sd-soft text-sd-primary' => ($activeNav ?? '') === 'psychologists']) href="{{ route('psychologists') }}">Psikolog</a>
            <a @class(['inline-flex min-h-11 items-center whitespace-nowrap rounded-full px-3 transition-colors hover:text-sd-rose', 'bg-sd-soft text-sd-primary' => ($activeNav ?? '') === 'events']) href="{{ route('events') }}">Event</a>
        </nav>

        <a class="btn btn-soft" href="{{ $bookingUrl }}" target="_blank" rel="noopener">Booked Konseling</a>
    </header>

    <main id="main">
        @yield('content')
    </main>

    @php
        $email        = $settings['email'] ?? 'selarasdiri99@gmail.com';
        $instagram    = $settings['instagram'] ?? '@SELARAS_DIRI';
        $instagramHandle = ltrim(trim($instagram), '@');
    @endphp

    <footer class="mx-auto w-[min(1160px,calc(100%-48px))] border-t border-sd-ink/10 py-12">
        <div class="grid gap-10 lg:grid-cols-[minmax(260px,0.9fr)_minmax(0,2fr)]">
            <div class="max-w-[430px]">
                <a class="inline-flex w-fit" href="{{ route('home') }}" aria-label="{{ $settings['site_name'] }}">
                    <img src="/images/logo.svg" alt="{{ $settings['site_name'] }}" class="h-14 w-auto">
                </a>
                <p class="mt-6 max-w-[360px] font-serif text-[1.1rem] italic leading-[1.7] text-sd-ink-soft">“{{ $settings['footer_tagline'] }}”</p>
            </div>

            <div class="grid gap-8 md:grid-cols-3">
                <nav class="grid content-start gap-3" aria-label="Footer layanan">
                    <h2 class="mb-1 text-sm font-extrabold text-sd-ink">Layanan</h2>
                    <a class="inline-flex min-h-9 items-center text-sd-ink-soft transition-colors hover:text-sd-rose" href="{{ route('services') }}">Konseling Individu</a>
                    <a class="inline-flex min-h-9 items-center text-sd-ink-soft transition-colors hover:text-sd-rose" href="{{ route('services') }}">Konseling Couple</a>
                    <a class="inline-flex min-h-9 items-center text-sd-ink-soft transition-colors hover:text-sd-rose" href="{{ route('services') }}">Assessment Psikologi</a>
                    <a class="inline-flex min-h-9 items-center text-sd-ink-soft transition-colors hover:text-sd-rose" href="{{ route('events') }}">Support Group</a>
                </nav>

                <nav class="grid content-start gap-3" aria-label="Footer tentang kami">
                    <h2 class="mb-1 text-sm font-extrabold text-sd-ink">Tentang Kami</h2>
                    <a class="inline-flex min-h-9 items-center text-sd-ink-soft transition-colors hover:text-sd-rose" href="{{ route('about') }}">Tentang Selaras Diri</a>
                    <a class="inline-flex min-h-9 items-center text-sd-ink-soft transition-colors hover:text-sd-rose" href="{{ route('about') }}">Visi Misi</a>
                    <a class="inline-flex min-h-9 items-center text-sd-ink-soft transition-colors hover:text-sd-rose" href="{{ route('psychologists') }}">Psikolog</a>
                    <a class="inline-flex min-h-9 items-center text-sd-ink-soft transition-colors hover:text-sd-rose" href="{{ route('events') }}">Event</a>
                </nav>

                <nav class="grid content-start gap-3" aria-label="Footer aktivitas">
                    <h2 class="mb-1 text-sm font-extrabold text-sd-ink">Aktivitas</h2>
                    <a class="inline-flex min-h-9 items-center text-sd-ink-soft transition-colors hover:text-sd-rose" href="{{ route('events') }}">Art Therapy</a>
                    <a class="inline-flex min-h-9 items-center text-sd-ink-soft transition-colors hover:text-sd-rose" href="{{ route('events') }}">Workshop Bulanan</a>
                    <a class="inline-flex min-h-9 items-center text-sd-ink-soft transition-colors hover:text-sd-rose" href="{{ route('events') }}">Seminar & Webinar</a>
                    <a class="inline-flex min-h-9 items-center text-sd-ink-soft transition-colors hover:text-sd-rose" href="{{ route('events') }}">Trekking</a>
                    <a class="inline-flex min-h-9 items-center text-sd-ink-soft transition-colors hover:text-sd-rose" href="{{ route('events') }}">Barre, Yoga & Padel</a>
                </nav>

            </div>
        </div>

        <div class="mt-10 flex flex-wrap items-center justify-between gap-5 border-t border-sd-ink/10 pt-6">
            <div class="flex flex-wrap items-center gap-x-3 gap-y-2 text-sm font-semibold text-sd-muted">
                <span>Mindfulness</span>
                <span aria-hidden="true">·</span>
                <span>Konseling</span>
                <span aria-hidden="true">·</span>
                <span>Komunitas</span>
            </div>

            <div class="flex items-center gap-2.5" aria-label="Kontak Selaras Diri">
                <a class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-sd-soft text-sd-primary transition-colors hover:bg-sd-primary hover:text-sd-surface" href="{{ $bookingUrl }}" target="_blank" rel="noopener" aria-label="Hubungi Selaras Diri via WhatsApp">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                </a>

                <a class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-sd-soft text-sd-primary transition-colors hover:bg-sd-primary hover:text-sd-surface" href="mailto:{{ $email }}" aria-label="Email Selaras Diri">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </a>

                @if ($instagramHandle !== '')
                    <a class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-sd-soft text-sd-primary transition-colors hover:bg-sd-primary hover:text-sd-surface" href="https://www.instagram.com/{{ $instagramHandle }}" target="_blank" rel="noopener" aria-label="Instagram Selaras Diri">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                @endif
            </div>
        </div>
    </footer>
</body>
</html>
