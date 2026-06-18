@php
    $missionItems = array_values(array_filter(array_map('trim', preg_split('/\R/', $settings['mission_body'] ?? ''))));
@endphp

<section class="mx-auto block w-[min(1160px,calc(100%-48px))] pt-16 reveal" id="tentang">
    <div class="mx-auto max-w-[920px]">
        <p class="eyebrow">Tentang Selaras Diri</p>
        <h1 class="mb-0 max-w-[720px] text-3xl leading-[1.12] sm:text-4xl lg:text-5xl lg:leading-[1.08]">{{ $settings['about_title'] }}</h1>
        <p class="mt-6 text-[1.08rem] leading-[1.72] text-sd-muted">{{ $settings['about_body'] }}</p>
    </div>
</section>

<section class="mx-auto grid w-[min(1160px,calc(100%-48px))] items-center gap-8 py-14 reveal-group sm:py-20 lg:grid-cols-[minmax(0,0.9fr)_minmax(0,1.1fr)] lg:gap-14">
    <div class="max-w-[560px] reveal">
        <p class="eyebrow">{{ $settings['founders_eyebrow'] }}</p>
        <h2 class="mt-3 max-w-[520px] text-3xl leading-[1.12] sm:text-4xl lg:text-[3rem] lg:leading-[1.05]">{{ $settings['founders_title'] }}</h2>
        <p class="mt-5 text-[1.04rem] leading-[1.75] text-sd-muted">{{ $settings['founders_body'] }}</p>
    </div>
    <figure class="relative reveal">
        <div class="absolute -inset-4 -z-10 rounded-lg bg-sd-rose/10"></div>
        <picture>
            <source srcset="/images/about/tim-pendiri-selaras-diri.webp" type="image/webp">
            <img class="aspect-[1.52/1] w-full rounded-lg border border-sd-ink/10 object-cover object-center shadow-sd-md" src="/images/about/tim-pendiri-selaras-diri.jpg" width="1200" height="791" alt="Tim yang membangun Selaras Diri" loading="lazy">
        </picture>
        <figcaption class="mt-4 max-w-[620px] text-sm font-semibold leading-relaxed text-sd-muted">{{ $settings['founders_caption'] }}</figcaption>
    </figure>
</section>

<section class="mx-auto grid w-[min(1160px,calc(100%-48px))] gap-4 py-14 reveal-group sm:py-24 lg:grid-cols-[minmax(0,0.82fr)_minmax(0,1.18fr)]">
    <article class="rounded-lg border border-sd-ink/10 bg-sd-primary p-8 text-sd-surface reveal">
        <p class="block text-xs font-extrabold uppercase text-[#ffd0c8]">{{ $settings['vision_title'] }}</p>
        <h2 class="mt-2 text-2xl leading-[1.15] sm:text-3xl lg:text-4xl">{{ $settings['vision_body'] }}</h2>
    </article>
    <article class="rounded-lg border border-sd-ink/10 bg-sd-surface p-8 reveal">
        <p class="eyebrow">{{ $settings['mission_title'] }}</p>
        <ul class="grid gap-4 leading-[1.72] text-sd-muted">
            @foreach ($missionItems as $missionItem)
                <li class="relative pl-6 before:absolute before:left-0 before:top-3 before:h-2 before:w-2 before:rounded-full before:bg-sd-rose before:content-['']">{{ $missionItem }}</li>
            @endforeach
        </ul>
    </article>
</section>
