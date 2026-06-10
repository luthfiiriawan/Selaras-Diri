@extends('layouts.public')

@section('content')
    {{-- Hero --}}
    <section class="hero-overlay relative mx-auto mt-6 grid min-h-[530px] w-[min(1480px,calc(100%-48px))] items-end gap-8 overflow-hidden rounded-lg bg-[#2a1b1a] p-10 shadow-sd-md lg:grid-cols-[minmax(0,1.02fr)_minmax(360px,0.98fr)]" id="home">
        <div class="absolute inset-0">
            <img class="h-full w-full object-cover animate-hero-kenburns" src="https://images.unsplash.com/photo-1499209974431-9dddcece7f88?auto=format&fit=crop&w=1800&q=88" alt="Ruang konseling yang tenang dengan cahaya natural">
        </div>
        <div class="relative z-[2] max-w-[710px] text-sd-surface animate-hero-rise">
            <p class="eyebrow">{{ $settings['hero_eyebrow'] }}</p>
            <h1 class="mb-6 text-[4.2rem] leading-[1.02]">{{ $settings['hero_title'] }}</h1>
            <p class="max-w-[650px] text-[1.16rem] leading-[1.76] text-sd-surface/85">{{ $settings['hero_subtitle'] }}</p>
            <div class="mt-7 flex flex-wrap items-center gap-3">
                <a class="btn btn-primary" href="{{ $bookingUrl }}" target="_blank" rel="noopener">Booked Konseling</a>
                <a class="btn btn-soft" href="{{ route('services') }}">Lihat Layanan</a>
            </div>
        </div>
        <aside class="relative z-[2] max-w-[420px] self-end justify-self-end rounded-lg border border-white/60 bg-sd-surface/90 p-7 text-sd-ink animate-hero-rise [animation-delay:180ms]" aria-label="Ringkasan pendek">
            <span class="block text-xs font-extrabold uppercase text-sd-rose">Online dan offline</span>
            <strong class="mt-2.5 block text-[1.38rem] leading-tight">Konseling, support group, dan sesi wellness dalam satu ekosistem.</strong>
        </aside>
    </section>

    {{-- Value marquee --}}
    <section class="mt-5 w-full overflow-hidden border-y border-sd-ink/10 bg-sd-surface py-3.5 text-sd-primary" aria-label="Fokus Selaras Diri">
        <div class="marquee-track flex w-max gap-3.5 animate-marquee">
            @foreach (['Mindfulness','Self-Awareness','Art Therapy','Sharing Circle','Peer Counselor','Support Group','Mindfulness','Self-Awareness','Art Therapy','Sharing Circle','Peer Counselor','Support Group'] as $tag)
                <span class="inline-flex min-h-10 items-center whitespace-nowrap rounded-full border border-sd-ink/10 px-5 font-extrabold">{{ $tag }}</span>
            @endforeach
        </div>
    </section>

    {{-- Intro strip --}}
    <section class="mx-auto grid w-[min(1160px,calc(100%-48px))] gap-px pb-20 pt-12 reveal-group md:grid-cols-3" aria-label="Ringkasan layanan">
        @php
            $intro = [
                ['01', 'Konseling personal', 'Sesi terarah bersama psikolog untuk kebutuhan personal, relasi, keluarga, dan tumbuh kembang.', 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
                ['02', 'Support group', 'Ruang berbagi bulanan yang difasilitasi agar peserta merasa aman, didengar, dan tidak sendirian.', 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6 5.87a4 4 0 100-8 4 4 0 000 8zm6-9a3 3 0 11-6 0 3 3 0 016 0z'],
                ['03', 'Wellness event', 'Trekking, art therapy, workshop, webinar, barre, yoga, dan padel session untuk merawat tubuh-pikiran.', 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z'],
            ];
        @endphp
        @foreach ($intro as $i => [$num, $title, $desc, $icon])
            <div class="reveal min-h-48 border border-sd-ink/10 bg-sd-surface p-7 {{ $i === 0 ? 'rounded-l-lg' : '' }} {{ $i === 2 ? 'rounded-r-lg' : '' }} max-md:rounded-lg">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-sd-soft text-sd-primary">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/></svg>
                </div>
                <span class="block text-xs font-extrabold uppercase text-sd-rose">{{ $num }}</span>
                <strong class="my-2.5 block text-lg">{{ $title }}</strong>
                <p class="text-sd-muted leading-[1.72]">{{ $desc }}</p>
            </div>
        @endforeach
    </section>

    {{-- Stats strip --}}
    <section class="bg-gradient-to-br from-sd-soft to-sd-paper" aria-label="Selaras Diri dalam angka">
        <div class="mx-auto grid w-[min(1160px,calc(100%-48px))] gap-8 py-12 reveal-group sm:grid-cols-2 lg:grid-cols-4">
            @php
                $stats = [
                    [$psychologists->count(), 'Psikolog klinis & anak-remaja'],
                    [$packages->count(), 'Pilihan layanan & paket'],
                    [$monthlyEvents->count() + 1, 'Agenda rutin tiap bulan'],
                    ['3', 'Format sesi konseling'],
                ];
            @endphp
            @foreach ($stats as [$num, $label])
                <div class="reveal text-center">
                    <div class="font-serif text-5xl leading-none text-sd-primary">{{ $num }}</div>
                    <p class="mt-2.5 text-sm font-bold text-sd-ink-soft">{{ $label }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Program Utama --}}
    <section class="mx-auto w-[min(1160px,calc(100%-48px))] py-20 reveal">
        <div class="mb-8">
            <p class="eyebrow">Program Utama</p>
            <h2 class="text-5xl leading-[1.08]">Empat program inti yang menemani perjalananmu.</h2>
        </div>
        @php
            $programs = [
                ['Workshop Mindfulness & Self-Awareness', 'Pelatihan berbasis pengalaman langsung (experiential learning) untuk melatih kehadiran penuh, pengenalan emosi, dan teknik pengelolaan stres.', 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'],
                ['Art Therapy', 'Ruang ekspresif yang memanfaatkan seni benang, musik, atau gerak sebagai media untuk mengekspresikan perasaan, melepaskan tekanan batin, dan memperkuat koneksi dengan diri.', 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01'],
                ['Pelatihan Peer Konselor', 'Program pengembangan kapasitas untuk individu yang ingin menjadi pendengar aktif, pemberi dukungan, dan fasilitator kelompok sebaya yang sadar dan empatik.', 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                ['Ruang Refleksi & Sharing Circle', 'Sesi komunitas yang terbuka untuk berbagi cerita, belajar dari pengalaman orang lain, dan memperkuat ikatan emosional di antara peserta.', 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6 5.87a4 4 0 100-8 4 4 0 000 8zm6-9a3 3 0 11-6 0 3 3 0 016 0z'],
            ];
        @endphp
        <div class="grid gap-4 reveal-group md:grid-cols-2">
            @foreach ($programs as [$title, $desc, $icon])
                <article class="reveal flex gap-5 rounded-lg border border-sd-ink/10 bg-sd-surface p-7 shadow-sd-sm transition duration-200 hover:-translate-y-1 hover:shadow-sd-md">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-sd-soft text-sd-primary">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/></svg>
                    </div>
                    <div>
                        <h3 class="mb-2 text-xl leading-tight">{{ $title }}</h3>
                        <p class="text-sd-muted leading-[1.72]">{{ $desc }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    {{-- Psikolog preview --}}
    @php $featuredPsy = $psychologists->filter(fn ($p) => data_get($p, 'image_url'))->take(4); @endphp
    @if ($featuredPsy->count())
        <section class="border-y border-sd-ink/10 bg-sd-surface">
            <div class="mx-auto w-[min(1160px,calc(100%-48px))] py-20 reveal">
                <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <p class="eyebrow">Tim Kami</p>
                        <h2 class="text-5xl leading-[1.08]">Psikolog yang siap mendampingi.</h2>
                    </div>
                    <a class="btn btn-soft" href="{{ route('psychologists') }}">Lihat semua psikolog</a>
                </div>
                <div class="grid gap-4 reveal-group sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($featuredPsy as $psychologist)
                        <article class="reveal overflow-hidden rounded-lg border border-sd-ink/10 bg-sd-paper transition duration-200 hover:-translate-y-1 hover:shadow-sd-md">
                            <img class="aspect-[4/5] w-full object-cover" src="{{ data_get($psychologist, 'image_url') }}" alt="{{ data_get($psychologist, 'name') }}" loading="lazy">
                            <div class="p-4">
                                <span class="block text-xs font-extrabold uppercase text-sd-rose">{{ data_get($psychologist, 'role') }}</span>
                                <h3 class="mt-1.5 text-base leading-tight">{{ data_get($psychologist, 'name') }}</h3>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Page directory --}}
    <section class="mx-auto w-[min(1160px,calc(100%-48px))] py-20 reveal">
        <div class="mb-8">
            <p class="eyebrow">Jelajahi Selaras Diri</p>
            <h2 class="text-5xl leading-[1.08]">Setiap halaman punya informasi yang lebih fokus.</h2>
        </div>
        <div class="grid gap-4 reveal-group md:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                ['Tentang', 'Tentang Selaras Diri', 'Profil komunitas, visi, misi, dan dasar pendekatan Selaras Diri.', 'about'],
                ['Layanan', 'Konseling dan pricelist', 'Daftar sesi offline, online, couple, bundling, dan assessment.', 'services'],
                ['Psikolog', 'Profil psikolog', 'Tim psikolog klinis dan anak-remaja beserta fokus pendampingannya.', 'psychologists'],
                ['Event', 'Support group dan event bulanan', 'Agenda support group, trekking, art therapy, workshop, webinar, dan sesi wellness.', 'events'],
            ] as [$eyebrow, $heading, $body, $route])
                <a class="reveal flex min-h-60 flex-col rounded-lg border border-sd-ink/10 bg-sd-surface p-6 shadow-sd-sm transition duration-200 hover:-translate-y-1 hover:border-sd-primary/20 hover:shadow-sd-md" href="{{ route($route) }}">
                    <span class="block text-xs font-extrabold uppercase text-sd-rose">{{ $eyebrow }}</span>
                    <h3 class="mt-4 mb-3 text-xl leading-tight">{{ $heading }}</h3>
                    <p class="text-sd-muted leading-[1.72]">{{ $body }}</p>
                    <span class="mt-auto inline-flex items-center gap-1 pt-4 font-extrabold text-sd-primary">Buka halaman &rarr;</span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Closing CTA --}}
@endsection
