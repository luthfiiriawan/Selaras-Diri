<section class="section services reveal" id="layanan">
    <div class="section-heading">
        <p class="eyebrow">Layanan dan Pricelist</p>
        <h2>Pilih bentuk pendampingan yang paling sesuai untuk langkah pertama.</h2>
    </div>

    <div class="package-grid reveal-group">
        @foreach ($packages as $package)
            <article class="package-card reveal">
                <span>{{ data_get($package, 'duration') ?: 'Sesi' }}</span>
                <h3>{{ data_get($package, 'title') }}</h3>
                <p>{{ data_get($package, 'description') }}</p>
                <strong>{{ data_get($package, 'price') }}</strong>
            </article>
        @endforeach
    </div>

    <div class="price-gallery-shell reveal-group" aria-label="Pricelist psikolog Selaras Diri dari Canva">
        <div class="price-gallery-copy reveal">
            <p class="eyebrow">Pricelist Visual</p>
            <h3>Rincian per psikolog dari materi Canva.</h3>
            <p>Gambar ini dipakai sebagai sumber visual agar nama psikolog, format sesi, dan biaya layanan tetap selaras dengan materi resmi Selaras Diri.</p>
        </div>

        <div class="pricing-gallery">
            @foreach ($psychologists as $psychologist)
                @if (data_get($psychologist, 'image_url'))
                    <figure class="pricing-preview reveal">
                        <img src="{{ data_get($psychologist, 'image_url') }}" alt="Pricelist Canva {{ data_get($psychologist, 'name') }}" loading="lazy">
                        <figcaption>{{ data_get($psychologist, 'name') }}</figcaption>
                    </figure>
                @endif
            @endforeach
        </div>
    </div>
</section>
