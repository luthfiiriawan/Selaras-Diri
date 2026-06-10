{{-- Support group --}}
<section class="mx-auto grid w-[min(1160px,calc(100%-48px))] items-center gap-9 py-24 reveal-group lg:grid-cols-[minmax(320px,0.82fr)_minmax(0,1fr)]">
    <div class="reveal">
        <img class="aspect-[4/5] w-full rounded-lg object-cover shadow-sd-md" src="{{ data_get($supportEvent, 'image_url') }}" alt="{{ data_get($supportEvent, 'title') }}" loading="lazy">
    </div>
    <div class="py-5 reveal">
        <p class="eyebrow">Event Rutin</p>
        <h2 class="text-5xl leading-[1.08]">{{ data_get($supportEvent, 'title') }}</h2>
        <p class="mt-4 max-w-[660px] text-sd-muted leading-[1.72]">{{ data_get($supportEvent, 'description') }}</p>
        <div class="my-6 rounded-lg border border-sd-ink/10 border-l-4 border-l-sd-gold bg-sd-surface p-5">
            <span class="block text-xs font-extrabold uppercase text-sd-rose">Jadwal</span>
            <strong class="mt-2 block text-xl">{{ data_get($supportEvent, 'schedule') }}</strong>
        </div>
        <a class="btn btn-soft" href="{{ $eventUrl }}" target="_blank" rel="noopener">Booked Support Group</a>
    </div>
</section>

{{-- Event bulanan --}}
<section class="mx-auto w-[min(1160px,calc(100%-48px))] pb-24 reveal" id="event">
    <div class="mb-8 grid items-start gap-11 lg:grid-cols-[minmax(160px,0.42fr)_minmax(0,1fr)]">
        <p class="eyebrow">Event Bulanan</p>
        <h2 class="text-5xl leading-[1.08]">Aktivitas yang mempertemukan refleksi, tubuh, seni, dan komunitas.</h2>
    </div>

    <div class="grid gap-4 reveal-group md:grid-cols-2 xl:grid-cols-5">
        @foreach ($monthlyEvents as $event)
            <article class="reveal overflow-hidden rounded-lg border border-sd-ink/10 bg-sd-surface shadow-sd-sm transition duration-200 hover:-translate-y-1 hover:shadow-sd-md">
                @if (data_get($event, 'image_url'))
                    <img class="h-52 w-full object-cover" src="{{ data_get($event, 'image_url') }}" alt="{{ data_get($event, 'title') }}" loading="lazy">
                @endif
                <div class="p-5">
                    <span class="block text-xs font-extrabold uppercase text-sd-rose">{{ data_get($event, 'schedule') }}</span>
                    <h3 class="mt-4 mb-3 text-xl leading-tight">{{ data_get($event, 'title') }}</h3>
                    <p class="text-sd-muted leading-[1.72]">{{ data_get($event, 'description') }}</p>
                    <a class="mt-4 inline-flex items-center font-extrabold text-sd-primary transition-colors hover:text-sd-rose" href="{{ $eventUrl }}" target="_blank" rel="noopener">Daftar via WhatsApp</a>
                </div>
            </article>
        @endforeach
    </div>
</section>
