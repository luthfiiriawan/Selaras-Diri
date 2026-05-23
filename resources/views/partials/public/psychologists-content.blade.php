<section class="section psychologist-section reveal" id="psikolog">
    <div class="section-heading">
        <p class="eyebrow">Psikolog</p>
        <h2>Tim pendamping untuk kebutuhan emosi, relasi, dan keluarga.</h2>
    </div>

    <div class="psychologist-grid reveal-group">
        @foreach ($psychologists as $psychologist)
            <article class="profile-card reveal">
                @if (data_get($psychologist, 'image_url'))
                    <img src="{{ data_get($psychologist, 'image_url') }}" alt="{{ data_get($psychologist, 'name') }}" loading="lazy">
                @else
                    <div class="profile-initial">{{ data_get($psychologist, 'initials') ?: 'SD' }}</div>
                @endif
                <div>
                    <span>{{ data_get($psychologist, 'role') }}</span>
                    <h3>{{ data_get($psychologist, 'name') }}</h3>
                    <p>{{ data_get($psychologist, 'focus') }}</p>
                    <dl>
                        <div>
                            <dt>Jadwal</dt>
                            <dd>{{ data_get($psychologist, 'schedule') }}</dd>
                        </div>
                        <div>
                            <dt>Biaya</dt>
                            <dd>{{ data_get($psychologist, 'price') }}</dd>
                        </div>
                    </dl>
                </div>
            </article>
        @endforeach
    </div>
</section>
