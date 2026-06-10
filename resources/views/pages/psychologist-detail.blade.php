@extends('layouts.public')

@php
    $splitList = function ($value) {
        return collect(preg_split('/,|·/', (string) $value))
            ->map(fn ($item) => trim(preg_replace('/^(dan|serta)\s+/i', '', trim($item)), " .\t\n\r\0\x0B"))
            ->filter()
            ->values();
    };

    $focusText = (string) data_get($psychologist, 'focus', '');
    $specialization = data_get($psychologist, 'specialization');
    $expertise = data_get($psychologist, 'expertise');

    if (! $expertise && str_contains($focusText, 'Keahlian:')) {
        [$focusPart, $expertisePart] = explode('Keahlian:', $focusText, 2);
        $expertise = $expertisePart;
        $specialization = $specialization ?: $focusPart;
    }

    $specializations = $splitList($specialization);
    $expertiseItems = $splitList($expertise);
    $scheduleItems = $splitList(data_get($psychologist, 'schedule'));
    $psychologistName = trim((string) data_get($psychologist, 'name', 'psikolog Selaras Diri'));
    $psychologistWhatsappNumber = preg_replace('/\D+/', '', $settings['whatsapp_number'] ?? '6282115724455');
    $psychologistBookingMessage = rawurlencode("Hi kak, saya ingin booking untuk psikolog {$psychologistName}. Mohon info slot sesi yang tersedia.");
    $psychologistBookingUrl = "https://api.whatsapp.com/send?phone={$psychologistWhatsappNumber}&text={$psychologistBookingMessage}&type=phone_number&app_absent=0";

    $parsePriceRows = function ($value) {
        $value = (string) $value;
        $rowSeparator = str_contains($value, '|') ? '/;/' : '/,|·/';

        return collect(preg_split($rowSeparator, $value))
            ->map(function ($item) {
                $item = trim($item);

                if ($item === '') {
                    return null;
                }

                if (str_starts_with($item, '#')) {
                    return [
                        'type' => 'heading',
                        'title' => trim($item, '# '),
                    ];
                }

                if (str_contains($item, '|')) {
                    [$title, $meta, $price] = array_pad(array_map('trim', explode('|', $item, 3)), 3, '');

                    return [
                        'type' => 'package',
                        'title' => $title ?: 'Sesi konseling',
                        'meta' => $meta ?: 'Tanyakan detail ke admin',
                        'price' => $price,
                    ];
                }

                if (preg_match('/^(.*?)(Rp[\s\d.]+)/i', $item, $matches)) {
                    return [
                        'type' => 'package',
                        'title' => trim($matches[1]) ?: 'Sesi konseling',
                        'meta' => 'Durasi menyesuaikan format sesi',
                        'price' => trim($matches[2]),
                    ];
                }

                return [
                    'type' => 'package',
                    'title' => $item,
                    'meta' => 'Tanyakan detail ke admin',
                    'price' => '',
                ];
            })
            ->filter()
            ->values();
    };

    $priceRows = str_contains(strtolower((string) data_get($psychologist, 'name')), 'sarah dian')
        ? collect([
            ['title' => 'Konsultasi Offline', 'meta' => 'Durasi 1 jam', 'price' => 'Rp300.000'],
            ['title' => 'Online Video Call', 'meta' => 'Durasi 1 jam', 'price' => 'Rp220.000'],
            ['title' => 'Online Voice Call', 'meta' => 'Durasi 1 jam', 'price' => 'Rp170.000'],
            ['title' => 'Bundling Offline', 'meta' => '3 kali pertemuan', 'price' => 'Rp850.000'],
            ['title' => 'Bundling Online Video Call', 'meta' => '3 kali pertemuan', 'price' => 'Rp610.000'],
            ['title' => 'Couple Offline', 'meta' => 'Durasi 2 jam', 'price' => 'Rp600.000'],
            ['title' => 'Couple Online Video Call', 'meta' => 'Durasi 2 jam', 'price' => 'Rp440.000'],
        ])
        : $parsePriceRows(data_get($psychologist, 'price'));
@endphp

@section('content')
    <section class="mx-auto w-[min(1160px,calc(100%-48px))] py-10 lg:py-14">
        <a class="inline-flex min-h-11 items-center gap-2 rounded-full border border-sd-ink/10 bg-sd-surface px-4 text-sm font-extrabold text-sd-primary transition-colors hover:border-sd-primary/30" href="{{ route('psychologists') }}">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
            Kembali ke psikolog
        </a>

        <div class="mt-8 grid gap-6 lg:grid-cols-[minmax(280px,0.72fr)_minmax(0,1.45fr)]">
            <aside class="h-fit rounded-lg border border-sd-ink/10 bg-sd-surface p-5 shadow-sd-sm lg:sticky lg:top-28">
                @if (data_get($psychologist, 'image_url'))
                    <img class="aspect-[4/5] w-full rounded-lg object-cover object-top" src="{{ data_get($psychologist, 'image_url') }}" alt="{{ data_get($psychologist, 'name') }}">
                @else
                    <div class="grid aspect-[4/5] w-full place-items-center rounded-lg bg-gradient-to-br from-sd-primary via-sd-teal to-sd-rose text-[3.4rem] font-extrabold text-sd-surface">{{ data_get($psychologist, 'initials') ?: 'SD' }}</div>
                @endif

                <div class="mt-5">
                    <p class="text-xs font-extrabold uppercase text-sd-rose">{{ data_get($psychologist, 'role') }}</p>
                    <h1 class="mt-3 font-serif text-3xl leading-[1.08]">{{ data_get($psychologist, 'name') }}</h1>
                    <p class="mt-4 text-sm leading-[1.7] text-sd-muted">{{ data_get($psychologist, 'focus') }}</p>
                </div>
            </aside>

            <div class="grid gap-5">
                <section class="rounded-lg border border-sd-ink/10 bg-sd-surface p-6 shadow-sd-sm lg:p-8">
                    <p class="eyebrow">Profil psikolog</p>
                    <h2 class="max-w-[760px] text-2xl leading-[1.12] sm:text-3xl lg:text-5xl lg:leading-[1.06]">Kenali fokus pendampingan dan metode sesi.</h2>

                    <div class="mt-8 grid gap-5 md:grid-cols-2">
                        <div class="rounded-lg border border-sd-ink/10 bg-sd-paper/45 p-5">
                            <h3 class="text-sm font-extrabold uppercase text-sd-rose">Spesialisasi</h3>
                            <div class="mt-4 flex flex-wrap gap-2">
                                @forelse ($specializations as $item)
                                    <span class="rounded-full bg-sd-surface px-3 py-1.5 text-sm font-bold text-sd-ink-soft shadow-[inset_0_0_0_1px_rgba(35,24,23,0.08)]">{{ $item }}</span>
                                @empty
                                    <span class="text-sm font-bold text-sd-muted">Detail spesialisasi akan dikonfirmasi admin.</span>
                                @endforelse
                            </div>
                        </div>

                        <div class="rounded-lg border border-sd-ink/10 bg-sd-paper/45 p-5">
                            <h3 class="text-sm font-extrabold uppercase text-sd-rose">Keahlian</h3>
                            <div class="mt-4 flex flex-wrap gap-2">
                                @forelse ($expertiseItems as $item)
                                    <span class="rounded-full bg-sd-surface px-3 py-1.5 text-sm font-bold text-sd-ink-soft shadow-[inset_0_0_0_1px_rgba(35,24,23,0.08)]">{{ $item }}</span>
                                @empty
                                    <span class="text-sm font-bold text-sd-muted">Detail metode akan dikonfirmasi admin.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </section>

                <section class="grid gap-5 xl:grid-cols-[minmax(220px,0.75fr)_minmax(0,1.25fr)]">
                    <div class="rounded-lg border border-sd-ink/10 bg-sd-surface p-6 shadow-sd-sm">
                        <h2 class="text-sm font-extrabold uppercase text-sd-rose">Format dan jadwal</h2>
                        <p class="mt-3 text-sm leading-[1.65] text-sd-muted">Jadwal pasti akan dicek admin setelah kamu memilih format sesi.</p>

                        <dl class="mt-6 grid gap-4">
                            @forelse ($scheduleItems as $schedule)
                                <div class="rounded-lg bg-sd-paper/55 p-4">
                                    <dt class="text-xs font-extrabold uppercase text-sd-muted">Tersedia</dt>
                                    <dd class="mt-1 font-extrabold text-sd-ink-soft">{{ $schedule }}</dd>
                                </div>
                            @empty
                                <div class="rounded-lg bg-sd-paper/55 p-4">
                                    <dt class="text-xs font-extrabold uppercase text-sd-muted">Jadwal</dt>
                                    <dd class="mt-1 font-extrabold text-sd-ink-soft">Tanyakan ketersediaan ke admin.</dd>
                                </div>
                            @endforelse
                        </dl>
                    </div>

                    <div class="rounded-lg border border-sd-ink/10 bg-sd-surface p-6 shadow-sd-sm">
                        <h2 class="text-sm font-extrabold uppercase text-sd-rose">Pilihan sesi</h2>
                        <div class="mt-5 divide-y divide-sd-ink/10">
                            @forelse ($priceRows as $package)
                                @if (($package['type'] ?? 'package') === 'heading')
                                    <div class="py-4 first:pt-0">
                                        <p class="text-xs font-extrabold uppercase tracking-[0.12em] text-sd-rose">{{ $package['title'] }}</p>
                                    </div>
                                @else
                                    <div class="grid gap-2 py-4 first:pt-0 last:pb-0 sm:grid-cols-[minmax(0,1fr)_auto] sm:items-center">
                                        <div>
                                            <h3 class="font-extrabold text-sd-ink">{{ $package['title'] }}</h3>
                                            <p class="mt-1 text-sm text-sd-muted">{{ $package['meta'] }}</p>
                                        </div>
                                        @if ($package['price'])
                                            <p class="font-extrabold text-sd-primary">{{ $package['price'] }}</p>
                                        @endif
                                    </div>
                                @endif
                            @empty
                                <p class="text-sm font-bold text-sd-muted">Biaya sesi akan dikonfirmasi admin.</p>
                            @endforelse
                        </div>
                    </div>
                </section>

                <section class="flex flex-wrap items-center justify-between gap-4 rounded-lg border border-sd-primary/15 bg-sd-soft/55 p-5">
                    <p class="max-w-[620px] text-sm font-bold leading-[1.65] text-sd-ink-soft">Untuk jadwal pasti dan pilihan format terbaik, admin akan bantu cek slot yang tersedia terlebih dahulu.</p>
                    <a class="btn btn-primary" href="{{ $psychologistBookingUrl }}" target="_blank" rel="noopener">Tanyakan slot sesi</a>
                </section>
            </div>
        </div>
    </section>
@endsection
