@extends('layouts.public')

@php
    $currentAnswers = old('answers', $answers ?? []);
@endphp

@section('content')
    <section class="mx-auto grid w-[min(1160px,calc(100%-48px))] gap-8 py-14 reveal-now sm:py-20 lg:grid-cols-[minmax(0,0.9fr)_minmax(320px,0.55fr)]">
        <div>
            <p class="eyebrow">Cek Kebutuhan</p>
            <h1 class="max-w-[820px] font-serif text-[2.2rem] leading-[1.1] sm:text-4xl lg:text-[3.8rem] lg:leading-[1.04]">Temukan rekomendasi layanan yang paling dekat dengan kebutuhanmu.</h1>
            <p class="mt-5 max-w-[720px] text-[1.08rem] leading-[1.72] text-sd-muted">Jawab 5 pertanyaan singkat. Sistem akan mencocokkan jawabanmu dengan spesialisasi dan metode psikolog yang dikelola oleh admin Selaras Diri.</p>
        </div>

        <aside class="h-fit rounded-lg border border-sd-ink/10 bg-sd-surface p-6 shadow-sd-sm">
            <span class="block text-xs font-extrabold uppercase text-sd-rose">AI Recommender</span>
            <p class="mt-3 text-sm font-bold leading-[1.7] text-sd-ink-soft">Rekomendasi dibuat dari pencocokan tag kebutuhan, spesialisasi psikolog, dan semantic mapping metode seperti CBT, ACT, Art Therapy, dan Group Therapy.</p>
        </aside>
    </section>

    <section class="border-y border-sd-ink/10 bg-sd-surface">
        <div class="mx-auto grid w-[min(1160px,calc(100%-48px))] gap-8 py-14 lg:grid-cols-[minmax(0,0.78fr)_minmax(320px,0.48fr)]">
            <form action="{{ route('recommendation.quiz.submit') }}" method="POST" class="grid gap-5">
                @csrf

                @foreach ($questions as $key => $question)
                    <fieldset class="rounded-lg border border-sd-ink/10 bg-sd-paper/50 p-5 shadow-sd-sm">
                        <legend class="px-1 text-sm font-extrabold text-sd-ink">{{ $loop->iteration }}. {{ $question['label'] }}</legend>

                        @if (($question['type'] ?? 'choice') === 'scale')
                            <div class="mt-5 grid gap-3 sm:grid-cols-5">
                                @for ($value = 1; $value <= 5; $value++)
                                    <label class="flex min-h-14 cursor-pointer items-center justify-center rounded-lg border border-sd-ink/10 bg-sd-surface px-3 text-center text-sm font-extrabold text-sd-ink-soft transition hover:border-sd-primary/30 hover:text-sd-primary has-[:checked]:border-sd-primary has-[:checked]:bg-sd-soft has-[:checked]:text-sd-primary">
                                        <input class="sr-only" type="radio" name="answers[{{ $key }}]" value="{{ $value }}" @checked((string) ($currentAnswers[$key] ?? '') === (string) $value)>
                                        {{ $value }}
                                    </label>
                                @endfor
                            </div>
                            <div class="mt-2 flex justify-between text-xs font-bold text-sd-muted">
                                <span>{{ $question['low_label'] }}</span>
                                <span>{{ $question['high_label'] }}</span>
                            </div>
                        @else
                            <div class="mt-5 grid gap-3 md:grid-cols-2">
                                @foreach ($question['options'] as $optionKey => $option)
                                    <label class="flex min-h-14 cursor-pointer items-center rounded-lg border border-sd-ink/10 bg-sd-surface px-4 py-3 text-sm font-extrabold text-sd-ink-soft transition hover:border-sd-primary/30 hover:text-sd-primary has-[:checked]:border-sd-primary has-[:checked]:bg-sd-soft has-[:checked]:text-sd-primary">
                                        <input class="sr-only" type="radio" name="answers[{{ $key }}]" value="{{ $optionKey }}" @checked(($currentAnswers[$key] ?? '') === $optionKey)>
                                        {{ $option['label'] }}
                                    </label>
                                @endforeach
                            </div>
                        @endif

                        @error("answers.{$key}")
                            <p class="mt-3 text-sm font-bold text-sd-danger">Pertanyaan ini wajib dijawab.</p>
                        @enderror
                    </fieldset>
                @endforeach

                <div class="flex flex-wrap items-center gap-3">
                    <button class="btn btn-primary" type="submit">Lihat Rekomendasi</button>
                    <a class="btn btn-soft" href="{{ route('services') }}">Lihat Layanan Dulu</a>
                </div>
            </form>

            <aside class="h-fit rounded-lg border border-sd-ink/10 bg-sd-paper p-6 shadow-sd-sm lg:sticky lg:top-28">
                <p class="eyebrow">Catatan</p>
                <h2 class="text-2xl leading-tight">Hasil kuis bukan diagnosis.</h2>
                <p class="mt-4 text-sm leading-[1.7] text-sd-muted">Fitur ini hanya membantu memilih langkah awal. Untuk kondisi darurat atau risiko membahayakan diri, segera hubungi layanan krisis atau fasilitas kesehatan terdekat.</p>
            </aside>
        </div>
    </section>

    @isset($result)
        @php
            $resultTags = collect($result['tags'] ?? []);
            $recommendedPsychologists = collect($result['psychologists'] ?? []);
            $whatsappNumber = preg_replace('/\D+/', '', $settings['whatsapp_number'] ?? '6282115724455');
        @endphp

        <section class="mx-auto w-[min(1160px,calc(100%-48px))] py-14 reveal sm:py-20" id="hasil-rekomendasi">
            <div class="grid gap-5 lg:grid-cols-[minmax(0,0.78fr)_minmax(280px,0.42fr)]">
                <article class="rounded-lg border border-sd-primary/15 bg-sd-soft/55 p-6 shadow-sd-sm lg:p-8">
                    <p class="eyebrow">Hasil Rekomendasi</p>
                    <h2 class="text-3xl leading-[1.12] sm:text-4xl">{{ $result['service']['title'] }}</h2>
                    <p class="mt-4 max-w-[760px] leading-[1.72] text-sd-ink-soft">{{ $result['service']['description'] }}</p>

                    @if ($resultTags->isNotEmpty())
                        <div class="mt-6 flex flex-wrap gap-2">
                            @foreach ($resultTags as $tag)
                                <span class="rounded-full bg-sd-surface px-3 py-1.5 text-sm font-extrabold text-sd-primary shadow-[inset_0_0_0_1px_rgba(35,24,23,0.08)]">{{ \Illuminate\Support\Str::of($tag)->replace('_', ' ')->title() }}</span>
                            @endforeach
                        </div>
                    @endif
                </article>

                <article class="rounded-lg border border-sd-ink/10 bg-sd-surface p-6 shadow-sd-sm">
                    <h3 class="text-sm font-extrabold uppercase text-sd-rose">Langkah berikutnya</h3>
                    <p class="mt-3 text-sm leading-[1.7] text-sd-muted">Admin dapat membantu memastikan jadwal, format sesi, dan psikolog yang paling sesuai.</p>
                    <a class="btn btn-primary mt-5 w-full" href="{{ $bookingUrl }}" target="_blank" rel="noopener">Chat Admin WhatsApp</a>
                </article>
            </div>

            <div class="mt-10">
                <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <p class="eyebrow">Psikolog yang relevan</p>
                        <h2 class="text-3xl leading-[1.12] sm:text-4xl">Rekomendasi berdasarkan kecocokan profil.</h2>
                    </div>
                    <a class="btn btn-soft" href="{{ route('psychologists') }}">Lihat semua psikolog</a>
                </div>

                @if ($recommendedPsychologists->isNotEmpty())
                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        @foreach ($recommendedPsychologists as $recommendation)
                            @php
                                $psychologist = $recommendation['psychologist'];
                                $bookingMessage = rawurlencode("Hi kak, saya ingin booking untuk psikolog {$psychologist->name}. Saya mendapat rekomendasi dari kuis Selaras Diri.");
                                $psychologistBookingUrl = "https://api.whatsapp.com/send?phone={$whatsappNumber}&text={$bookingMessage}&type=phone_number&app_absent=0";
                            @endphp

                            <article class="overflow-hidden rounded-lg border border-sd-ink/10 bg-sd-surface shadow-sd-sm">
                                @if ($psychologist->image_url)
                                    <img class="aspect-[4/5] w-full object-cover object-top" src="{{ $psychologist->image_url }}" alt="{{ $psychologist->name }}" loading="lazy">
                                @else
                                    <div class="grid aspect-[4/5] w-full place-items-center bg-gradient-to-br from-sd-primary via-sd-teal to-sd-rose text-[3.4rem] font-extrabold text-sd-surface">{{ $psychologist->initials }}</div>
                                @endif

                                <div class="p-6">
                                    <span class="block text-xs font-extrabold uppercase text-sd-rose">{{ $psychologist->role }}</span>
                                    <h3 class="mt-3 text-xl leading-tight">{{ $psychologist->name }}</h3>
                                    <p class="mt-3 text-sm leading-[1.65] text-sd-muted">{{ $recommendation['reason'] }}</p>

                                    @if (collect($recommendation['matched_tags'])->isNotEmpty())
                                        <div class="mt-4 flex flex-wrap gap-2">
                                            @foreach ($recommendation['matched_tags'] as $tag)
                                                <span class="rounded-full border border-sd-primary/15 bg-sd-soft/55 px-3 py-1.5 text-xs font-extrabold text-sd-primary">{{ $tag }}</span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="mt-5 flex flex-wrap gap-2">
                                        <a class="btn btn-soft" href="{{ route('psychologists.show', ['psychologist' => $psychologist->id, 'slug' => \Illuminate\Support\Str::slug($psychologist->name)]) }}">Lihat Profil</a>
                                        <a class="btn btn-primary" href="{{ $psychologistBookingUrl }}" target="_blank" rel="noopener">Booking</a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-lg border border-sd-ink/10 bg-sd-surface p-8 text-center shadow-sd-sm">
                        <h3 class="text-2xl">Belum ada psikolog yang cocok dari data aktif.</h3>
                        <p class="mx-auto mt-3 max-w-[620px] text-sm leading-[1.7] text-sd-muted">Admin masih bisa membantu memilih layanan yang sesuai. Kamu juga bisa membuka halaman psikolog untuk melihat semua profil yang tersedia.</p>
                    </div>
                @endif
            </div>
        </section>
    @endisset
@endsection
