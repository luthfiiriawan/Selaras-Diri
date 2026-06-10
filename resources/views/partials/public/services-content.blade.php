<section class="mx-auto w-[min(1160px,calc(100%-48px))] pb-16 reveal sm:pb-24" id="layanan">
    <div class="mb-8 grid items-start gap-11 lg:grid-cols-[minmax(160px,0.42fr)_minmax(0,1fr)]">
        <p class="eyebrow">Layanan dan Pricelist</p>
        <h2 class="text-3xl leading-[1.12] sm:text-4xl lg:text-5xl lg:leading-[1.08]">Pilih bentuk pendampingan yang paling sesuai untuk langkah pertama.</h2>
    </div>

    <div class="grid gap-4 reveal-group md:grid-cols-2 xl:grid-cols-3">
        @foreach ($packages as $package)
            <article class="reveal flex min-h-64 flex-col rounded-lg border border-sd-ink/10 bg-sd-surface p-6 shadow-sd-sm transition duration-200 hover:-translate-y-1 hover:shadow-sd-md">
                <span class="block text-xs font-extrabold uppercase text-sd-rose">{{ data_get($package, 'duration') ?: 'Sesi' }}</span>
                <h3 class="mt-4 mb-3 text-[1.08rem] leading-tight">{{ data_get($package, 'title') }}</h3>
                <p class="text-sd-muted leading-[1.72]">{{ data_get($package, 'description') }}</p>
                <strong class="mt-auto pt-6 text-[1.4rem] text-sd-primary">{{ data_get($package, 'price') }}</strong>
            </article>
        @endforeach
    </div>
</section>
