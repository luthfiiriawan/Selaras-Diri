<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $settings['hero_subtitle'] }}">

    <title>{{ $settings['site_name'] }} | Ruang Bertumbuh dan Pulih</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="public-site">
    <a class="skip-link" href="#main">Lewati ke konten utama</a>

    <header class="site-header" aria-label="Navigasi utama">
        <a class="brand" href="#home" aria-label="{{ $settings['site_name'] }}">
            <span class="brand-mark">SD</span>
            <span>{{ $settings['site_name'] }}</span>
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

        <section class="section split-section reveal" id="tentang">
            <div class="section-label">
                <p class="eyebrow">{{ $settings['about_title'] }}</p>
            </div>
            <div class="section-story">
                <h2>{{ $settings['about_heading'] }}</h2>
                <p>{{ $settings['about_body'] }}</p>
                <figure class="company-showcase reveal">
                    <img src="/images/canva/company/company-profile-02.png" alt="Company profile Selaras Diri - Tentang Selaras Diri" loading="lazy">
                    <figcaption>Diambil dari company profile Selaras Diri.</figcaption>
                </figure>
            </div>
        </section>

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
                    </article>
                @endforeach
            </div>

            <div class="price-gallery-shell reveal-group" aria-label="Pricelist psikolog Selaras Diri dari Canva">
                <div class="price-gallery-copy reveal">
                    <p class="eyebrow">Pricelist Visual</p>
                    <h3>Rincian per psikolog dari materi Canva.</h3>
                    <p>Gambar ini dipakai sebagai sumber visual agar nama psikolog, format sesi, dan biaya layanan tetap selaras dengan materi resmi Selaras Diri.</p>
                </div>

                <div class="pricing-gallery">
                    @foreach ($psychologists as $psychologist)
                        @if (data_get($psychologist, 'image_url'))
                            <figure class="pricing-preview reveal">
                                <img src="{{ data_get($psychologist, 'image_url') }}" alt="Pricelist Canva {{ data_get($psychologist, 'name') }}" loading="lazy">
                                <figcaption>{{ data_get($psychologist, 'name') }}</figcaption>
                            </figure>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section psychologist-section reveal" id="psikolog">
            <div class="section-heading">
                <p class="eyebrow">Psikolog</p>
                <h2>Tim pendamping untuk kebutuhan emosi, relasi, dan keluarga.</h2>
            </div>

            <div class="psychologist-grid reveal-group">
                @foreach ($psychologists as $psychologist)
                    <article class="profile-card reveal">
                        @if (data_get($psychologist, 'image_url'))
                            <img src="{{ data_get($psychologist, 'image_url') }}" alt="{{ data_get($psychologist, 'name') }}" loading="lazy">
                        @else
                            <div class="profile-initial">{{ data_get($psychologist, 'initials') ?: 'SD' }}</div>
                        @endif
                        <div>
                            <span>{{ data_get($psychologist, 'role') }}</span>
                            <h3>{{ data_get($psychologist, 'name') }}</h3>
                            <p>{{ data_get($psychologist, 'focus') }}</p>
                            <dl>
                                <div>
                                    <dt>Jadwal</dt>
                                    <dd>{{ data_get($psychologist, 'schedule') }}</dd>
                                </div>
                                <div>
                                    <dt>Biaya</dt>
                                    <dd>{{ data_get($psychologist, 'price') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="section booking-panel reveal" id="booking">
            <div>
                <p class="eyebrow">Booked Konseling</p>
                <h2>{{ $settings['booking_title'] }}</h2>
                <p>{{ $settings['booking_body'] }}</p>
            </div>
            <a class="button button-primary" href="{{ $bookingUrl }}" target="_blank" rel="noopener">Chat Admin WhatsApp</a>
        </section>

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

        <section class="section events-section reveal" id="event">
            <div class="section-heading">
                <p class="eyebrow">Event Bulanan</p>
                <h2>Aktivitas yang mempertemukan refleksi, tubuh, seni, dan komunitas.</h2>
            </div>

            <div class="event-grid reveal-group">
                @foreach ($monthlyEvents as $event)
                    <article class="event-card reveal">
                        <img src="{{ data_get($event, 'image_url') }}" alt="{{ data_get($event, 'title') }}" loading="lazy">
                        <div>
                            <span>{{ data_get($event, 'schedule') }}</span>
                            <h3>{{ data_get($event, 'title') }}</h3>
                            <p>{{ data_get($event, 'description') }}</p>
                            <a href="{{ $eventUrl }}" target="_blank" rel="noopener">Daftar via WhatsApp</a>
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
            <a href="{{ route('admin.login') }}">CMS</a>
            <a href="{{ $bookingUrl }}" target="_blank" rel="noopener">WhatsApp</a>
        </div>
    </footer>
</body>
</html>
