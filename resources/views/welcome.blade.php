<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $settings['hero_subtitle'] }}">

    <title>{{ $settings['site_name'] }} | Ruang Bertumbuh dan Pulih</title>
    <link rel="icon" type="image/svg+xml" href="/images/logo.svg">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="public-site">
    <a class="skip-link" href="#main">Lewati ke konten utama</a>

    <header class="site-header" aria-label="Navigasi utama">
        <a class="brand" href="#home" aria-label="{{ $settings['site_name'] }}">
            <img src="/images/logo.svg" alt="{{ $settings['site_name'] }}" class="h-10 w-auto">
        </a>

        <nav class="nav-links">
            <a href="#tentang">Tentang</a>
            <a href="#layanan">Layanan</a>
            <a href="#psikolog">Psikolog</a>
            <a href="#event">Event</a>
        </nav>

        <a class="header-cta" href="{{ $bookingUrl }}" target="_blank" rel="noopener">Booked Konseling</a>
    </header>

    <main id="main">

        {{-- Hero --}}
        <section class="hero" id="home">
            <div class="hero-media">
                <img src="https://images.unsplash.com/photo-1499209974431-9dddcece7f88?auto=format&fit=crop&w=1800&q=88" alt="Ruang konseling yang tenang dengan cahaya natural">
            </div>
            <div class="hero-copy reveal-now">
                <p class="eyebrow">{{ $settings['hero_eyebrow'] }}</p>
                <h1>{{ $settings['hero_title'] }}</h1>
                <p>{{ $settings['hero_subtitle'] }}</p>
                <div class="hero-actions">
                    <a class="button button-primary" href="{{ $bookingUrl }}" target="_blank" rel="noopener">Booked Konseling</a>
                    <a class="button button-soft" href="#layanan">Lihat Layanan</a>
                </div>
            </div>
            <aside class="hero-note reveal-now" aria-label="Ringkasan pendek">
                <span>Online dan offline</span>
                <strong>Konseling, support group, dan sesi wellness dalam satu ekosistem.</strong>
            </aside>
        </section>

        {{-- Value marquee --}}
        <section class="value-marquee" aria-label="Fokus Selaras Diri">
            <div>
                <span>Mindfulness</span>
                <span>Self-Awareness</span>
                <span>Art Therapy</span>
                <span>Sharing Circle</span>
                <span>Peer Counselor</span>
                <span>Support Group</span>
                <span>Mindfulness</span>
                <span>Self-Awareness</span>
                <span>Art Therapy</span>
                <span>Sharing Circle</span>
                <span>Peer Counselor</span>
                <span>Support Group</span>
            </div>
        </section>

        {{-- Intro strip --}}
        <section class="section intro-strip reveal-group" aria-label="Ringkasan layanan">
            <div class="reveal">
                <span>01</span>
                <strong>Konseling personal</strong>
                <p>Sesi terarah bersama psikolog untuk kebutuhan personal, relasi, keluarga, dan tumbuh kembang.</p>
            </div>
            <div class="reveal">
                <span>02</span>
                <strong>Support group</strong>
                <p>Ruang berbagi bulanan yang difasilitasi agar peserta merasa aman, didengar, dan tidak sendirian.</p>
            </div>
            <div class="reveal">
                <span>03</span>
                <strong>Wellness event</strong>
                <p>Trekking, art therapy, workshop, webinar, barre, yoga, dan padel session untuk merawat tubuh-pikiran.</p>
            </div>
        </section>

        {{-- Tentang --}}
        <section class="section split-section reveal" id="tentang">
            <div class="section-label">
                <p class="eyebrow">{{ $settings['about_title'] }}</p>
            </div>
            <div class="section-story">
                <h2>{{ $settings['about_heading'] }}</h2>
                <p>{{ $settings['about_body'] }}</p>

                <div class="about-highlights reveal">
                    <div class="about-stat">
                        <strong>6</strong>
                        <span>Psikolog Klinis</span>
                        <p>Siap mendampingi kamu secara personal</p>
                    </div>
                    <div class="about-stat">
                        <strong>3</strong>
                        <span>Format Sesi</span>
                        <p>Offline, Online Video Call, dan Voice Call</p>
                    </div>
                    <div class="about-stat">
                        <strong>2</strong>
                        <span>Lokasi Praktik</span>
                        <p>Jabarano Laswi (Bandung) dan Cimahi</p>
                    </div>
                    <div class="about-stat">
                        <strong>5+</strong>
                        <span>Jenis Event</span>
                        <p>Trekking, Art Therapy, Yoga, Webinar, Support Group</p>
                    </div>
                    <div class="about-quote">
                        <blockquote>"Hidup yang seimbang dan bermakna berawal dari kemampuan hadir sepenuhnya pada momen kini."</blockquote>
                    </div>
                </div>
            </div>
        </section>

        {{-- Manifesto --}}
        <section class="section manifesto reveal-group">
            <article class="reveal">
                <p class="eyebrow">{{ $settings['vision_title'] }}</p>
                <h2>{{ $settings['vision_body'] }}</h2>
            </article>
            <article class="reveal">
                <p class="eyebrow">{{ $settings['mission_title'] }}</p>
                <p>{{ $settings['mission_body'] }}</p>
            </article>
        </section>

        {{-- Layanan / Pricelist --}}
        <section class="section services reveal" id="layanan">
            <div class="section-heading">
                <p class="eyebrow">Layanan dan Pricelist</p>
                <h2>Pilih bentuk pendampingan yang paling sesuai untuk langkah pertama.</h2>
            </div>

            <div class="package-grid reveal-group">
                @foreach ($packages as $package)
                    <article class="package-card reveal">
                        <span>{{ data_get($package, 'duration') ?: 'Sesi' }}</span>
                        <h3>{{ data_get($package, 'title') }}</h3>
                        <p>{{ data_get($package, 'description') }}</p>
                        <strong>{{ data_get($package, 'price') }}</strong>
                        <a class="pkg-btn" href="{{ $bookingUrl }}" target="_blank" rel="noopener">Pilih Paket →</a>
                    </article>
                @endforeach
            </div>
        </section>

        {{-- Psikolog --}}
        <section class="section reveal" id="psikolog">
            <div class="section-heading">
                <p class="eyebrow">Psikolog</p>
                <h2>Tim pendamping untuk kebutuhan emosi, relasi, dan keluarga.</h2>
            </div>

            <div class="relative" data-carousel-root>
                <div data-carousel-track class="psy-scroll -mx-6 flex snap-x snap-mandatory gap-5 overflow-x-auto px-6 pb-6 pt-2 lg:mx-0 lg:px-0" style="scroll-behavior: smooth;">
                    @foreach ($psychologists as $psychologist)
                        <article class="psy-card reveal w-[min(82vw,300px)] shrink-0 snap-start">
                            {{-- Circular photo --}}
                            <div class="psy-card-photo-wrap">
                                <div class="psy-card-circle">
                                    @if (data_get($psychologist, 'image_url'))
                                        <img src="{{ data_get($psychologist, 'image_url') }}"
                                             alt="{{ data_get($psychologist, 'name') }}"
                                             loading="lazy">
                                    @else
                                        <span>{{ data_get($psychologist, 'initials') ?: 'SD' }}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Info --}}
                            <div class="psy-card-body">
                                <p class="psy-card-role">{{ data_get($psychologist, 'role') }}</p>
                                <h3 class="psy-card-name">{{ data_get($psychologist, 'name') }}</h3>

                                @if (data_get($psychologist, 'specialization'))
                                    <p class="psy-card-section-label">Spesialisasi</p>
                                    <p class="psy-card-spec">{{ implode(', ', array_slice(array_map('trim', explode(',', data_get($psychologist, 'specialization'))), 0, 5)) }}</p>
                                @endif

                                @if (data_get($psychologist, 'expertise'))
                                    <p class="psy-card-section-label">Keahlian</p>
                                    <p class="psy-card-spec">{{ data_get($psychologist, 'expertise') }}</p>
                                @endif

                                <div class="psy-card-footer">
                                    <div>
                                        <p class="psy-card-section-label">Lokasi</p>
                                        <p class="psy-card-location">{{ data_get($psychologist, 'schedule') }}</p>
                                    </div>
                                    <p class="psy-card-price">{{ data_get($psychologist, 'price') }}</p>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <button type="button" data-carousel-prev aria-label="Sebelumnya" class="absolute left-2 top-[42%] z-10 hidden h-11 w-11 -translate-y-1/2 cursor-pointer items-center justify-center rounded-full border border-sd-ink/10 bg-white/95 text-lg font-bold text-sd-primary shadow-sd-sm backdrop-blur transition hover:bg-sd-primary hover:text-white disabled:cursor-not-allowed disabled:opacity-30 md:inline-flex lg:-left-5">‹</button>
                <button type="button" data-carousel-next aria-label="Selanjutnya" class="absolute right-2 top-[42%] z-10 hidden h-11 w-11 -translate-y-1/2 cursor-pointer items-center justify-center rounded-full border border-sd-ink/10 bg-white/95 text-lg font-bold text-sd-primary shadow-sd-sm backdrop-blur transition hover:bg-sd-primary hover:text-white disabled:cursor-not-allowed disabled:opacity-30 md:inline-flex lg:-right-5">›</button>
            </div>

            <p class="mt-4 text-center text-xs font-bold uppercase tracking-wide text-sd-muted md:hidden">Geser untuk melihat semua psikolog →</p>
        </section>

        {{-- Booking --}}
        <section class="section booking-panel reveal" id="booking">
            <div>
                <p class="eyebrow">Booked Konseling</p>
                <h2>{{ $settings['booking_title'] }}</h2>
                <p>{{ $settings['booking_body'] }}</p>
            </div>
            <a class="button button-primary" href="{{ $bookingUrl }}" target="_blank" rel="noopener">Chat Admin WhatsApp</a>
        </section>

        {{-- Support Group --}}
        <section class="section support-section reveal-group">
            <div class="support-image reveal">
                <img src="{{ data_get($supportEvent, 'image_url') }}" alt="{{ data_get($supportEvent, 'title') }}" loading="lazy">
            </div>
            <div class="support-copy reveal">
                <p class="eyebrow">Event Rutin</p>
                <h2>{{ data_get($supportEvent, 'title') }}</h2>
                <p>{{ data_get($supportEvent, 'description') }}</p>
                <div class="support-schedule">
                    <span>Jadwal</span>
                    <strong>{{ data_get($supportEvent, 'schedule') }}</strong>
                </div>
                <a class="button button-soft" href="{{ $eventUrl }}" target="_blank" rel="noopener">Booked Support Group</a>
            </div>
        </section>

        {{-- Event Bulanan --}}
        <section class="section events-section reveal" id="event">
            <div class="section-heading">
                <p class="eyebrow">Event Bulanan</p>
                <h2>Aktivitas yang mempertemukan refleksi, tubuh, seni, dan komunitas.</h2>
            </div>

            <div class="event-grid reveal-group">
                @foreach ($monthlyEvents as $event)
                    <article class="event-card reveal">
                        <div class="event-card-img">
                            <img src="{{ data_get($event, 'image_url') }}" alt="{{ data_get($event, 'title') }}" loading="lazy">
                        </div>
                        <div>
                            <span>{{ data_get($event, 'schedule') }}</span>
                            <h3>{{ data_get($event, 'title') }}</h3>
                            <p>{{ data_get($event, 'description') }}</p>
                            <a href="{{ $eventUrl }}" target="_blank" rel="noopener">Daftar via WhatsApp →</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

    </main>

    <footer class="footer">
        <div>
            <strong>{{ $settings['site_name'] }}</strong>
            <p>{{ $settings['footer_tagline'] }}</p>
            <p>{{ $settings['instagram'] ?? '@selaras_diri' }} &middot; {{ $settings['contact_phone'] ?? '+6282115724455' }} &middot; {{ $settings['email'] ?? 'selarasdiri99@gmail.com' }} &middot; {{ $settings['location'] ?? 'Jabarano Laswi dan Cimahi' }}</p>
        </div>
        <div class="footer-actions">
            <a href="{{ $bookingUrl }}" target="_blank" rel="noopener">WhatsApp</a>
        </div>
    </footer>
</body>
</html>
