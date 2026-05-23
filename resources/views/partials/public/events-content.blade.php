<section class="section support-section reveal-group">
    <div class="support-image reveal">
        <img src="{{ data_get($supportEvent, 'image_url') }}" alt="{{ data_get($supportEvent, 'title') }}" loading="lazy">
    </div>
    <div class="support-copy reveal">
        <p class="eyebrow">Event Rutin</p>
        <h2>{{ data_get($supportEvent, 'title') }}</h2>
        <p>{{ data_get($supportEvent, 'description') }}</p>
        <div class="support-schedule">
            <span>Jadwal</span>
            <strong>{{ data_get($supportEvent, 'schedule') }}</strong>
        </div>
        <a class="button button-soft" href="{{ $eventUrl }}" target="_blank" rel="noopener">Booked Support Group</a>
    </div>
</section>

<section class="section events-section reveal" id="event">
    <div class="section-heading">
        <p class="eyebrow">Event Bulanan</p>
        <h2>Aktivitas yang mempertemukan refleksi, tubuh, seni, dan komunitas.</h2>
    </div>

    <div class="event-grid reveal-group">
        @foreach ($monthlyEvents as $event)
            <article class="event-card reveal">
                <img src="{{ data_get($event, 'image_url') }}" alt="{{ data_get($event, 'title') }}" loading="lazy">
                <div>
                    <span>{{ data_get($event, 'schedule') }}</span>
                    <h3>{{ data_get($event, 'title') }}</h3>
                    <p>{{ data_get($event, 'description') }}</p>
                    <a href="{{ $eventUrl }}" target="_blank" rel="noopener">Daftar via WhatsApp</a>
                </div>
            </article>
        @endforeach
    </div>
</section>
