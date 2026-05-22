<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CMS | Selaras Diri</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-site">
    <aside class="admin-sidebar">
        <a class="brand" href="{{ route('home') }}" target="_blank">
            <span class="brand-mark">SD</span>
            <span>Selaras Diri</span>
        </a>
        <nav class="admin-nav" aria-label="Navigasi CMS">
            <a href="#konten">Konten</a>
            <a href="#psikolog">Psikolog</a>
            <a href="#pricelist">Pricelist</a>
            <a href="#event">Event</a>
        </nav>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit">Keluar</button>
        </form>
    </aside>

    <main class="admin-main">
        <header class="admin-topbar">
            <div>
                <p class="eyebrow">CMS Selaras Diri</p>
                <h1>Kelola konten website</h1>
            </div>
            <a class="button button-soft" href="{{ route('home') }}" target="_blank">Lihat Website</a>
        </header>

        @if (session('status'))
            <p class="notice">{{ session('status') }}</p>
        @endif

        @if ($errors->any())
            <div class="notice notice-error">
                <strong>Periksa kembali input:</strong>
                <p>{{ $errors->first() }}</p>
            </div>
        @endif

        <section class="cms-section" id="konten">
            <div class="cms-section-head">
                <div>
                    <p class="eyebrow">Konten Utama</p>
                    <h2>Hero, tentang, visi misi, booking, dan kontak.</h2>
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
                <button class="button button-primary span-2" type="submit">Simpan Konten Utama</button>
            </form>
        </section>

        <section class="cms-section" id="psikolog">
            <div class="cms-section-head">
                <div>
                    <p class="eyebrow">Psikolog</p>
                    <h2>Tambah dan ubah profil psikolog.</h2>
                </div>
            </div>

            <form action="{{ route('admin.psychologists.store') }}" method="POST" class="cms-card cms-form cms-grid">
                @csrf
                <input type="hidden" name="is_active" value="0">
                <label><span>Nama</span><input name="name" required></label>
                <label><span>Role</span><input name="role"></label>
                <label class="span-2"><span>Fokus</span><textarea name="focus" rows="3" required></textarea></label>
                <label><span>Jadwal</span><input name="schedule"></label>
                <label><span>Biaya</span><input name="price"></label>
                <label class="span-2"><span>URL foto</span><input name="image_url" type="url"></label>
                <label><span>Urutan</span><input name="sort_order" type="number" min="0" value="0"></label>
                <label class="check-row"><input type="checkbox" name="is_active" value="1" checked><span>Aktif</span></label>
                <button class="button button-primary span-2" type="submit">Tambah Psikolog</button>
            </form>

            <div class="cms-list">
                @foreach ($psychologists as $psychologist)
                    <article class="cms-card">
                        <form action="{{ route('admin.psychologists.update', $psychologist) }}" method="POST" class="cms-form cms-grid">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="is_active" value="0">
                            <label><span>Nama</span><input name="name" value="{{ $psychologist->name }}" required></label>
                            <label><span>Role</span><input name="role" value="{{ $psychologist->role }}"></label>
                            <label class="span-2"><span>Fokus</span><textarea name="focus" rows="3" required>{{ $psychologist->focus }}</textarea></label>
                            <label><span>Jadwal</span><input name="schedule" value="{{ $psychologist->schedule }}"></label>
                            <label><span>Biaya</span><input name="price" value="{{ $psychologist->price }}"></label>
                            <label class="span-2"><span>URL foto</span><input name="image_url" type="url" value="{{ $psychologist->image_url }}"></label>
                            <label><span>Urutan</span><input name="sort_order" type="number" min="0" value="{{ $psychologist->sort_order }}"></label>
                            <label class="check-row"><input type="checkbox" name="is_active" value="1" @checked($psychologist->is_active)><span>Aktif</span></label>
                            <button class="button button-soft span-2" type="submit">Simpan Perubahan</button>
                        </form>
                        <form action="{{ route('admin.psychologists.destroy', $psychologist) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus psikolog</button>
                        </form>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="cms-section" id="pricelist">
            <div class="cms-section-head">
                <div>
                    <p class="eyebrow">Pricelist</p>
                    <h2>Kelola paket konseling dan harga.</h2>
                </div>
            </div>

            <form action="{{ route('admin.packages.store') }}" method="POST" class="cms-card cms-form cms-grid">
                @csrf
                <input type="hidden" name="is_active" value="0">
                <label><span>Judul</span><input name="title" required></label>
                <label><span>Durasi</span><input name="duration"></label>
                <label class="span-2"><span>Deskripsi</span><textarea name="description" rows="3"></textarea></label>
                <label><span>Harga</span><input name="price"></label>
                <label><span>Urutan</span><input name="sort_order" type="number" min="0" value="0"></label>
                <label class="check-row"><input type="checkbox" name="is_active" value="1" checked><span>Aktif</span></label>
                <button class="button button-primary span-2" type="submit">Tambah Pricelist</button>
            </form>

            <div class="cms-list">
                @foreach ($packages as $package)
                    <article class="cms-card">
                        <form action="{{ route('admin.packages.update', $package) }}" method="POST" class="cms-form cms-grid">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="is_active" value="0">
                            <label><span>Judul</span><input name="title" value="{{ $package->title }}" required></label>
                            <label><span>Durasi</span><input name="duration" value="{{ $package->duration }}"></label>
                            <label class="span-2"><span>Deskripsi</span><textarea name="description" rows="3">{{ $package->description }}</textarea></label>
                            <label><span>Harga</span><input name="price" value="{{ $package->price }}"></label>
                            <label><span>Urutan</span><input name="sort_order" type="number" min="0" value="{{ $package->sort_order }}"></label>
                            <label class="check-row"><input type="checkbox" name="is_active" value="1" @checked($package->is_active)><span>Aktif</span></label>
                            <button class="button button-soft span-2" type="submit">Simpan Perubahan</button>
                        </form>
                        <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus pricelist</button>
                        </form>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="cms-section" id="event">
            <div class="cms-section-head">
                <div>
                    <p class="eyebrow">Event</p>
                    <h2>Kelola support group dan event bulanan.</h2>
                </div>
            </div>

            <form action="{{ route('admin.events.store') }}" method="POST" class="cms-card cms-form cms-grid">
                @csrf
                <input type="hidden" name="is_active" value="0">
                <label>
                    <span>Tipe</span>
                    <select name="type" required>
                        <option value="monthly">Event bulanan</option>
                        <option value="support_group">Support group</option>
                    </select>
                </label>
                <label><span>Judul</span><input name="title" required></label>
                <label class="span-2"><span>Deskripsi</span><textarea name="description" rows="3"></textarea></label>
                <label><span>Jadwal</span><input name="schedule"></label>
                <label><span>Urutan</span><input name="sort_order" type="number" min="0" value="0"></label>
                <label class="span-2"><span>URL gambar</span><input name="image_url" type="url"></label>
                <label class="span-2"><span>Pesan booking khusus</span><textarea name="booking_message" rows="2"></textarea></label>
                <label class="check-row"><input type="checkbox" name="is_active" value="1" checked><span>Aktif</span></label>
                <button class="button button-primary span-2" type="submit">Tambah Event</button>
            </form>

            <div class="cms-list">
                @foreach ($events as $event)
                    <article class="cms-card">
                        <form action="{{ route('admin.events.update', $event) }}" method="POST" class="cms-form cms-grid">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="is_active" value="0">
                            <label>
                                <span>Tipe</span>
                                <select name="type" required>
                                    <option value="monthly" @selected($event->type === 'monthly')>Event bulanan</option>
                                    <option value="support_group" @selected($event->type === 'support_group')>Support group</option>
                                </select>
                            </label>
                            <label><span>Judul</span><input name="title" value="{{ $event->title }}" required></label>
                            <label class="span-2"><span>Deskripsi</span><textarea name="description" rows="3">{{ $event->description }}</textarea></label>
                            <label><span>Jadwal</span><input name="schedule" value="{{ $event->schedule }}"></label>
                            <label><span>Urutan</span><input name="sort_order" type="number" min="0" value="{{ $event->sort_order }}"></label>
                            <label class="span-2"><span>URL gambar</span><input name="image_url" type="url" value="{{ $event->image_url }}"></label>
                            <label class="span-2"><span>Pesan booking khusus</span><textarea name="booking_message" rows="2">{{ $event->booking_message }}</textarea></label>
                            <label class="check-row"><input type="checkbox" name="is_active" value="1" @checked($event->is_active)><span>Aktif</span></label>
                            <button class="button button-soft span-2" type="submit">Simpan Perubahan</button>
                        </form>
                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus event</button>
                        </form>
                    </article>
                @endforeach
            </div>
        </section>
    </main>
</body>
</html>
