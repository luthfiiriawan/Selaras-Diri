<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CMS | Selaras Diri</title>
    <link rel="icon" type="image/svg+xml" href="/images/logo.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-dvh bg-sd-paper text-sd-ink">

@php
    $psychologistPriceHint = 'Format: Nama layanan|Detail/durasi|Harga; pisahkan tiap item dengan titik koma. Untuk judul kategori gunakan #Nama Kategori; sebelum item baru.';
    $psychologistPricePlaceholder = 'Konsultasi / Konseling Offline|Durasi 1 jam|Rp300.000; #Minat & Bakat; Test IQ|Tanpa Konsul dengan Psikolog|Rp120.000';
@endphp

{{-- Sidebar --}}
<aside class="fixed inset-y-0 left-0 z-30 flex w-[280px] flex-col gap-6 overflow-y-auto border-r border-sd-ink/10 bg-sd-surface p-7 max-md:static max-md:w-full max-md:border-b max-md:border-r-0">
    <a class="w-fit" href="{{ route('home') }}" target="_blank" title="Buka website">
        <img src="/images/logo.svg" alt="Selaras Diri" class="h-11 w-auto">
    </a>

    <nav class="grid gap-2" aria-label="Navigasi CMS">
        <a class="flex min-h-12 items-center gap-2.5 rounded-lg border border-transparent px-3.5 font-extrabold text-sd-ink-soft transition-colors hover:border-sd-ink/10 hover:bg-sd-paper" href="#konten">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7"/></svg>
            Konten Utama
        </a>
        <a class="flex min-h-12 items-center gap-2.5 rounded-lg border border-transparent px-3.5 font-extrabold text-sd-ink-soft transition-colors hover:border-sd-ink/10 hover:bg-sd-paper" href="#psikolog">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6 5.87a4 4 0 100-8 4 4 0 000 8zm6-9a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Psikolog
            <span class="ml-auto rounded-full bg-sd-soft px-2.5 py-0.5 text-xs font-extrabold text-sd-primary">{{ $psychologists->count() }}</span>
        </a>
        <a class="flex min-h-12 items-center gap-2.5 rounded-lg border border-transparent px-3.5 font-extrabold text-sd-ink-soft transition-colors hover:border-sd-ink/10 hover:bg-sd-paper" href="#pricelist">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Pricelist
            <span class="ml-auto rounded-full bg-sd-soft px-2.5 py-0.5 text-xs font-extrabold text-sd-primary">{{ $packages->count() }}</span>
        </a>
        <a class="flex min-h-12 items-center gap-2.5 rounded-lg border border-transparent px-3.5 font-extrabold text-sd-ink-soft transition-colors hover:border-sd-ink/10 hover:bg-sd-paper" href="#event">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Event
            <span class="ml-auto rounded-full bg-sd-soft px-2.5 py-0.5 text-xs font-extrabold text-sd-primary">{{ $events->count() }}</span>
        </a>
        <a class="flex min-h-12 items-center gap-2.5 rounded-lg border border-transparent px-3.5 font-extrabold text-sd-ink-soft transition-colors hover:border-sd-ink/10 hover:bg-sd-paper" href="#keamanan">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            Keamanan 2FA
        </a>
    </nav>

    <form class="mt-auto" action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button class="flex min-h-12 w-full cursor-pointer items-center gap-2.5 rounded-lg border border-transparent px-3.5 text-left font-extrabold text-sd-ink-soft transition-colors hover:border-sd-ink/10 hover:bg-sd-paper" type="submit">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            Keluar
        </button>
    </form>
</aside>

{{-- Main --}}
<main class="ml-[280px] w-[calc(100%-280px)] p-8 max-md:ml-0 max-md:w-full max-md:p-6">

    <header class="mb-7 flex items-center justify-between gap-6 max-md:flex-col max-md:items-start">
        <div>
            <p class="eyebrow">CMS · Selaras Diri</p>
            <h1 class="m-0 font-serif text-[2.6rem] leading-tight">Kelola konten website</h1>
        </div>
        <a class="btn btn-soft whitespace-nowrap" href="{{ route('home') }}" target="_blank">
            Lihat Website
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        </a>
    </header>

    @if (session('status'))
        <div class="mb-4 flex items-center gap-2.5 rounded-lg border border-sd-primary/20 bg-sd-sage/15 p-4 font-bold text-sd-primary" role="alert">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('status') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="mb-4 flex items-start gap-2.5 rounded-lg border border-sd-danger/20 bg-[#fff5f3] p-4 font-bold text-sd-danger" role="alert">
            <svg width="16" height="16" class="mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <div><strong>Periksa kembali input:</strong> {{ $errors->first() }}</div>
        </div>
    @endif

    {{-- ══ Konten Utama ══ --}}
    <section class="py-7" id="konten">
        <p class="eyebrow">01</p>
        <h2 class="m-0 mb-1 font-serif text-[2.05rem] leading-tight">Konten Utama</h2>
        <p class="mb-4 text-sm text-sd-muted">Hero, tentang, visi misi, booking, dan informasi kontak.</p>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="rounded-lg border border-sd-ink/10 bg-sd-surface p-6 shadow-sd-sm">
            @csrf @method('PUT')
            <div class="grid gap-4 md:grid-cols-2">
                @foreach ($settingFields as $key => $field)
                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft {{ $field['type'] === 'textarea' ? 'md:col-span-2' : '' }}">
                        <span>{{ $field['label'] }}</span>
                        @if ($field['type'] === 'textarea')
                            <textarea class="min-h-12 w-full resize-y rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold leading-relaxed text-sd-ink" name="{{ $key }}" rows="3">{{ old($key, $settings[$key] ?? '') }}</textarea>
                        @else
                            <input class="min-h-12 w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" type="text" name="{{ $key }}" value="{{ old($key, $settings[$key] ?? '') }}">
                        @endif
                    </label>
                @endforeach
                <div class="md:col-span-2">
                    <button class="btn btn-primary" type="submit">Simpan Konten Utama</button>
                </div>
            </div>
        </form>
    </section>

    {{-- ══ Psikolog ══ --}}
    <section class="py-7" id="psikolog">
        <p class="eyebrow">02</p>
        <h2 class="m-0 mb-1 font-serif text-[2.05rem] leading-tight">Psikolog</h2>
        <p class="mb-4 text-sm text-sd-muted">Kelola profil psikolog yang tampil di halaman website.</p>

        <details class="mb-4 rounded-lg border border-sd-ink/10 bg-sd-surface">
            <summary class="flex cursor-pointer items-center gap-2.5 p-4 font-extrabold text-sd-primary [&::-webkit-details-marker]:hidden">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Tambah Psikolog Baru
            </summary>
            <form action="{{ route('admin.psychologists.store') }}" method="POST" enctype="multipart/form-data" class="border-t border-sd-ink/10 p-6">
                @csrf
                <input type="hidden" name="is_active" value="0">
                <div class="grid gap-4 md:grid-cols-2">
                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Nama lengkap</span><input class="min-h-12 w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="name" placeholder="Nama S.Psi., M.Psi., Psikolog" required></label>
                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Role / gelar singkat</span><input class="min-h-12 w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="role" placeholder="Psikolog Klinis"></label>
                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft md:col-span-2"><span>Bio singkat</span><textarea class="min-h-12 w-full resize-y rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold leading-relaxed text-sd-ink" name="focus" rows="2" placeholder="Pendamping untuk kebutuhan emosi dan relasi..." required></textarea></label>
                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft md:col-span-2"><span>Spesialisasi <span class="font-normal text-sd-muted">pisahkan dengan koma</span></span><textarea class="min-h-12 w-full resize-y rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold leading-relaxed text-sd-ink" name="specialization" rows="2" placeholder="Kecemasan, Depresi, Trauma, ..."></textarea></label>
                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft md:col-span-2"><span>Keahlian / metode <span class="font-normal text-sd-muted">pisahkan dengan koma</span></span><textarea class="min-h-12 w-full resize-y rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold leading-relaxed text-sd-ink" name="expertise" rows="2" placeholder="CBT, ACT, Art Therapy, ..."></textarea></label>
                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Lokasi / Jadwal</span><input class="min-h-12 w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="schedule" placeholder="Jabarano Laswi"></label>
                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft md:col-span-2">
                        <span>Biaya sesi <span class="font-normal text-sd-muted">format detail halaman psikolog</span></span>
                        <textarea class="min-h-12 w-full resize-y rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold leading-relaxed text-sd-ink" name="price" rows="4" placeholder="{{ $psychologistPricePlaceholder }}"></textarea>
                        <span class="text-xs font-semibold leading-relaxed text-sd-muted">{{ $psychologistPriceHint }}</span>
                    </label>
                    <div class="md:col-span-2">
                        <p class="mb-2 text-sm font-extrabold text-sd-ink-soft">Foto psikolog</p>
                        @include('admin.partials.image-upload', ['id' => 'new-psy', 'existing' => null])
                    </div>
                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Urutan tampil</span><input class="min-h-12 w-[120px] rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="sort_order" type="number" min="0" value="0"></label>
                    <label class="flex min-h-12 items-center gap-2.5 text-sm font-extrabold text-sd-ink-soft"><input class="h-5 w-5" type="checkbox" name="is_active" value="1" checked><span>Tampilkan di website</span></label>
                    <div class="md:col-span-2"><button class="btn btn-primary" type="submit">Tambah Psikolog</button></div>
                </div>
            </form>
        </details>

        @if ($psychologists->count())
            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                <p class="m-0 text-sm text-sd-muted">{{ $psychologists->count() }} psikolog terdaftar</p>
                <input type="text" class="min-h-11 w-[260px] max-w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 font-semibold text-sd-ink" placeholder="Cari nama psikolog..." oninput="cmsFilter(this,'psy-list')">
            </div>
            <div class="grid gap-4" id="psy-list">
                @foreach ($psychologists as $psychologist)
                    <article class="rounded-lg border border-sd-ink/10 bg-sd-surface p-4 shadow-sd-sm" data-search="{{ strtolower($psychologist->name . ' ' . $psychologist->role . ' ' . $psychologist->schedule) }}">
                        <div class="flex items-center gap-3">
                            @if ($psychologist->image_url)
                                <img src="{{ $psychologist->image_url }}" alt="" class="h-12 w-12 shrink-0 rounded-lg object-cover">
                            @else
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-sd-soft font-extrabold text-sd-primary">{{ substr($psychologist->name, 0, 1) }}</div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <strong class="block truncate">{{ $psychologist->name }}</strong>
                                <span class="block truncate text-sm text-sd-muted">{{ $psychologist->role }} · {{ $psychologist->schedule }}</span>
                            </div>
                            <div class="flex shrink-0 items-center gap-2">
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-extrabold {{ $psychologist->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-sd-ink/5 text-sd-muted' }}">{{ $psychologist->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                <button type="button" class="min-h-9 cursor-pointer rounded-lg border border-sd-ink/10 bg-transparent px-3 text-sm font-extrabold text-sd-ink-soft transition-colors hover:bg-sd-paper" onclick="toggleEdit(this)">Edit</button>
                                <form action="{{ route('admin.psychologists.destroy', $psychologist) }}" method="POST" onsubmit="return confirmDelete('{{ addslashes($psychologist->name) }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="min-h-9 cursor-pointer rounded-lg border border-sd-danger/20 bg-[#fff5f3] px-3 text-sm font-extrabold text-sd-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                        <div class="cms-edit-form hidden">
                            <form action="{{ route('admin.psychologists.update', $psychologist) }}" method="POST" enctype="multipart/form-data" class="mt-5 border-t border-sd-ink/10 pt-5">
                                @csrf @method('PUT')
                                <input type="hidden" name="is_active" value="0">
                                <div class="grid gap-4 md:grid-cols-2">
                                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Nama lengkap</span><input class="min-h-12 w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="name" value="{{ $psychologist->name }}" required></label>
                                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Role / gelar singkat</span><input class="min-h-12 w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="role" value="{{ $psychologist->role }}"></label>
                                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft md:col-span-2"><span>Bio singkat</span><textarea class="min-h-12 w-full resize-y rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold leading-relaxed text-sd-ink" name="focus" rows="2" required>{{ $psychologist->focus }}</textarea></label>
                                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft md:col-span-2"><span>Spesialisasi <span class="font-normal text-sd-muted">pisahkan dengan koma</span></span><textarea class="min-h-12 w-full resize-y rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold leading-relaxed text-sd-ink" name="specialization" rows="2">{{ $psychologist->specialization }}</textarea></label>
                                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft md:col-span-2"><span>Keahlian / metode <span class="font-normal text-sd-muted">pisahkan dengan koma</span></span><textarea class="min-h-12 w-full resize-y rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold leading-relaxed text-sd-ink" name="expertise" rows="2">{{ $psychologist->expertise }}</textarea></label>
                                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Lokasi / Jadwal</span><input class="min-h-12 w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="schedule" value="{{ $psychologist->schedule }}"></label>
                                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft md:col-span-2">
                                        <span>Biaya sesi <span class="font-normal text-sd-muted">format detail halaman psikolog</span></span>
                                        <textarea class="min-h-12 w-full resize-y rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold leading-relaxed text-sd-ink" name="price" rows="4" placeholder="{{ $psychologistPricePlaceholder }}">{{ $psychologist->price }}</textarea>
                                        <span class="text-xs font-semibold leading-relaxed text-sd-muted">{{ $psychologistPriceHint }}</span>
                                    </label>
                                    <div class="md:col-span-2">
                                        <p class="mb-2 text-sm font-extrabold text-sd-ink-soft">Foto psikolog</p>
                                        @include('admin.partials.image-upload', ['id' => 'psy-'.$psychologist->id, 'existing' => $psychologist->image_url])
                                    </div>
                                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Urutan tampil</span><input class="min-h-12 w-[120px] rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="sort_order" type="number" min="0" value="{{ $psychologist->sort_order }}"></label>
                                    <label class="flex min-h-12 items-center gap-2.5 text-sm font-extrabold text-sd-ink-soft"><input class="h-5 w-5" type="checkbox" name="is_active" value="1" @checked($psychologist->is_active)><span>Tampilkan di website</span></label>
                                    <div class="flex gap-3 md:col-span-2">
                                        <button class="btn btn-soft" type="submit">Simpan Perubahan</button>
                                        <button type="button" class="min-h-12 cursor-pointer rounded-lg border border-sd-ink/10 bg-transparent px-4 font-extrabold text-sd-muted transition-colors hover:bg-sd-paper" onclick="toggleEdit(this.closest('.cms-edit-form').previousElementSibling.querySelector('button[onclick^=toggleEdit]'))">Batal</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <p class="rounded-lg bg-sd-surface p-8 text-center text-sm font-bold text-sd-muted shadow-sd-sm">Belum ada psikolog. Tambahkan yang pertama di atas.</p>
        @endif
    </section>

    {{-- ══ Pricelist ══ --}}
    <section class="py-7" id="pricelist">
        <p class="eyebrow">03</p>
        <h2 class="m-0 mb-1 font-serif text-[2.05rem] leading-tight">Pricelist</h2>
        <p class="mb-4 text-sm text-sd-muted">Kelola paket layanan konseling dan harganya.</p>

        <details class="mb-4 rounded-lg border border-sd-ink/10 bg-sd-surface">
            <summary class="flex cursor-pointer items-center gap-2.5 p-4 font-extrabold text-sd-primary [&::-webkit-details-marker]:hidden">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Tambah Paket Baru
            </summary>
            <form action="{{ route('admin.packages.store') }}" method="POST" class="border-t border-sd-ink/10 p-6">
                @csrf
                <input type="hidden" name="is_active" value="0">
                <div class="grid gap-4 md:grid-cols-2">
                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Nama paket</span><input class="min-h-12 w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="title" placeholder="Konseling Offline" required></label>
                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Durasi</span><input class="min-h-12 w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="duration" placeholder="1 jam"></label>
                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft md:col-span-2"><span>Deskripsi</span><textarea class="min-h-12 w-full resize-y rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold leading-relaxed text-sd-ink" name="description" rows="3" placeholder="Sesi tatap muka dengan psikolog..."></textarea></label>
                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Harga</span><input class="min-h-12 w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="price" placeholder="Rp300.000"></label>
                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Urutan tampil</span><input class="min-h-12 w-[120px] rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="sort_order" type="number" min="0" value="0"></label>
                    <label class="flex min-h-12 items-center gap-2.5 text-sm font-extrabold text-sd-ink-soft"><input class="h-5 w-5" type="checkbox" name="is_active" value="1" checked><span>Tampilkan di website</span></label>
                    <div class="md:col-span-2"><button class="btn btn-primary" type="submit">Tambah Paket</button></div>
                </div>
            </form>
        </details>

        @if ($packages->count())
            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                <p class="m-0 text-sm text-sd-muted">{{ $packages->count() }} paket terdaftar</p>
                <input type="text" class="min-h-11 w-[260px] max-w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 font-semibold text-sd-ink" placeholder="Cari nama paket..." oninput="cmsFilter(this,'pkg-list')">
            </div>
            <div class="grid gap-4" id="pkg-list">
                @foreach ($packages as $package)
                    <article class="rounded-lg border border-sd-ink/10 bg-sd-surface p-4 shadow-sd-sm" data-search="{{ strtolower($package->title . ' ' . $package->duration) }}">
                        <div class="flex items-center gap-3">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-sd-soft text-sd-primary">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <strong class="block truncate">{{ $package->title }}</strong>
                                <span class="block truncate text-sm text-sd-muted">{{ $package->duration }} · {{ $package->price }}</span>
                            </div>
                            <div class="flex shrink-0 items-center gap-2">
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-extrabold {{ $package->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-sd-ink/5 text-sd-muted' }}">{{ $package->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                <button type="button" class="min-h-9 cursor-pointer rounded-lg border border-sd-ink/10 bg-transparent px-3 text-sm font-extrabold text-sd-ink-soft transition-colors hover:bg-sd-paper" onclick="toggleEdit(this)">Edit</button>
                                <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" onsubmit="return confirmDelete('{{ addslashes($package->title) }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="min-h-9 cursor-pointer rounded-lg border border-sd-danger/20 bg-[#fff5f3] px-3 text-sm font-extrabold text-sd-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                        <div class="cms-edit-form hidden">
                            <form action="{{ route('admin.packages.update', $package) }}" method="POST" class="mt-5 border-t border-sd-ink/10 pt-5">
                                @csrf @method('PUT')
                                <input type="hidden" name="is_active" value="0">
                                <div class="grid gap-4 md:grid-cols-2">
                                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Nama paket</span><input class="min-h-12 w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="title" value="{{ $package->title }}" required></label>
                                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Durasi</span><input class="min-h-12 w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="duration" value="{{ $package->duration }}"></label>
                                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft md:col-span-2"><span>Deskripsi</span><textarea class="min-h-12 w-full resize-y rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold leading-relaxed text-sd-ink" name="description" rows="3">{{ $package->description }}</textarea></label>
                                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Harga</span><input class="min-h-12 w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="price" value="{{ $package->price }}"></label>
                                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Urutan tampil</span><input class="min-h-12 w-[120px] rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="sort_order" type="number" min="0" value="{{ $package->sort_order }}"></label>
                                    <label class="flex min-h-12 items-center gap-2.5 text-sm font-extrabold text-sd-ink-soft"><input class="h-5 w-5" type="checkbox" name="is_active" value="1" @checked($package->is_active)><span>Tampilkan di website</span></label>
                                    <div class="flex gap-3 md:col-span-2">
                                        <button class="btn btn-soft" type="submit">Simpan Perubahan</button>
                                        <button type="button" class="min-h-12 cursor-pointer rounded-lg border border-sd-ink/10 bg-transparent px-4 font-extrabold text-sd-muted transition-colors hover:bg-sd-paper" onclick="toggleEdit(this.closest('.cms-edit-form').previousElementSibling.querySelector('button[onclick^=toggleEdit]'))">Batal</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <p class="rounded-lg bg-sd-surface p-8 text-center text-sm font-bold text-sd-muted shadow-sd-sm">Belum ada paket. Tambahkan yang pertama di atas.</p>
        @endif
    </section>

    {{-- ══ Event ══ --}}
    <section class="py-7" id="event">
        <p class="eyebrow">04</p>
        <h2 class="m-0 mb-1 font-serif text-[2.05rem] leading-tight">Event</h2>
        <p class="mb-4 text-sm text-sd-muted">Kelola support group rutin dan event bulanan.</p>

        <details class="mb-4 rounded-lg border border-sd-ink/10 bg-sd-surface">
            <summary class="flex cursor-pointer items-center gap-2.5 p-4 font-extrabold text-sd-primary [&::-webkit-details-marker]:hidden">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Tambah Event Baru
            </summary>
            <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="border-t border-sd-ink/10 p-6">
                @csrf
                <input type="hidden" name="is_active" value="0">
                <div class="grid gap-4 md:grid-cols-2">
                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Tipe event</span>
                        <select class="min-h-12 w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="type" required>
                            <option value="monthly">Event bulanan</option>
                            <option value="support_group">Support group</option>
                        </select>
                    </label>
                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Judul event</span><input class="min-h-12 w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="title" placeholder="Nama event" required></label>
                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft md:col-span-2"><span>Deskripsi</span><textarea class="min-h-12 w-full resize-y rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold leading-relaxed text-sd-ink" name="description" rows="3" placeholder="Ceritakan tentang event ini..."></textarea></label>
                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Jadwal</span><input class="min-h-12 w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="schedule" placeholder="Awal bulan · kuota terbatas"></label>
                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Urutan tampil</span><input class="min-h-12 w-[120px] rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="sort_order" type="number" min="0" value="0"></label>
                    <div class="md:col-span-2">
                        <p class="mb-2 text-sm font-extrabold text-sd-ink-soft">Gambar event</p>
                        @include('admin.partials.image-upload', ['id' => 'new-event', 'existing' => null])
                    </div>
                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft md:col-span-2"><span>Pesan booking khusus <span class="font-normal text-sd-muted">opsional, untuk WA</span></span><textarea class="min-h-12 w-full resize-y rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold leading-relaxed text-sd-ink" name="booking_message" rows="2" placeholder="Halo Selaras Diri, saya ingin daftar event..."></textarea></label>
                    <label class="flex min-h-12 items-center gap-2.5 text-sm font-extrabold text-sd-ink-soft"><input class="h-5 w-5" type="checkbox" name="is_active" value="1" checked><span>Tampilkan di website</span></label>
                    <div class="md:col-span-2"><button class="btn btn-primary" type="submit">Tambah Event</button></div>
                </div>
            </form>
        </details>

        @if ($events->count())
            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                <p class="m-0 text-sm text-sd-muted">{{ $events->count() }} event terdaftar</p>
                <input type="text" class="min-h-11 w-[260px] max-w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 font-semibold text-sd-ink" placeholder="Cari judul event..." oninput="cmsFilter(this,'event-list')">
            </div>
            <div class="grid gap-4" id="event-list">
                @foreach ($events as $event)
                    <article class="rounded-lg border border-sd-ink/10 bg-sd-surface p-4 shadow-sd-sm" data-search="{{ strtolower($event->title . ' ' . $event->type . ' ' . $event->schedule) }}">
                        <div class="flex items-center gap-3">
                            @if ($event->image_url)
                                <img src="{{ $event->image_url }}" alt="" class="h-12 w-12 shrink-0 rounded-lg object-cover">
                            @else
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-sd-soft text-sd-primary">
                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <strong class="block truncate">{{ $event->title }}</strong>
                                <span class="block truncate text-sm text-sd-muted">{{ $event->type === 'support_group' ? 'Support Group' : 'Event Bulanan' }}@if ($event->schedule) · {{ $event->schedule }}@endif</span>
                            </div>
                            <div class="flex shrink-0 items-center gap-2">
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-extrabold {{ $event->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-sd-ink/5 text-sd-muted' }}">{{ $event->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                <button type="button" class="min-h-9 cursor-pointer rounded-lg border border-sd-ink/10 bg-transparent px-3 text-sm font-extrabold text-sd-ink-soft transition-colors hover:bg-sd-paper" onclick="toggleEdit(this)">Edit</button>
                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" onsubmit="return confirmDelete('{{ addslashes($event->title) }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="min-h-9 cursor-pointer rounded-lg border border-sd-danger/20 bg-[#fff5f3] px-3 text-sm font-extrabold text-sd-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                        <div class="cms-edit-form hidden">
                            <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="mt-5 border-t border-sd-ink/10 pt-5">
                                @csrf @method('PUT')
                                <input type="hidden" name="is_active" value="0">
                                <div class="grid gap-4 md:grid-cols-2">
                                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Tipe event</span>
                                        <select class="min-h-12 w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="type" required>
                                            <option value="monthly" @selected($event->type === 'monthly')>Event bulanan</option>
                                            <option value="support_group" @selected($event->type === 'support_group')>Support group</option>
                                        </select>
                                    </label>
                                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Judul event</span><input class="min-h-12 w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="title" value="{{ $event->title }}" required></label>
                                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft md:col-span-2"><span>Deskripsi</span><textarea class="min-h-12 w-full resize-y rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold leading-relaxed text-sd-ink" name="description" rows="3">{{ $event->description }}</textarea></label>
                                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Jadwal</span><input class="min-h-12 w-full rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="schedule" value="{{ $event->schedule }}"></label>
                                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft"><span>Urutan tampil</span><input class="min-h-12 w-[120px] rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold text-sd-ink" name="sort_order" type="number" min="0" value="{{ $event->sort_order }}"></label>
                                    <div class="md:col-span-2">
                                        <p class="mb-2 text-sm font-extrabold text-sd-ink-soft">Gambar event</p>
                                        @include('admin.partials.image-upload', ['id' => 'event-'.$event->id, 'existing' => $event->image_url])
                                    </div>
                                    <label class="grid gap-2 text-sm font-extrabold text-sd-ink-soft md:col-span-2"><span>Pesan booking khusus <span class="font-normal text-sd-muted">opsional</span></span><textarea class="min-h-12 w-full resize-y rounded-lg border border-sd-ink/10 bg-[#fff8f4] px-3.5 py-3 font-semibold leading-relaxed text-sd-ink" name="booking_message" rows="2">{{ $event->booking_message }}</textarea></label>
                                    <label class="flex min-h-12 items-center gap-2.5 text-sm font-extrabold text-sd-ink-soft"><input class="h-5 w-5" type="checkbox" name="is_active" value="1" @checked($event->is_active)><span>Tampilkan di website</span></label>
                                    <div class="flex gap-3 md:col-span-2">
                                        <button class="btn btn-soft" type="submit">Simpan Perubahan</button>
                                        <button type="button" class="min-h-12 cursor-pointer rounded-lg border border-sd-ink/10 bg-transparent px-4 font-extrabold text-sd-muted transition-colors hover:bg-sd-paper" onclick="toggleEdit(this.closest('.cms-edit-form').previousElementSibling.querySelector('button[onclick^=toggleEdit]'))">Batal</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <p class="rounded-lg bg-sd-surface p-8 text-center text-sm font-bold text-sd-muted shadow-sd-sm">Belum ada event. Tambahkan yang pertama di atas.</p>
        @endif
    </section>

    {{-- ══ Keamanan 2FA ══ --}}
    <section class="py-7" id="keamanan">
        <p class="eyebrow">05</p>
        <h2 class="m-0 mb-1 font-serif text-[2.05rem] leading-tight">Keamanan Dua Faktor (2FA)</h2>
        <p class="mb-4 text-sm text-sd-muted">Tingkatkan keamanan login admin dengan Google Authenticator.</p>

        <div class="rounded-lg border border-sd-ink/10 bg-sd-surface p-6 shadow-sd-sm">
            @if ($twoFactorConfirmed)
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-3 text-emerald-700">
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <strong class="text-lg">Otentikasi Dua Faktor (2FA) Aktif</strong>
                    </div>
                    <p class="text-sm text-sd-muted leading-relaxed">
                        Saat ini, akun admin dilindungi dengan 2FA. Setiap kali login, Anda harus memasukkan kode OTP 6-digit dari aplikasi Google Authenticator Anda.
                    </p>
                    <form action="{{ route('admin.2fa.disable') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menonaktifkan Otentikasi Dua Faktor (2FA)? Keamanan akun Anda akan berkurang.')">
                        @csrf
                        <button type="submit" class="btn btn-primary bg-sd-rose text-white hover:bg-sd-rose/90">Nonaktifkan 2FA</button>
                    </form>
                </div>
            @else
                <div class="flex flex-col gap-6">
                    <div class="flex items-center gap-3 text-sd-muted">
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <strong class="text-lg">Otentikasi Dua Faktor (2FA) Belum Aktif</strong>
                    </div>
                    <p class="text-sm text-sd-muted leading-relaxed">
                        Aktifkan 2FA untuk melindungi panel admin dari akses yang tidak sah. Kami merekomendasikan penggunaan aplikasi seperti Google Authenticator di HP Anda.
                    </p>

                    @if ($twoFactorSecret)
                        <div class="rounded-lg border border-sd-primary/10 bg-sd-soft/30 p-5">
                            <strong class="block text-sd-primary-dark mb-3">Langkah Setup 2FA:</strong>
                            <ol class="list-decimal list-inside text-sm text-sd-ink-soft space-y-2.5">
                                <li>Buka aplikasi <strong>Google Authenticator</strong> (atau Authenticator lainnya) di HP Anda.</li>
                                <li>Pilih opsi tambah akun (tanda <strong class="text-sd-primary">+</strong>) lalu pilih <strong>"Enter a setup key"</strong> / <strong>"Masukkan kunci pengaturan"</strong>.</li>
                                <li>
                                    Masukkan detail akun berikut:
                                    <div class="mt-2 grid gap-2 rounded border border-sd-ink/5 bg-white p-3 font-mono text-xs text-sd-ink">
                                        <div><strong>Nama Akun:</strong> Selaras Diri ({{ config('cms.admin_email') }})</div>
                                        <div class="flex items-center gap-2">
                                            <strong>Kunci Kriptografi (Secret Key):</strong>
                                            <span class="bg-sd-soft px-2 py-0.5 font-bold text-sm tracking-wider text-sd-primary select-all">{{ $twoFactorSecret }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li>Aplikasi di HP Anda akan mulai menghasilkan kode verifikasi 6-digit.</li>
                                <li>Masukkan kode verifikasi yang sedang aktif saat ini ke kotak di bawah untuk mengaktifkan:</li>
                            </ol>

                            <form action="{{ route('admin.2fa.enable') }}" method="POST" class="mt-5 flex flex-wrap items-end gap-3">
                                @csrf
                                <label class="grid gap-1.5 text-xs font-extrabold text-sd-ink-soft">
                                    <span>Kode Verifikasi 6-Digit</span>
                                    <input type="text" name="code" class="min-h-11 w-[160px] rounded border border-sd-ink/10 bg-white px-3 font-mono text-center text-lg font-bold tracking-widest text-sd-ink" placeholder="123456" maxlength="6" required>
                                </label>
                                <button type="submit" class="btn btn-primary min-h-11">Verifikasi & Aktifkan</button>
                            </form>
                            @error('two_factor_code')
                                <p class="mt-2 text-xs font-bold text-sd-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    @else
                        <form action="{{ route('admin.2fa.generate') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Aktifkan 2FA</button>
                        </form>
                    @endif
                </div>
            @endif
        </div>
    </section>

</main>

<script>
function toggleEdit(btn) {
    const card = btn.closest('article');
    const form = card.querySelector('.cms-edit-form');
    const isHidden = form.classList.contains('hidden');
    form.classList.toggle('hidden', !isHidden);
    const editBtn = card.querySelector('button[onclick^=toggleEdit]');
    if (editBtn) editBtn.textContent = isHidden ? 'Tutup' : 'Edit';
    if (isHidden) form.querySelector('input,textarea,select')?.focus();
}

function cmsFilter(input, listId) {
    const q = input.value.toLowerCase().trim();
    document.querySelectorAll('#' + listId + ' [data-search]').forEach(el => {
        el.style.display = (!q || el.dataset.search.includes(q)) ? '' : 'none';
    });
}

function confirmDelete(name) {
    return confirm('Hapus "' + name + '"?\n\nData yang dihapus tidak bisa dikembalikan.');
}

function previewUpload(input, previewId) {
    const wrap = document.getElementById(previewId);
    if (!wrap) return;
    const file = input.files[0];
    if (!file) return;
    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran file terlalu besar. Maksimal 2 MB.');
        input.value = '';
        return;
    }
    const reader = new FileReader();
    reader.onload = e => {
        const img = wrap.querySelector('img');
        if (img) { img.src = e.target.result; wrap.classList.remove('hidden'); }
    };
    reader.readAsDataURL(file);
    const text = input.closest('label')?.querySelector('.upload-label-text');
    if (text) text.textContent = file.name;
}
</script>
</body>
</html>
