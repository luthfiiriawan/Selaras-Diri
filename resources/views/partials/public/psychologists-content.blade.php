<section class="mx-auto w-[min(1160px,calc(100%-48px))] pb-24 reveal" id="psikolog">
    <div class="mb-8 grid items-start gap-11 lg:grid-cols-[minmax(160px,0.42fr)_minmax(0,1fr)]">
        <p class="eyebrow">Psikolog</p>
        <h2 class="text-5xl leading-[1.08]">Tim pendamping untuk kebutuhan emosi, relasi, dan keluarga.</h2>
    </div>

    <div class="grid gap-4 reveal-group md:grid-cols-2 xl:grid-cols-3">
        @foreach ($psychologists as $psychologist)
            <article class="reveal overflow-hidden rounded-lg border border-sd-ink/10 bg-sd-surface shadow-sd-sm transition duration-200 hover:-translate-y-1 hover:shadow-sd-md">
                @if (data_get($psychologist, 'image_url'))
                    <img class="aspect-[4/5] h-auto w-full object-cover" src="{{ data_get($psychologist, 'image_url') }}" alt="{{ data_get($psychologist, 'name') }}" loading="lazy">
                @else
                    <div class="grid aspect-[4/5] h-auto w-full place-items-center bg-gradient-to-br from-sd-primary via-sd-teal to-sd-rose text-[3.4rem] font-extrabold text-sd-surface">{{ data_get($psychologist, 'initials') ?: 'SD' }}</div>
                @endif
                <div class="p-6">
                    <span class="block text-xs font-extrabold uppercase text-sd-rose">{{ data_get($psychologist, 'role') }}</span>
                    <h3 class="mt-4 mb-3 text-xl leading-tight">{{ data_get($psychologist, 'name') }}</h3>
                    <p class="text-sd-muted leading-[1.72]">{{ data_get($psychologist, 'focus') }}</p>
                    <dl class="mt-6 grid gap-3.5">
                        <div>
                            <dt class="text-xs font-extrabold uppercase text-sd-muted">Jadwal</dt>
                            <dd class="mt-1 font-extrabold text-sd-ink">{{ data_get($psychologist, 'schedule') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-extrabold uppercase text-sd-muted">Biaya</dt>
                            <dd class="mt-1 font-extrabold text-sd-ink">{{ data_get($psychologist, 'price') }}</dd>
                        </div>
                    </dl>
                </div>
            </article>
        @endforeach
    </div>
</section>
