@php
    $packageGroups = collect($packages)->groupBy(function ($package) {
        $title = strtolower((string) data_get($package, 'title'));

        return match (true) {
            str_contains($title, 'test') || str_contains($title, 'assessment') || str_contains($title, 'minat') => 'assessment',
            str_contains($title, 'couple') => 'couple',
            str_contains($title, 'bundling') => 'bundling',
            default => 'individual',
        };
    });

    $groupMeta = [
        'individual' => [
            'label' => 'Konseling Individu',
            'summary' => 'Sesi personal untuk emosi, stres, relasi, dan pengembangan diri.',
            'icon' => 'user',
        ],
        'bundling' => [
            'label' => 'Paket Bundling',
            'summary' => 'Rangkaian beberapa sesi untuk proses pendampingan yang lebih berkelanjutan.',
            'icon' => 'layers',
        ],
        'couple' => [
            'label' => 'Couple Session',
            'summary' => 'Pendampingan untuk memahami dinamika relasi dan komunikasi pasangan.',
            'icon' => 'heart',
        ],
        'assessment' => [
            'label' => 'Assessment',
            'summary' => 'Tes IQ, minat bakat, dan konsultasi hasil bersama psikolog.',
            'icon' => 'clipboard',
        ],
    ];

    $orderedGroups = collect(['individual', 'bundling', 'couple', 'assessment'])
        ->filter(fn ($key) => $packageGroups->has($key));
@endphp

<section class="relative isolate overflow-hidden bg-sd-surface py-7 sm:py-10 lg:py-12">
    <div class="absolute inset-y-0 left-0 hidden w-[45%] bg-sd-soft lg:block" aria-hidden="true"></div>
    <div class="absolute inset-y-0 right-0 hidden w-[58%] bg-sd-primary lg:block" aria-hidden="true"></div>
    <div class="absolute inset-y-0 right-0 hidden w-[58%] opacity-45 [background-image:repeating-linear-gradient(135deg,rgba(255,253,250,0.18)_0_1px,transparent_1px_18px)] lg:block" aria-hidden="true"></div>

    <div class="relative mx-auto grid w-[min(1160px,calc(100%-48px))] items-center gap-0 lg:min-h-[500px] lg:grid-cols-[minmax(360px,0.96fr)_minmax(0,1.04fr)]">
        <div class="relative order-2 flex min-h-[300px] items-center justify-center bg-sd-soft px-5 py-7 sm:min-h-[430px] sm:px-8 sm:py-10 lg:order-1 lg:min-h-[460px] lg:bg-transparent lg:px-0 lg:py-12">
            <div class="absolute left-5 top-5 z-20 hidden max-w-[220px] rounded-lg border border-sd-ink/10 bg-sd-surface/95 p-4 shadow-sd-sm sm:left-8 sm:top-8 sm:block lg:left-auto lg:right-[-40px] lg:top-14">
                <p class="text-xs font-extrabold uppercase text-sd-rose">Ruang layanan</p>
                <p class="mt-2 text-sm font-bold leading-[1.55] text-sd-ink-soft">Pendampingan personal dan komunitas dalam satu ekosistem Selaras Diri.</p>
            </div>

            <figure class="relative w-full max-w-[560px] overflow-hidden rounded-lg border border-sd-ink/10 bg-sd-paper shadow-sd-md lg:-translate-x-6">
                <picture>
                    <source srcset="/images/services/layanan-hero.webp" type="image/webp">
                    <img class="aspect-[4/3] w-full object-cover object-center" src="/images/services/layanan-hero.jpg" width="1800" height="1350" alt="Kegiatan komunitas Selaras Diri bersama peserta layanan" loading="eager" fetchpriority="high">
                </picture>
            </figure>

            <div class="absolute bottom-8 right-5 hidden rounded-lg border border-sd-ink/10 bg-sd-surface px-4 py-3 shadow-sd-sm sm:block lg:right-4">
                <p class="text-xs font-extrabold uppercase text-sd-rose">4 Kategori</p>
                <p class="mt-1 text-sm font-bold text-sd-ink-soft">Konseling, bundling, couple, assessment.</p>
            </div>
        </div>

        <div class="relative order-1 flex min-h-[0] items-center bg-sd-primary px-6 py-8 text-sd-surface sm:min-h-[420px] sm:p-10 lg:order-2 lg:min-h-[460px] lg:bg-transparent lg:py-12 lg:pl-20 lg:pr-10 xl:pl-24 xl:pr-14">
            <div class="absolute inset-0 opacity-30 [background-image:repeating-linear-gradient(135deg,rgba(255,253,250,0.18)_0_1px,transparent_1px_18px)] lg:hidden" aria-hidden="true"></div>
            <div class="relative max-w-[570px]">
                <p class="inline-flex rounded-full bg-sd-surface px-4 py-2 text-xs font-extrabold uppercase text-sd-primary shadow-sd-sm">Layanan Selaras Diri</p>
                <h1 class="mt-5 text-[2.15rem] leading-[1.04] sm:mt-6 sm:text-[3.5rem] sm:leading-[1.02] lg:text-[4.25rem] xl:text-[4.65rem]">Katalog sesi konseling dan assessment.</h1>
                <p class="mt-4 max-w-[560px] text-sm font-medium leading-[1.65] text-sd-surface/86 sm:mt-6 sm:text-base sm:leading-[1.78]">Temukan layanan yang sesuai untuk kebutuhan personal, relasi, keluarga, ataupun minat bakat. Semua sesi akan dibantu admin untuk pengecekan jadwal dan format terbaik.</p>
                <div class="mt-6 flex flex-wrap gap-3 sm:mt-8">
                    <a class="btn border-sd-surface bg-sd-surface text-sd-primary hover:bg-sd-soft" href="#katalog-layanan">Lihat katalog</a>
                    <a class="btn border-sd-surface/50 bg-transparent text-sd-surface hover:bg-sd-surface hover:text-sd-primary" href="{{ route('psychologists') }}">Pilih psikolog</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="relative scroll-mt-28 overflow-hidden bg-sd-paper/65 py-12 sm:py-16" id="teman-curhat">
    <div class="absolute inset-x-0 top-0 h-px bg-sd-ink/10" aria-hidden="true"></div>

    <div class="relative mx-auto grid w-[min(1160px,calc(100%-48px))] gap-7 lg:grid-cols-[minmax(0,1fr)_360px] lg:items-center">
        <div class="max-w-[720px]">
            <div class="flex flex-wrap gap-2">
                <span class="rounded-full border border-sd-primary/20 bg-sd-surface px-3 py-1 text-xs font-extrabold uppercase text-sd-primary">Gratis</span>
                <span class="rounded-full border border-sd-primary/20 bg-sd-surface px-3 py-1 text-xs font-extrabold uppercase text-sd-primary">Konselor Selaras</span>
                <span class="rounded-full border border-sd-primary/20 bg-sd-surface px-3 py-1 text-xs font-extrabold uppercase text-sd-primary">Bukan psikolog</span>
            </div>

            <p class="eyebrow mt-6">Teman Curhat Selaras</p>
            <h2 class="mt-3 max-w-[680px] text-3xl leading-[1.12] sm:text-4xl lg:text-5xl lg:leading-[1.08]">Ruang cerita gratis bersama konselor internal Selaras.</h2>
            <p class="mt-5 max-w-[680px] text-base leading-[1.8] text-sd-muted">Teman Curhat Selaras dibuat untuk teman selaras yang butuh didengar, menata pikiran, dan menemukan langkah awal yang lebih tenang. Sesi ini bukan layanan psikolog, tetapi dukungan emosional awal bersama konselor internal Selaras Diri.</p>

            <div class="mt-7 grid gap-3 sm:grid-cols-3">
                <div class="rounded-lg border border-sd-ink/10 bg-sd-surface p-4 shadow-sd-sm">
                    <div class="mb-3 inline-grid h-10 w-10 place-items-center rounded-full bg-sd-soft text-sd-primary">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3.75h5.25M6 18.75l-3 1.5.75-3.75A7.5 7.5 0 1118 18.75H6z"/></svg>
                    </div>
                    <h3 class="text-base font-extrabold text-sd-ink">Didengar dulu</h3>
                    <p class="mt-2 text-sm leading-[1.65] text-sd-muted">Ruang aman untuk bercerita tanpa perlu langsung memilih psikolog.</p>
                </div>
                <div class="rounded-lg border border-sd-ink/10 bg-sd-surface p-4 shadow-sd-sm">
                    <div class="mb-3 inline-grid h-10 w-10 place-items-center rounded-full bg-sd-soft text-sd-primary">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l2.25 2.25L15.75 9M12 3.75l7.5 3v5.25c0 4.5-3 7.5-7.5 8.25-4.5-.75-7.5-3.75-7.5-8.25V6.75l7.5-3z"/></svg>
                    </div>
                    <h3 class="text-base font-extrabold text-sd-ink">Konselor internal</h3>
                    <p class="mt-2 text-sm leading-[1.65] text-sd-muted">Didampingi konselor dari ekosistem Selaras, bukan psikolog klinis.</p>
                </div>
                <div class="rounded-lg border border-sd-ink/10 bg-sd-surface p-4 shadow-sd-sm">
                    <div class="mb-3 inline-grid h-10 w-10 place-items-center rounded-full bg-sd-soft text-sd-primary">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l3.75 2.25M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-base font-extrabold text-sd-ink">Cek slot admin</h3>
                    <p class="mt-2 text-sm leading-[1.65] text-sd-muted">Jadwal dan kuota akan dikonfirmasi terlebih dahulu melalui WhatsApp.</p>
                </div>
            </div>
        </div>

        <aside class="rounded-lg border border-sd-primary/15 bg-sd-surface p-5 shadow-sd-md sm:p-6">
            <p class="text-xs font-extrabold uppercase text-sd-rose">Alur Teman Curhat</p>
            <div class="mt-5 space-y-4">
                <div class="flex gap-3">
                    <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-sd-primary text-sm font-extrabold text-sd-surface">1</span>
                    <div>
                        <h3 class="font-extrabold text-sd-ink">Chat admin</h3>
                        <p class="mt-1 text-sm leading-[1.6] text-sd-muted">Sampaikan bahwa kamu ingin ikut Teman Curhat Selaras.</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-sd-primary text-sm font-extrabold text-sd-surface">2</span>
                    <div>
                        <h3 class="font-extrabold text-sd-ink">Admin cek kuota</h3>
                        <p class="mt-1 text-sm leading-[1.6] text-sd-muted">Admin bantu cek jadwal konselor internal yang tersedia.</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-sd-primary text-sm font-extrabold text-sd-surface">3</span>
                    <div>
                        <h3 class="font-extrabold text-sd-ink">Mulai sesi</h3>
                        <p class="mt-1 text-sm leading-[1.6] text-sd-muted">Jika butuh pendampingan lanjutan, admin dapat mengarahkan ke psikolog yang sesuai.</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 border-t border-sd-ink/10 pt-4 text-sm font-semibold leading-[1.65] text-sd-ink-soft">
                Tidak untuk diagnosis, terapi psikologis, atau kondisi krisis. Jika berada dalam keadaan darurat, segera hubungi layanan krisis atau fasilitas kesehatan terdekat.
            </div>

            <a class="btn mt-6 w-full border-sd-primary bg-sd-primary text-sd-surface hover:bg-sd-primary/90" href="{{ $curhatUrl }}" target="_blank" rel="noopener" aria-label="Daftar Teman Curhat Selaras melalui WhatsApp">Daftar Teman Curhat</a>
        </aside>
    </div>
</section>

<section class="mx-auto w-[min(1160px,calc(100%-48px))] py-12 reveal sm:py-16" id="katalog-layanan">
    <div class="mb-7">
        <div>
            <p class="eyebrow">Service Catalogue</p>
            <h2 class="max-w-[720px] text-3xl leading-[1.12] sm:text-4xl lg:text-5xl lg:leading-[1.08]">Pendampingan yang disusun berdasarkan kebutuhan sesi.</h2>
        </div>
    </div>

    <nav class="mb-8 flex gap-2 overflow-x-auto border-b border-sd-ink/10 pb-3" aria-label="Kategori layanan">
        @foreach ($orderedGroups as $key)
            <a class="inline-flex min-h-11 shrink-0 items-center rounded-full border border-sd-ink/10 bg-sd-surface px-4 text-sm font-extrabold text-sd-ink-soft transition-colors hover:border-sd-primary/30 hover:text-sd-primary" href="#layanan-{{ $key }}">{{ $groupMeta[$key]['label'] }}</a>
        @endforeach
    </nav>

    <div class="grid gap-4 reveal-group md:grid-cols-3">
        <article class="reveal rounded-lg border border-sd-ink/10 bg-sd-surface p-5 shadow-sd-sm">
            <div class="mb-4 inline-grid h-11 w-11 place-items-center rounded-full bg-sd-soft text-sd-primary">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a7.5 7.5 0 0115 0"/></svg>
            </div>
            <h3 class="font-extrabold text-sd-ink">Individual sessions</h3>
            <p class="mt-2 text-sm leading-[1.65] text-sd-muted">Sesi online atau offline untuk memahami kondisi emosi, stres, dan pola relasi.</p>
        </article>
        <article class="reveal rounded-lg border border-sd-ink/10 bg-sd-surface p-5 shadow-sd-sm">
            <div class="mb-4 inline-grid h-11 w-11 place-items-center rounded-full bg-sd-soft text-sd-primary">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25a3 3 0 106 0 3 3 0 00-6 0zM3.75 20.25a6.75 6.75 0 0113.5 0M16.5 10.5a2.25 2.25 0 104.5 0 2.25 2.25 0 00-4.5 0zM18 20.25a5 5 0 00-2.25-4.2"/></svg>
            </div>
            <h3 class="font-extrabold text-sd-ink">Couple & family support</h3>
            <p class="mt-2 text-sm leading-[1.65] text-sd-muted">Pendampingan relasi pasangan, komunikasi, keluarga, dan pola pengasuhan.</p>
        </article>
        <article class="reveal rounded-lg border border-sd-ink/10 bg-sd-surface p-5 shadow-sd-sm">
            <div class="mb-4 inline-grid h-11 w-11 place-items-center rounded-full bg-sd-soft text-sd-primary">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75h6M9 3.75A2.25 2.25 0 006.75 6v12A2.25 2.25 0 009 20.25h6A2.25 2.25 0 0017.25 18V6A2.25 2.25 0 0015 3.75M9 3.75V6h6V3.75M9.75 11.25h4.5M9.75 15h4.5"/></svg>
            </div>
            <h3 class="font-extrabold text-sd-ink">Assessment</h3>
            <p class="mt-2 text-sm leading-[1.65] text-sd-muted">Tes IQ, minat bakat, dan konsultasi hasil untuk kebutuhan sekolah atau arah pengembangan.</p>
        </article>
    </div>
</section>

<section class="mx-auto w-[min(1160px,calc(100%-48px))] pb-16 sm:pb-24">
    <div class="grid gap-6">
        @foreach ($orderedGroups as $key)
            <section class="reveal overflow-hidden rounded-lg border border-sd-ink/10 bg-sd-surface shadow-sd-sm" id="layanan-{{ $key }}">
                <div class="grid gap-5 border-b border-sd-ink/10 bg-sd-paper/55 p-5 md:grid-cols-[minmax(0,0.9fr)_minmax(0,1.1fr)] md:p-6">
                    <div>
                        <p class="text-xs font-extrabold uppercase text-sd-rose">Kategori layanan</p>
                        <h2 class="mt-2 text-3xl leading-[1.12]">{{ $groupMeta[$key]['label'] }}</h2>
                    </div>
                    <p class="max-w-[620px] text-sm font-semibold leading-[1.72] text-sd-muted">{{ $groupMeta[$key]['summary'] }}</p>
                </div>

                <div class="divide-y divide-sd-ink/10">
                    @foreach ($packageGroups[$key] as $package)
                        <article class="grid gap-4 p-5 transition-colors hover:bg-sd-paper/45 md:grid-cols-[minmax(0,1fr)_180px] md:items-center md:p-6">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="rounded-full bg-sd-soft px-3 py-1 text-xs font-extrabold text-sd-primary">{{ data_get($package, 'duration') ?: 'Sesi' }}</span>
                                    <span class="text-xs font-bold uppercase text-sd-muted">Selaras Diri</span>
                                </div>
                                <h3 class="mt-3 text-xl font-extrabold leading-snug text-sd-ink">{{ data_get($package, 'title') }}</h3>
                                <p class="mt-2 max-w-[760px] text-sm leading-[1.7] text-sd-muted">{{ data_get($package, 'description') }}</p>
                            </div>
                            <div class="flex items-center justify-between gap-4 md:block md:text-right">
                                <span class="text-xs font-extrabold uppercase text-sd-muted md:block">Mulai dari</span>
                                <strong class="text-2xl text-sd-primary md:mt-2 md:block">{{ data_get($package, 'price') }}</strong>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>
</section>
