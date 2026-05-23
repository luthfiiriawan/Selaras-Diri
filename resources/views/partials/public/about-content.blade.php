@php
    $missionItems = array_values(array_filter(array_map('trim', preg_split('/\R/', $settings['mission_body'] ?? ''))));
@endphp

<section class="section about-detail reveal" id="tentang">
    <div class="about-copy">
        <p class="eyebrow">Tentang Selaras Diri</p>
        <h1>{{ $settings['about_title'] }}</h1>
        <p>{{ $settings['about_body'] }}</p>
    </div>
</section>

<section class="section manifesto about-manifesto reveal-group">
    <article class="reveal">
        <p class="eyebrow">{{ $settings['vision_title'] }}</p>
        <h2>{{ $settings['vision_body'] }}</h2>
    </article>
    <article class="mission-card reveal">
        <p class="eyebrow">{{ $settings['mission_title'] }}</p>
        <ul class="mission-list">
            @foreach ($missionItems as $missionItem)
                <li>{{ $missionItem }}</li>
            @endforeach
        </ul>
    </article>
</section>
