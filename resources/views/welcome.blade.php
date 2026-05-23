@extends('layouts.public')

@section('content')
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
                <a class="button button-soft" href="{{ route('services') }}">Lihat Layanan</a>
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

    <section class="section page-directory reveal">
        <div class="section-heading">
            <p class="eyebrow">Jelajahi Selaras Diri</p>
            <h2>Setiap menu punya halaman sendiri agar informasinya lebih fokus.</h2>
        </div>

        <div class="route-grid reveal-group">
            <a class="route-card reveal" href="{{ route('about') }}">
                <span>Tentang</span>
                <h3>Tentang Selaras Diri</h3>
                <p>Profil komunitas, visi, misi, dan dasar pendekatan Selaras Diri.</p>
            </a>
            <a class="route-card reveal" href="{{ route('services') }}">
                <span>Layanan</span>
                <h3>Konseling dan pricelist</h3>
                <p>Daftar sesi offline, online, couple, bundling, dan assessment.</p>
            </a>
            <a class="route-card reveal" href="{{ route('psychologists') }}">
                <span>Psikolog</span>
                <h3>Profil psikolog</h3>
                <p>Tim psikolog klinis dan anak-remaja beserta fokus pendampingannya.</p>
            </a>
            <a class="route-card reveal" href="{{ route('events') }}">
                <span>Event</span>
                <h3>Support group dan event bulanan</h3>
                <p>Agenda support group, trekking, art therapy, workshop, webinar, dan sesi wellness.</p>
            </a>
        </div>
    </section>

@endsection
