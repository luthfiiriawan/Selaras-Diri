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
@endphp

<section class="mx-auto w-[min(1160px,calc(100%-48px))] pb-24 reveal" id="psikolog">
    <div class="mb-8 grid items-start gap-11 lg:grid-cols-[minmax(160px,0.42fr)_minmax(0,1fr)]">
        <p class="eyebrow">Psikolog</p>
        <div>
            <h2 class="text-5xl leading-[1.08]">Pilih psikolog dari keahlian yang paling sesuai.</h2>
            <p class="mt-5 max-w-[720px] text-sd-muted leading-[1.72]">Card dibuat ringkas agar mudah dipindai. Detail jadwal, profil, dan biaya tersedia di halaman masing-masing psikolog.</p>
        </div>
    </div>

    <div class="grid gap-4 reveal-group md:grid-cols-2 xl:grid-cols-3">
        @foreach ($psychologists as $psychologist)
            @php
                $profile = $psychologistProfile($psychologist);
                $expertiseItems = $profile['expertise']->isNotEmpty() ? $profile['expertise']->take(4) : $profile['specializations']->take(4);
                $psychologistId = data_get($psychologist, 'id');
                $detailUrl = $psychologistId
                    ? route('psychologists.show', ['psychologist' => $psychologistId, 'slug' => \Illuminate\Support\Str::slug(data_get($psychologist, 'name'))])
                    : '#psikolog';
            @endphp

            <article class="reveal overflow-hidden rounded-lg border border-sd-ink/10 bg-sd-surface shadow-sd-sm transition duration-200 hover:-translate-y-1 hover:shadow-sd-md">
                <a class="group block h-full" href="{{ $detailUrl }}" aria-label="Lihat jadwal dan profil {{ data_get($psychologist, 'name') }}">
                    @if (data_get($psychologist, 'image_url'))
                        <img class="aspect-[4/5] h-auto w-full object-cover object-top" src="{{ data_get($psychologist, 'image_url') }}" alt="{{ data_get($psychologist, 'name') }}" loading="lazy">
                    @else
                        <div class="grid aspect-[4/5] h-auto w-full place-items-center bg-gradient-to-br from-sd-primary via-sd-teal to-sd-rose text-[3.4rem] font-extrabold text-sd-surface">{{ data_get($psychologist, 'initials') ?: 'SD' }}</div>
                    @endif

                    <div class="p-6">
                        <span class="block text-xs font-extrabold uppercase text-sd-rose">{{ data_get($psychologist, 'role') }}</span>
                        <h3 class="mt-4 text-xl leading-tight">{{ data_get($psychologist, 'name') }}</h3>

                        <div class="mt-5 flex flex-wrap gap-2">
                            @forelse ($expertiseItems as $item)
                                <span class="rounded-full border border-sd-primary/15 bg-sd-soft/55 px-3 py-1.5 text-xs font-extrabold text-sd-primary">{{ $item }}</span>
                            @empty
                                <span class="rounded-full border border-sd-primary/15 bg-sd-soft/55 px-3 py-1.5 text-xs font-extrabold text-sd-primary">Konseling Individu</span>
                            @endforelse
                        </div>

                        <span class="mt-6 inline-flex min-h-11 items-center gap-2 rounded-full border border-sd-primary/20 px-4 text-sm font-extrabold text-sd-primary transition-colors group-hover:bg-sd-primary group-hover:text-sd-surface">
                            Lihat jadwal dan profil
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </span>
                    </div>
                </a>
            </article>
        @endforeach
    </div>
</section>
