<section class="mx-auto w-[min(1160px,calc(100%-48px))] pb-24 reveal" id="booking">
    <div class="grid items-center gap-8 rounded-lg border border-sd-ink/10 bg-gradient-to-br from-sd-surface to-[#fde2db] p-6 shadow-sd-sm sm:p-9 lg:grid-cols-[minmax(0,1fr)_auto]">
        <div>
            <p class="eyebrow">Booked Konseling</p>
            <h2 class="text-3xl leading-[1.12] sm:text-4xl lg:text-5xl lg:leading-[1.08]">{{ $settings['booking_title'] }}</h2>
            <p class="mt-4 text-sd-muted leading-[1.72]">{{ $settings['booking_body'] }}</p>
        </div>
        <a class="btn btn-primary" href="{{ $bookingUrl }}" target="_blank" rel="noopener">Chat Admin WhatsApp</a>
    </div>
</section>
