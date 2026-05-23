<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CMS | Selaras Diri</title>
    <link rel="icon" type="image/svg+xml" href="/images/logo.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-site">

{{-- ── Sidebar ──────────────────────────────────────────────── --}}
<aside class="admin-sidebar">
    <a class="brand" href="{{ route('home') }}" target="_blank" title="Buka website">
        <img src="/images/logo.svg" alt="Selaras Diri" class="h-9 w-auto">
    </a>

    <nav class="admin-nav" aria-label="Navigasi CMS">
        <a href="#konten">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7"/></svg>
            Konten Utama
        </a>
        <a href="#psikolog">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6 5.87a4 4 0 100-8 4 4 0 000 8zm6-9a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Psikolog
            <span class="nav-badge">{{ $psychologists->count() }}</span>
        </a>
        <a href="#pricelist">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Pricelist
            <span class="nav-badge">{{ $packages->count() }}</span>
        </a>
        <a href="#event">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Event
            <span class="nav-badge">{{ $events->count() }}</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <p class="sidebar-user">Administrator</p>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Keluar
            </button>
        </form>
    </div>
</aside>

{{-- ── Main ──────────────────────────────────────────────────── --}}
<main class="admin-main">

    {{-- Topbar --}}
    <header class="admin-topbar">
        <div>
            <p class="eyebrow">CMS · Selaras Diri</p>
            <h1>Kelola konten website</h1>
        </div>
        <a class="button button-soft" href="{{ route('home') }}" target="_blank">
            Lihat Website
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        </a>
    </header>

    {{-- Notices --}}
    @if (session('status'))
        <div class="notice" role="alert">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="notice notice-error" role="alert">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <div>
                <strong>Periksa kembali input:</strong>
                <p>{{ $errors->first() }}</p>
            </div>
        </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════
         SECTION: Konten Utama
    ══════════════════════════════════════════════════════════ --}}
    <section class="cms-section" id="konten">
        <div class="cms-section-head">
            <div>
                <p class="eyebrow">01</p>
                <h2>Konten Utama</h2>
                <p class="cms-section-desc">Hero, tentang, visi misi, booking, dan informasi kontak.</p>
            </div>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="cms-card cms-form cms-grid">
            @csrf
            @method('PUT')
            @foreach ($settingFields as $key => $field)
                <label class="{{ $field['type'] === 'textarea' ? 'span-2' : '' }}">
                    <span>{{ $field['label'] }}</span>
                    @if ($field['type'] === 'textarea')
                        <textarea name="{{ $key }}" rows="3">{{ old($key, $settings[$key] ?? '') }}</textarea>
                    @else
                        <input type="text" name="{{ $key }}" value="{{ old($key, $settings[$key] ?? '') }}">
                    @endif
                </label>
            @endforeach
            <div class="span-2">
                <button class="button button-primary" type="submit">Simpan Konten Utama</button>
            </div>
        </form>
    </section>

    {{-- ══════════════════════════════════════════════════════════
         SECTION: Psikolog
    ══════════════════════════════════════════════════════════ --}}
    <section class="cms-section" id="psikolog">
        <div class="cms-section-head">
            <div>
                <p class="eyebrow">02</p>
                <h2>Psikolog</h2>
                <p class="cms-section-desc">Kelola profil psikolog yang tampil di halaman website.</p>
            </div>
        </div>

        {{-- Add new psychologist --}}
        <details class="cms-add-panel">
            <summary class="cms-add-toggle">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Tambah Psikolog Baru
            </summary>
            <form action="{{ route('admin.psychologists.store') }}" method="POST" enctype="multipart/form-data" class="cms-card cms-form cms-grid mt-4">
                @csrf
                <input type="hidden" name="is_active" value="0">
                <label><span>Nama lengkap</span><input name="name" placeholder="Nama S.Psi., M.Psi., Psikolog" required></label>
                <label><span>Role / gelar singkat</span><input name="role" placeholder="Psikolog Klinis"></label>
                <label class="span-2"><span>Bio singkat</span><textarea name="focus" rows="2" placeholder="Pendamping untuk kebutuhan emosi dan relasi..." required></textarea></label>
                <label class="span-2"><span>Spesialisasi <span class="field-hint">pisahkan dengan koma</span></span><textarea name="specialization" rows="2" placeholder="Kecemasan, Depresi, Trauma, ..."></textarea></label>
                <label class="span-2"><span>Keahlian / metode <span class="field-hint">pisahkan dengan koma</span></span><textarea name="expertise" rows="2" placeholder="CBT, ACT, Art Therapy, ..."></textarea></label>
                <label><span>Lokasi / Jadwal</span><input name="schedule" placeholder="Jabarano Laswi"></label>
                <label><span>Biaya sesi</span><input name="price" placeholder="Offline Rp300.000 · Video Rp220.000"></label>
                <div class="span-2">
                    <p class="field-label">Foto psikolog</p>
                    @include('admin.partials.image-upload', ['id' => 'new-psy', 'existing' => null])
                </div>
                <label><span>Urutan tampil</span><input name="sort_order" type="number" min="0" value="0" style="max-width:120px"></label>
                <label class="check-row"><input type="checkbox" name="is_active" value="1" checked><span>Tampilkan di website</span></label>
                <div class="span-2">
                    <button class="button button-primary" type="submit">Tambah Psikolog</button>
                </div>
            </form>
        </details>

        {{-- Search + List --}}
        @if ($psychologists->count())
            <div class="cms-list-header">
                <p class="cms-list-count">{{ $psychologists->count() }} psikolog terdaftar</p>
                <div class="cms-search">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" class="cms-search-input" placeholder="Cari nama psikolog..." oninput="cmsFilter(this,'psy-list')">
                </div>
            </div>

            <div class="cms-list" id="psy-list">
                @foreach ($psychologists as $psychologist)
                    <article class="cms-item-card" data-search="{{ strtolower($psychologist->name . ' ' . $psychologist->role . ' ' . $psychologist->schedule) }}">
                        {{-- Compact header --}}
                        <div class="cms-item-header">
                            <div class="cms-item-info">
                                @if ($psychologist->image_url)
                                    <img src="{{ $psychologist->image_url }}" alt="" class="cms-item-thumb">
                                @else
                                    <div class="cms-item-thumb-placeholder">{{ substr($psychologist->name, 0, 1) }}</div>
                                @endif
                                <div>
                                    <strong class="cms-item-name">{{ $psychologist->name }}</strong>
                                    <span class="cms-item-meta">{{ $psychologist->role }} · {{ $psychologist->schedule }}</span>
                                </div>
                            </div>
                            <div class="cms-item-actions">
                                <span class="cms-active-badge {{ $psychologist->is_active ? 'active' : 'inactive' }}">
                                    {{ $psychologist->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                                <button type="button" class="btn-toggle-edit" onclick="toggleEdit(this)">Edit</button>
                                <form action="{{ route('admin.psychologists.destroy', $psychologist) }}" method="POST" onsubmit="return confirmDelete('{{ addslashes($psychologist->name) }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-delete">Hapus</button>
                                </form>
                            </div>
                        </div>

                        {{-- Edit form (hidden by default) --}}
                        <div class="cms-item-form" style="display:none">
                            <form action="{{ route('admin.psychologists.update', $psychologist) }}" method="POST" enctype="multipart/form-data" class="cms-form cms-grid mt-5 pt-5 border-t" style="border-color:rgba(42,26,23,0.07)">
                                @csrf @method('PUT')
                                <input type="hidden" name="is_active" value="0">
                                <label><span>Nama lengkap</span><input name="name" value="{{ $psychologist->name }}" required></label>
                                <label><span>Role / gelar singkat</span><input name="role" value="{{ $psychologist->role }}"></label>
                                <label class="span-2"><span>Bio singkat</span><textarea name="focus" rows="2" required>{{ $psychologist->focus }}</textarea></label>
                                <label class="span-2"><span>Spesialisasi <span class="field-hint">pisahkan dengan koma</span></span><textarea name="specialization" rows="2">{{ $psychologist->specialization }}</textarea></label>
                                <label class="span-2"><span>Keahlian / metode <span class="field-hint">pisahkan dengan koma</span></span><textarea name="expertise" rows="2">{{ $psychologist->expertise }}</textarea></label>
                                <label><span>Lokasi / Jadwal</span><input name="schedule" value="{{ $psychologist->schedule }}"></label>
                                <label><span>Biaya sesi</span><input name="price" value="{{ $psychologist->price }}"></label>
                                <div class="span-2">
                                    <p class="field-label">Foto psikolog</p>
                                    @include('admin.partials.image-upload', ['id' => 'psy-'.$psychologist->id, 'existing' => $psychologist->image_url])
                                </div>
                                <label><span>Urutan tampil</span><input name="sort_order" type="number" min="0" value="{{ $psychologist->sort_order }}" style="max-width:120px"></label>
                                <label class="check-row"><input type="checkbox" name="is_active" value="1" @checked($psychologist->is_active)><span>Tampilkan di website</span></label>
                                <div class="span-2 flex gap-3">
                                    <button class="button button-soft" type="submit">Simpan Perubahan</button>
                                    <button type="button" class="btn-cancel" onclick="toggleEdit(this.closest('.cms-item-form').previousElementSibling.querySelector('.btn-toggle-edit'))">Batal</button>
                                </div>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <p class="cms-empty">Belum ada psikolog. Tambahkan yang pertama di atas.</p>
        @endif
    </section>

    {{-- ══════════════════════════════════════════════════════════
         SECTION: Pricelist
    ══════════════════════════════════════════════════════════ --}}
    <section class="cms-section" id="pricelist">
        <div class="cms-section-head">
            <div>
                <p class="eyebrow">03</p>
                <h2>Pricelist</h2>
                <p class="cms-section-desc">Kelola paket layanan konseling dan harganya.</p>
            </div>
        </div>

        {{-- Add new package --}}
        <details class="cms-add-panel">
            <summary class="cms-add-toggle">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Tambah Paket Baru
            </summary>
            <form action="{{ route('admin.packages.store') }}" method="POST" class="cms-card cms-form cms-grid mt-4">
                @csrf
                <input type="hidden" name="is_active" value="0">
                <label><span>Nama paket</span><input name="title" placeholder="Konseling Offline" required></label>
                <label><span>Durasi</span><input name="duration" placeholder="1 jam"></label>
                <label class="span-2"><span>Deskripsi</span><textarea name="description" rows="3" placeholder="Sesi tatap muka dengan psikolog..."></textarea></label>
                <label><span>Harga</span><input name="price" placeholder="Rp300.000"></label>
                <label><span>Urutan tampil</span><input name="sort_order" type="number" min="0" value="0" style="max-width:120px"></label>
                <label class="check-row"><input type="checkbox" name="is_active" value="1" checked><span>Tampilkan di website</span></label>
                <div class="span-2">
                    <button class="button button-primary" type="submit">Tambah Paket</button>
                </div>
            </form>
        </details>

        {{-- Search + List --}}
        @if ($packages->count())
            <div class="cms-list-header">
                <p class="cms-list-count">{{ $packages->count() }} paket terdaftar</p>
                <div class="cms-search">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" class="cms-search-input" placeholder="Cari nama paket..." oninput="cmsFilter(this,'pkg-list')">
                </div>
            </div>

            <div class="cms-list" id="pkg-list">
                @foreach ($packages as $package)
                    <article class="cms-item-card" data-search="{{ strtolower($package->title . ' ' . $package->duration) }}">
                        <div class="cms-item-header">
                            <div class="cms-item-info">
                                <div class="cms-item-icon">
                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </div>
                                <div>
                                    <strong class="cms-item-name">{{ $package->title }}</strong>
                                    <span class="cms-item-meta">{{ $package->duration }} · {{ $package->price }}</span>
                                </div>
                            </div>
                            <div class="cms-item-actions">
                                <span class="cms-active-badge {{ $package->is_active ? 'active' : 'inactive' }}">
                                    {{ $package->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                                <button type="button" class="btn-toggle-edit" onclick="toggleEdit(this)">Edit</button>
                                <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" onsubmit="return confirmDelete('{{ addslashes($package->title) }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-delete">Hapus</button>
                                </form>
                            </div>
                        </div>

                        <div class="cms-item-form" style="display:none">
                            <form action="{{ route('admin.packages.update', $package) }}" method="POST" class="cms-form cms-grid mt-5 pt-5 border-t" style="border-color:rgba(42,26,23,0.07)">
                                @csrf @method('PUT')
                                <input type="hidden" name="is_active" value="0">
                                <label><span>Nama paket</span><input name="title" value="{{ $package->title }}" required></label>
                                <label><span>Durasi</span><input name="duration" value="{{ $package->duration }}"></label>
                                <label class="span-2"><span>Deskripsi</span><textarea name="description" rows="3">{{ $package->description }}</textarea></label>
                                <label><span>Harga</span><input name="price" value="{{ $package->price }}"></label>
                                <label><span>Urutan tampil</span><input name="sort_order" type="number" min="0" value="{{ $package->sort_order }}" style="max-width:120px"></label>
                                <label class="check-row"><input type="checkbox" name="is_active" value="1" @checked($package->is_active)><span>Tampilkan di website</span></label>
                                <div class="span-2 flex gap-3">
                                    <button class="button button-soft" type="submit">Simpan Perubahan</button>
                                    <button type="button" class="btn-cancel" onclick="toggleEdit(this.closest('.cms-item-form').previousElementSibling.querySelector('.btn-toggle-edit'))">Batal</button>
                                </div>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <p class="cms-empty">Belum ada paket. Tambahkan yang pertama di atas.</p>
        @endif
    </section>

    {{-- ══════════════════════════════════════════════════════════
         SECTION: Event
    ══════════════════════════════════════════════════════════ --}}
    <section class="cms-section" id="event">
        <div class="cms-section-head">
            <div>
                <p class="eyebrow">04</p>
                <h2>Event</h2>
                <p class="cms-section-desc">Kelola support group rutin dan event bulanan.</p>
            </div>
        </div>

        {{-- Add new event --}}
        <details class="cms-add-panel">
            <summary class="cms-add-toggle">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Tambah Event Baru
            </summary>
            <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="cms-card cms-form cms-grid mt-4">
                @csrf
                <input type="hidden" name="is_active" value="0">
                <label>
                    <span>Tipe event</span>
                    <select name="type" required>
                        <option value="monthly">Event bulanan</option>
                        <option value="support_group">Support group</option>
                    </select>
                </label>
                <label><span>Judul event</span><input name="title" placeholder="Nama event" required></label>
                <label class="span-2"><span>Deskripsi</span><textarea name="description" rows="3" placeholder="Ceritakan tentang event ini..."></textarea></label>
                <label><span>Jadwal</span><input name="schedule" placeholder="Awal bulan · kuota terbatas"></label>
                <label><span>Urutan tampil</span><input name="sort_order" type="number" min="0" value="0" style="max-width:120px"></label>
                <div class="span-2">
                    <p class="field-label">Gambar event</p>
                    @include('admin.partials.image-upload', ['id' => 'new-event', 'existing' => null])
                </div>
                <label class="span-2"><span>Pesan booking khusus <span class="field-hint">opsional, untuk WA</span></span><textarea name="booking_message" rows="2" placeholder="Halo Selaras Diri, saya ingin daftar event..."></textarea></label>
                <label class="check-row"><input type="checkbox" name="is_active" value="1" checked><span>Tampilkan di website</span></label>
                <div class="span-2">
                    <button class="button button-primary" type="submit">Tambah Event</button>
                </div>
            </form>
        </details>

        {{-- Search + List --}}
        @if ($events->count())
            <div class="cms-list-header">
                <p class="cms-list-count">{{ $events->count() }} event terdaftar</p>
                <div class="cms-search">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" class="cms-search-input" placeholder="Cari judul event..." oninput="cmsFilter(this,'event-list')">
                </div>
            </div>

            <div class="cms-list" id="event-list">
                @foreach ($events as $event)
                    <article class="cms-item-card" data-search="{{ strtolower($event->title . ' ' . $event->type . ' ' . $event->schedule) }}">
                        <div class="cms-item-header">
                            <div class="cms-item-info">
                                @if ($event->image_url)
                                    <img src="{{ $event->image_url }}" alt="" class="cms-item-thumb" style="object-fit:cover">
                                @else
                                    <div class="cms-item-icon">
                                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                                <div>
                                    <strong class="cms-item-name">{{ $event->title }}</strong>
                                    <span class="cms-item-meta">
                                        {{ $event->type === 'support_group' ? 'Support Group' : 'Event Bulanan' }}
                                        @if ($event->schedule) · {{ $event->schedule }} @endif
                                    </span>
                                </div>
                            </div>
                            <div class="cms-item-actions">
                                <span class="cms-active-badge {{ $event->is_active ? 'active' : 'inactive' }}">
                                    {{ $event->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                                <button type="button" class="btn-toggle-edit" onclick="toggleEdit(this)">Edit</button>
                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" onsubmit="return confirmDelete('{{ addslashes($event->title) }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-delete">Hapus</button>
                                </form>
                            </div>
                        </div>

                        <div class="cms-item-form" style="display:none">
                            <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="cms-form cms-grid mt-5 pt-5 border-t" style="border-color:rgba(42,26,23,0.07)">
                                @csrf @method('PUT')
                                <input type="hidden" name="is_active" value="0">
                                <label>
                                    <span>Tipe event</span>
                                    <select name="type" required>
                                        <option value="monthly" @selected($event->type === 'monthly')>Event bulanan</option>
                                        <option value="support_group" @selected($event->type === 'support_group')>Support group</option>
                                    </select>
                                </label>
                                <label><span>Judul event</span><input name="title" value="{{ $event->title }}" required></label>
                                <label class="span-2"><span>Deskripsi</span><textarea name="description" rows="3">{{ $event->description }}</textarea></label>
                                <label><span>Jadwal</span><input name="schedule" value="{{ $event->schedule }}"></label>
                                <label><span>Urutan tampil</span><input name="sort_order" type="number" min="0" value="{{ $event->sort_order }}" style="max-width:120px"></label>
                                <div class="span-2">
                                    <p class="field-label">Gambar event</p>
                                    @include('admin.partials.image-upload', ['id' => 'event-'.$event->id, 'existing' => $event->image_url])
                                </div>
                                <label class="span-2"><span>Pesan booking khusus <span class="field-hint">opsional</span></span><textarea name="booking_message" rows="2">{{ $event->booking_message }}</textarea></label>
                                <label class="check-row"><input type="checkbox" name="is_active" value="1" @checked($event->is_active)><span>Tampilkan di website</span></label>
                                <div class="span-2 flex gap-3">
                                    <button class="button button-soft" type="submit">Simpan Perubahan</button>
                                    <button type="button" class="btn-cancel" onclick="toggleEdit(this.closest('.cms-item-form').previousElementSibling.querySelector('.btn-toggle-edit'))">Batal</button>
                                </div>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <p class="cms-empty">Belum ada event. Tambahkan yang pertama di atas.</p>
        @endif
    </section>

</main>

<script>
function toggleEdit(btn) {
    const card = btn.closest('.cms-item-card');
    const form = card.querySelector('.cms-item-form');
    const isHidden = form.style.display === 'none';
    form.style.display = isHidden ? 'block' : 'none';
    btn.textContent = isHidden ? 'Tutup' : 'Edit';
    btn.classList.toggle('active', isHidden);
    if (isHidden) form.querySelector('input,textarea,select')?.focus();
}

function cmsFilter(input, listId) {
    const q = input.value.toLowerCase().trim();
    const items = document.querySelectorAll('#' + listId + ' [data-search]');
    let visible = 0;
    items.forEach(el => {
        const match = !q || el.dataset.search.includes(q);
        el.style.display = match ? '' : 'none';
        if (match) visible++;
    });
}

function confirmDelete(name) {
    return confirm('Hapus "' + name + '"?\n\nData yang dihapus tidak bisa dikembalikan.');
}

function previewUpload(input, previewId) {
    const wrap = document.getElementById(previewId);
    if (!wrap) return;
    const img = wrap.querySelector('img');
    const file = input.files[0];
    if (!file) return;

    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran file terlalu besar. Maksimal 2 MB.');
        input.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = e => {
        if (img) { img.src = e.target.result; wrap.style.display = ''; }
    };
    reader.readAsDataURL(file);

    const label = input.closest('.upload-label');
    if (label) label.querySelector('.upload-label-text').textContent = file.name;
}
</script>

</body>
</html>
