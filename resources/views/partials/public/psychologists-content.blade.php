@php
    $splitList = function ($value) {
        return collect(explode(',', (string) $value))
            ->map(fn ($item) => trim(preg_replace('/^(dan|serta)\s+/i', '', trim($item)), " .\t\n\r\0\x0B"))
            ->filter()
            ->values();
    };

    $psychologistProfile = function ($psychologist) use ($splitList) {
        $focusText = (string) data_get($psychologist, 'focus', '');
        $specialization = data_get($psychologist, 'specialization');
        $expertise = data_get($psychologist, 'expertise');

        if (! $expertise && str_contains($focusText, 'Keahlian:')) {
            [$focusPart, $expertisePart] = explode('Keahlian:', $focusText, 2);
            $expertise = $expertisePart;
            $specialization = $specialization ?: $focusPart;
        }

        return [
            'specializations' => $splitList($specialization),
            'expertise' => $splitList($expertise),
        ];
    };

    $cardImage = function ($psychologist) {
        $imageUrl = (string) data_get($psychologist, 'image_url', '');

        if ($imageUrl && str_starts_with($imageUrl, '/images/psychologists/') && ! str_contains($imageUrl, '/cards/')) {
            $candidate = '/images/psychologists/cards/' . basename($imageUrl);

            if (file_exists(public_path(ltrim($candidate, '/')))) {
                return $candidate;
            }
        }

        return $imageUrl;
    };

    $psychologistCount = $psychologists->count();
@endphp

<section class="relative isolate overflow-hidden border-b border-sd-ink/10 bg-sd-surface" id="psikolog">
    <div class="absolute inset-y-0 right-0 hidden w-[42%] bg-sd-soft/70 lg:block" aria-hidden="true"></div>
    <div class="absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-sd-paper to-transparent" aria-hidden="true"></div>

    <div class="relative mx-auto grid w-[min(1160px,calc(100%-48px))] items-center gap-7 py-8 reveal-now sm:gap-8 sm:py-14 lg:grid-cols-[minmax(0,0.95fr)_minmax(380px,0.85fr)] lg:gap-12 lg:py-16">
        <div>
            <p class="eyebrow">Psikolog Selaras Diri</p>
            <h1 class="max-w-[760px] font-serif text-[2.08rem] leading-[1.08] sm:text-5xl lg:text-[4rem] lg:leading-[1.02]">Temukan psikolog yang paling selaras dengan kebutuhanmu.</h1>
            <p class="mt-5 max-w-[650px] text-[1.04rem] leading-[1.78] text-sd-muted sm:text-[1.12rem]">Pilih psikolog berdasarkan area keahlian, lalu buka profil untuk melihat jadwal, format sesi, dan biaya secara lebih lengkap.</p>

            <div class="mt-7 flex flex-wrap gap-3">
                <a class="btn btn-primary" href="#daftar-psikolog">Lihat psikolog</a>
                <a class="btn btn-soft" href="{{ route('recommendation.quiz') }}">Cek kebutuhan</a>
            </div>
        </div>

        <aside class="relative rounded-lg border border-sd-ink/10 bg-sd-paper p-3 shadow-sd-md reveal sm:p-4" aria-label="Ringkasan psikolog Selaras Diri">
            <div class="grid grid-cols-2 gap-3">
                <figure class="relative overflow-hidden rounded-lg border border-sd-ink/10 bg-sd-surface">
                    <picture>
                        <source srcset="/images/psychologists/hero/psikolog-hero-session-01.webp" type="image/webp">
                        <img class="aspect-[4/5] w-full object-cover object-center" src="/images/psychologists/hero/psikolog-hero-session-01.jpg" width="900" height="1125" alt="Sesi psikolog Selaras Diri dalam ruang aman" loading="eager" fetchpriority="high">
                    </picture>
                </figure>
                <figure class="relative overflow-hidden rounded-lg border border-sd-ink/10 bg-sd-surface">
                    <picture>
                        <source srcset="/images/psychologists/hero/psikolog-hero-session-02.webp" type="image/webp">
                        <img class="aspect-[4/5] w-full object-cover object-center" src="/images/psychologists/hero/psikolog-hero-session-02.jpg" width="900" height="1125" alt="Ruang aman Selaras Diri untuk berbagi dan pulih" loading="eager" fetchpriority="high">
                    </picture>
                </figure>
            </div>

            <div class="mt-3 grid grid-cols-2 gap-2 sm:mt-4 sm:gap-3">
                <div class="rounded-lg border border-sd-ink/10 bg-sd-surface p-3 sm:p-4">
                    <span class="block font-serif text-2xl leading-none text-sd-primary sm:text-3xl">{{ $psychologistCount }}+</span>
                    <span class="mt-1 block text-[0.62rem] font-extrabold uppercase text-sd-muted sm:text-xs">Psikolog</span>
                </div>
                <div class="rounded-lg border border-sd-ink/10 bg-sd-surface p-3 sm:p-4">
                    <span class="block font-serif text-2xl leading-none text-sd-primary sm:text-3xl">3</span>
                    <span class="mt-1 block text-[0.62rem] font-extrabold uppercase text-sd-muted sm:text-xs">Format sesi</span>
                </div>
            </div>
        </aside>
    </div>
</section>

<section class="mx-auto w-[min(1160px,calc(100%-48px))] py-14 reveal sm:py-20" id="daftar-psikolog">
    <div class="mb-8 grid gap-6 lg:grid-cols-[minmax(0,0.9fr)_minmax(320px,0.55fr)] lg:items-end">
        <div>
            <p class="eyebrow">Daftar Psikolog</p>
            <h2 class="max-w-[760px] text-3xl leading-[1.12] sm:text-4xl lg:text-5xl lg:leading-[1.06]">Pilih dari area keahlian yang paling dekat dengan kondisimu.</h2>
        </div>
        <p class="max-w-[420px] text-sm font-semibold leading-[1.72] text-sd-muted lg:justify-self-end">Card dibuat lebih ringkas agar mudah dipindai. Detail jadwal, profil, dan biaya tersedia di halaman masing-masing psikolog.</p>
    </div>

    <div class="grid gap-5 reveal-group md:grid-cols-2 xl:grid-cols-3">
        @foreach ($psychologists as $psychologist)
            @php
                $profile = $psychologistProfile($psychologist);
                $expertiseItems = $profile['expertise']->isNotEmpty() ? $profile['expertise']->take(4) : $profile['specializations']->take(4);
                $primarySpecializations = $profile['specializations']->take(3);
                $imageUrl = $cardImage($psychologist);
                $psychologistId = data_get($psychologist, 'id');
                $detailUrl = $psychologistId
                    ? route('psychologists.show', ['psychologist' => $psychologistId, 'slug' => \Illuminate\Support\Str::slug(data_get($psychologist, 'name'))])
                    : '#psikolog';
            @endphp

            <article class="reveal overflow-hidden rounded-lg border border-sd-ink/10 bg-sd-surface shadow-sd-sm transition duration-200 hover:-translate-y-1 hover:border-sd-primary/20 hover:shadow-sd-md">
                <a class="group flex h-full flex-col" href="{{ $detailUrl }}" aria-label="Lihat jadwal dan profil {{ data_get($psychologist, 'name') }}">
                    <div class="relative h-[300px] overflow-hidden bg-gradient-to-b from-sd-paper to-sd-soft/70 sm:h-[330px]">
                        <div class="absolute inset-x-8 bottom-0 top-8 rounded-t-full bg-sd-surface/70" aria-hidden="true"></div>

                        @if ($imageUrl)
                            <img class="relative z-[1] h-full w-full object-contain object-bottom px-5 pt-7 transition duration-300 group-hover:scale-[1.03]" src="{{ $imageUrl }}" alt="{{ data_get($psychologist, 'name') }}" loading="lazy">
                        @else
                            <div class="relative z-[1] grid h-full place-items-center text-[3.4rem] font-extrabold text-sd-primary">{{ data_get($psychologist, 'initials') ?: 'SD' }}</div>
                        @endif

                        <span class="absolute left-4 top-4 z-[2] rounded-full bg-sd-surface px-3 py-1.5 text-xs font-extrabold uppercase text-sd-primary shadow-sd-sm">{{ data_get($psychologist, 'role') }}</span>
                    </div>

                    <div class="flex flex-1 flex-col p-5 sm:p-6">
                        <h3 class="text-xl leading-tight sm:text-2xl">{{ data_get($psychologist, 'name') }}</h3>

                        <div class="mt-4 flex flex-wrap gap-2">
                            @forelse ($primarySpecializations as $item)
                                <span class="rounded-full bg-sd-paper px-3 py-1.5 text-xs font-extrabold text-sd-ink-soft">{{ $item }}</span>
                            @empty
                                <span class="rounded-full bg-sd-paper px-3 py-1.5 text-xs font-extrabold text-sd-ink-soft">Konseling Individu</span>
                            @endforelse
                        </div>

                        <div class="mt-5 border-t border-sd-ink/10 pt-4">
                            <p class="text-xs font-extrabold uppercase text-sd-rose">Keahlian</p>
                            <div class="mt-3 flex flex-wrap gap-2">
                                @forelse ($expertiseItems as $item)
                                    <span class="rounded-full border border-sd-primary/15 bg-sd-soft/55 px-3 py-1.5 text-xs font-extrabold text-sd-primary">{{ $item }}</span>
                                @empty
                                    <span class="rounded-full border border-sd-primary/15 bg-sd-soft/55 px-3 py-1.5 text-xs font-extrabold text-sd-primary">Konseling Individu</span>
                                @endforelse
                            </div>
                        </div>

                        <span class="mt-auto inline-flex min-h-11 w-fit items-center gap-2 pt-5 text-sm font-extrabold text-sd-primary transition-colors group-hover:text-sd-primary-dark">
                            Lihat jadwal dan profil
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </span>
                    </div>
                </a>
            </article>
        @endforeach
    </div>
</section>
