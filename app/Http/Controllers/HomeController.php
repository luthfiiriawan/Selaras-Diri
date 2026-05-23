<?php

namespace App\Http\Controllers;

use App\Models\CounselingPackage;
use App\Models\Event;
use App\Models\Psychologist;
use App\Models\SiteSetting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Throwable;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('welcome', $this->viewData([
            'activeNav' => 'home',
            'pageTitle' => 'Ruang Bertumbuh dan Pulih',
        ]));
    }

    public function about()
    {
        $data = $this->viewData([
            'activeNav' => 'about',
            'pageTitle' => 'Tentang Selaras Diri',
            'pageEyebrow' => 'Tentang Selaras Diri',
            'pageHeading' => 'Tentang Selaras Diri',
            'pageBody' => 'Komunitas pengembangan diri yang berfokus pada mindfulness, kepercayaan diri, dan dukungan emosional.',
        ]);

        return view('pages.about', $data);
    }

    public function services()
    {
        $data = $this->viewData([
            'activeNav' => 'services',
            'pageTitle' => 'Layanan dan Pricelist',
            'pageEyebrow' => 'Layanan dan Pricelist',
            'pageHeading' => 'Pilih format pendampingan yang sesuai dengan kebutuhanmu.',
            'pageBody' => 'Detail layanan konseling, bundling, couple counseling, dan asesmen disusun mengikuti pricelist Selaras Diri.',
        ]);

        return view('pages.services', $data);
    }

    public function psychologistsPage()
    {
        $data = $this->viewData([
            'activeNav' => 'psychologists',
            'pageTitle' => 'Psikolog Selaras Diri',
            'pageEyebrow' => 'Psikolog',
            'pageHeading' => 'Tim pendamping untuk kebutuhan emosi, relasi, dan keluarga.',
            'pageBody' => 'Pilih psikolog berdasarkan fokus isu, lokasi, format sesi, dan biaya yang paling sesuai.',
        ]);

        return view('pages.psychologists', $data);
    }

    public function events()
    {
        $data = $this->viewData([
            'activeNav' => 'events',
            'pageTitle' => 'Event Selaras Diri',
            'pageEyebrow' => 'Event Rutin dan Bulanan',
            'pageHeading' => 'Aktivitas yang mempertemukan refleksi, tubuh, seni, dan komunitas.',
            'pageBody' => 'Lihat support group bulanan dan agenda wellness seperti trekking, art therapy, workshop, seminar, yoga, barre, dan padel.',
        ]);

        return view('pages.events', $data);
    }

    private function viewData(array $extra = []): array
    {
        $settings = $this->settings();
        $whatsappNumber = preg_replace('/\D+/', '', $settings['whatsapp_number'] ?? '6281234567890');
        $bookingMessage = rawurlencode($settings['booking_whatsapp_message'] ?? 'Halo Selaras Diri, saya ingin booked konseling. Mohon info jadwal yang tersedia.');
        $eventMessage = rawurlencode($settings['event_whatsapp_message'] ?? 'Halo Selaras Diri, saya ingin daftar event/support group bulan ini.');

        return array_merge([
            'settings' => $settings,
            'bookingUrl' => "https://wa.me/{$whatsappNumber}?text={$bookingMessage}",
            'eventUrl' => "https://wa.me/{$whatsappNumber}?text={$eventMessage}",
            'psychologists' => $this->psychologists(),
            'packages' => $this->packages(),
            'supportEvent' => $this->supportEvent(),
            'monthlyEvents' => $this->monthlyEvents(),
        ], $extra);
    }

    public static function defaultSettings(): array
    {
        return [
            'site_name' => 'Selaras Diri',
            'whatsapp_number' => '6282115724455',
            'contact_phone' => '+6282115724455',
            'instagram' => '@SELARAS_DIRI',
            'email' => 'selarasdiri99@gmail.com',
            'location' => 'Jabarano Laswi dan Cimahi',
            'hero_eyebrow' => 'Mindfulness, konseling psikolog, dan komunitas suportif',
            'hero_title' => 'Hadir penuh, pulih pelan-pelan, bertumbuh bersama.',
            'hero_subtitle' => 'Selaras Diri membantu teman selaras mengenali diri, mengelola emosi, dan menemukan dukungan melalui konseling, workshop, art therapy, dan sharing circle.',
            'about_title' => 'Tentang Selaras Diri',
            'about_heading' => 'Tentang Selaras Diri',
            'about_body' => 'Selaras Diri adalah sebuah komunitas pengembangan diri yang berfokus pada peningkatan kesadaran melalui pendekatan mindfulness, Kepercayaan diri individu, serta pengembangan jejaring dukungan emosional. Kami percaya bahwa hidup yang seimbang dan bermakna berawal dari kemampuan untuk hadir sepenuhnya dalam momen kini serta kepedulian terhadap kesehatan mental diri dan orang lain. Melalui berbagai workshop, pelatihan, dan ruang praktik bersama, Selaras Diri mengajak individu untuk mengenali diri, mengelola emosi dengan bijak, dan menjadi bagian dari komunitas yang saling mendukung.',
            'vision_title' => 'Visi',
            'vision_body' => 'Menjadi pribadi yang berfokus pada mindfulness, pengembangan diri, kreativitas, dan keseimbangan hidup.',
            'mission_title' => 'Misi',
            'mission_body' => "Menyelenggarakan workshop rutin seputar mindfulness, meditasi, Art Therapy, dan refleksi diri.\nMelatih dan membina peer konselor sebagai pendamping yang mampu memberikan dukungan emosional dasar di komunitasnya.\nMembentuk ruang aman (safe space) bagi peserta untuk berbagi pengalaman dan saling menguatkan.\nMenjalin kolaborasi dengan komunitas atau organisasi yang memiliki kesamaan nilai dan tujuan.",
            'booking_title' => 'Booked konseling dengan admin Tasya.',
            'booking_body' => 'Admin akan membantu memilih psikolog, format sesi online/offline/voice call, lokasi, jadwal, dan paket yang sesuai. Untuk kondisi darurat, segera hubungi layanan krisis atau fasilitas kesehatan terdekat.',
            'booking_whatsapp_message' => 'Halo Tasya, saya ingin booked konseling Selaras Diri. Mohon info jadwal psikolog yang tersedia.',
            'event_whatsapp_message' => 'Halo Tasya, saya ingin daftar event/support group Selaras Diri bulan ini.',
            'footer_tagline' => 'Ruang bertumbuh, pulih, dan kembali selaras.',
        ];
    }

    private function settings(): array
    {
        $settings = self::defaultSettings();

        if (! $this->tableReady('site_settings')) {
            return $settings;
        }

        try {
            return array_merge($settings, SiteSetting::query()->pluck('value', 'key')->all());
        } catch (Throwable) {
            return $settings;
        }
    }

    private function psychologists(): Collection
    {
        if ($this->tableReady('psychologists')) {
            try {
                $items = Psychologist::query()
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->orderBy('name')
                    ->get();

                if ($items->isNotEmpty()) {
                    return $items;
                }
            } catch (Throwable) {
                //
            }
        }

        return collect([
            [
                'name' => 'Sarah Dian S.Psi., M.Psi., Psikolog',
                'role' => 'Psikolog Klinis',
                'focus' => 'Pendamping untuk berbagai kebutuhan emosi, relasi, dan pemulihan diri dengan pendekatan integratif.',
                'specialization' => 'Kecemasan, Depresi, Stress, Trauma, Regulasi Emosi, Self Development, Relationship, Gangguan Kepribadian',
                'expertise' => 'CBT, ACT, Art Therapy, MBCT, Hypnotherapy, DBT',
                'schedule' => 'Jabarano Laswi',
                'price' => 'Offline Rp300.000 · Video Rp220.000 · Voice Rp170.000',
                'image_url' => '/images/psychologists/sarah-dian.png',
                'initials' => 'SD',
            ],
            [
                'name' => 'Marina Puspa Ningrum S.Psi., M.Psi., Psikolog',
                'role' => 'Psikolog Klinis',
                'focus' => 'Konseling untuk kebutuhan emosi, relasi, dan pengembangan diri di wilayah Cimahi.',
                'specialization' => 'Kecemasan, Depresi, Stress, Regulasi Emosi, Self Development, Relationship',
                'expertise' => 'CBT, ACT, Art Therapy',
                'schedule' => 'Cimahi',
                'price' => 'Offline Rp300.000 · Video Rp220.000 · Voice Rp170.000',
                'image_url' => '/images/psychologists/marina-puspa-ningrum.png',
                'initials' => 'MP',
            ],
            [
                'name' => 'Astrid Nur Alfaradais, S.Psi. M.Psi., Psikolog',
                'role' => 'Psikolog Klinis',
                'focus' => 'Pendamping untuk pemulihan kecemasan, stres, dan dinamika relasi dengan pendekatan group dan art therapy.',
                'specialization' => 'Kecemasan, Emosi, Stress, Self Development, Relationship, Gangguan Kepribadian',
                'expertise' => 'CBT, ACT, Art Therapy, Group Therapy',
                'schedule' => 'Jabarano Laswi',
                'price' => 'Offline Rp300.000 · Video Rp250.000 · Voice Rp200.000',
                'image_url' => null,
                'initials' => 'AN',
            ],
            [
                'name' => 'Adelia Octavia, S.Psi. M.Psi., Psikolog',
                'role' => 'Psikolog Klinis',
                'focus' => 'Konseling individual dan couple untuk kebutuhan emosi, relasi, serta pengembangan diri.',
                'specialization' => 'Kecemasan, Stress, Regulasi Emosi, Self Development, Relationship',
                'expertise' => 'CBT, ACT, Art Therapy',
                'schedule' => 'Jabarano Laswi',
                'price' => 'Offline Rp300.000 · Video Rp250.000 · Voice Rp200.000',
                'image_url' => '/images/psychologists/adelia-octavia.png',
                'initials' => 'AO',
            ],
            [
                'name' => 'Alinda Destiana S.Psi., M.Psi., Psikolog',
                'role' => 'Psikolog Anak & Remaja',
                'focus' => 'Mendampingi permasalahan emosi, sosial, dan klinis anak/remaja serta diskusi pola pengasuhan keluarga.',
                'specialization' => 'Emosi Anak & Remaja, Sosial Anak, Relasi Anak-Orang Tua, Asesmen Kesiapan Sekolah, Klinis Anak, Pola Pengasuhan',
                'expertise' => 'Psikoterapi, Pendekatan Montessori, Terapi Keluarga, Behavior Modification',
                'schedule' => 'Jabarano Laswi',
                'price' => 'Offline Rp300.000 · Video Rp250.000 · Voice Rp200.000',
                'image_url' => '/images/psychologists/alinda-destiana.png',
                'initials' => 'AD',
            ],
            [
                'name' => 'Cinta Retsa Ferdiana, S.Psi. M.Psi., Psikolog',
                'role' => 'Psikolog Klinis',
                'focus' => 'Pendamping online untuk kebutuhan relasi, self growth, parenting, dan pemulihan emosi.',
                'specialization' => 'Relationship, Hubungan Personal/Interpersonal, Kecemasan, Depresi, Regulasi Emosi, Self Growth, Self-Love, Self-Harm, Parenting & Keluarga',
                'expertise' => 'CBT, Empathic Love Therapy (ELT), Art Therapy, MBCT, DBT',
                'schedule' => 'Online',
                'price' => 'Video Rp220.000 · Voice Rp170.000',
                'image_url' => null,
                'initials' => 'CR',
            ],
        ]);
    }

    private function packages(): Collection
    {
        if ($this->tableReady('counseling_packages')) {
            try {
                $items = CounselingPackage::query()
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->orderBy('title')
                    ->get();

                if ($items->isNotEmpty()) {
                    return $items;
                }
            } catch (Throwable) {
                //
            }
        }

        return collect([
            [
                'title' => 'Konseling Offline',
                'description' => 'Sesi tatap muka dengan psikolog di lokasi Selaras Diri untuk membahas emosi, relasi, stres, dan kebutuhan personal.',
                'duration' => '1 jam',
                'price' => 'Rp300.000',
            ],
            [
                'title' => 'Online Video Call - Sarah, Marina, Cinta',
                'description' => 'Sesi konseling online melalui video call bersama Sarah Dian, Marina Puspa Ningrum, atau Cinta Retsa Ferdiana.',
                'duration' => '1 jam',
                'price' => 'Rp220.000',
            ],
            [
                'title' => 'Online Video Call - Astrid, Adelia, Alinda',
                'description' => 'Sesi konseling online melalui video call bersama Astrid Nur Alfaradais, Adelia Octavia, atau Alinda Destiana.',
                'duration' => '1 jam',
                'price' => 'Rp250.000',
            ],
            [
                'title' => 'Online Voice Call - Sarah, Marina, Cinta',
                'description' => 'Konseling via panggilan suara untuk proses yang lebih ringan dan privat bersama Sarah, Marina, atau Cinta.',
                'duration' => '1 jam',
                'price' => 'Rp170.000',
            ],
            [
                'title' => 'Online Voice Call - Astrid, Adelia, Alinda',
                'description' => 'Konseling via panggilan suara untuk proses yang lebih ringan dan privat bersama Astrid, Adelia, atau Alinda.',
                'duration' => '1 jam',
                'price' => 'Rp200.000',
            ],
            [
                'title' => 'Bundling Offline',
                'description' => 'Paket tiga kali konseling tatap muka untuk proses pendampingan yang lebih berkelanjutan.',
                'duration' => '3x pertemuan',
                'price' => 'Rp850.000',
            ],
            [
                'title' => 'Bundling Online Video Call - Sarah, Marina, Cinta',
                'description' => 'Paket tiga kali konseling online melalui video call bersama Sarah, Marina, atau Cinta.',
                'duration' => '3x pertemuan',
                'price' => 'Rp610.000',
            ],
            [
                'title' => 'Bundling Online Video Call - Astrid, Adelia, Alinda',
                'description' => 'Paket tiga kali konseling online melalui video call bersama Astrid, Adelia, atau Alinda.',
                'duration' => '3x pertemuan',
                'price' => 'Rp700.000',
            ],
            [
                'title' => 'Couple Offline - Sarah atau Marina',
                'description' => 'Sesi pasangan secara tatap muka untuk memahami dinamika relasi, konflik, dan komunikasi.',
                'duration' => '2 jam',
                'price' => 'Rp600.000',
            ],
            [
                'title' => 'Couple Offline - Astrid, Adelia, Alinda',
                'description' => 'Sesi pasangan secara tatap muka untuk memahami dinamika relasi, konflik, dan komunikasi.',
                'duration' => '2 jam',
                'price' => 'Rp700.000',
            ],
            [
                'title' => 'Couple Online Video Call - Sarah, Marina, Cinta',
                'description' => 'Konseling pasangan secara online melalui video call bersama Sarah, Marina, atau Cinta.',
                'duration' => '2 jam',
                'price' => 'Rp440.000',
            ],
            [
                'title' => 'Couple Online Video Call - Astrid, Adelia, Alinda',
                'description' => 'Konseling pasangan secara online melalui video call bersama Astrid, Adelia, atau Alinda.',
                'duration' => '2 jam',
                'price' => 'Rp500.000',
            ],
            [
                'title' => 'Test IQ Tanpa Konsultasi',
                'description' => 'Asesmen kemampuan intelektual tanpa sesi konsultasi lanjutan.',
                'duration' => 'Assessment',
                'price' => 'Rp120.000',
            ],
            [
                'title' => 'Test IQ Dengan Konsultasi',
                'description' => 'Asesmen kemampuan intelektual disertai sesi konsultasi hasil.',
                'duration' => 'Assessment',
                'price' => 'Rp220.000',
            ],
            [
                'title' => 'Test Minat dan Bakat',
                'description' => 'Asesmen minat bakat menggunakan grafis test, RMIB, multiple intelligences, dan gaya belajar.',
                'duration' => 'Assessment',
                'price' => 'Rp450.000',
            ],
            [
                'title' => 'Test IQ dan Minat Bakat',
                'description' => 'Paket asesmen lengkap untuk memahami kemampuan intelektual, minat, bakat, dan gaya belajar.',
                'duration' => 'Assessment',
                'price' => 'Rp850.000',
            ],
        ]);
    }

    private function supportEvent(): array|Event
    {
        if ($this->tableReady('events')) {
            try {
                $event = Event::query()
                    ->where('type', 'support_group')
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->first();

                if ($event) {
                    return $event;
                }
            } catch (Throwable) {
                //
            }
        }

        return [
            'title' => 'Support Group Bulanan',
            'description' => 'Sebuah ruang aman untuk saling mendengar dan menguatkan. Dipandu fasilitator atau psikolog, peserta dapat berbagi pengalaman, menemukan perspektif baru, dan mendapat dukungan karena perjalanan pulih lebih ringan saat ditempuh bersama.',
            'schedule' => 'Awal bulan, kuota terbatas',
            'image_url' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=900&q=80',
            'booking_message' => 'Daftar Support Group',
        ];
    }

    private function monthlyEvents(): Collection
    {
        if ($this->tableReady('events')) {
            try {
                $items = Event::query()
                    ->where('type', 'monthly')
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->orderBy('title')
                    ->get();

                if ($items->isNotEmpty()) {
                    return $items;
                }
            } catch (Throwable) {
                //
            }
        }

        return collect([
            [
                'title' => 'Trekking Meditasi & Coffee Tour',
                'description' => 'Menyegarkan pikiran lewat alam terbuka, latihan mindful walking, meditasi, dan menikmati momen bersama komunitas positif.',
                'schedule' => 'Bulanan',
                'image_url' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Art Therapy',
                'description' => 'Mengekspresikan diri lewat karya seni, melepas stres, dan menenangkan pikiran bersama fasilitator.',
                'schedule' => 'Bulanan',
                'image_url' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Workshop Mindfulness & Self-Awareness',
                'description' => 'Experiential learning untuk melatih kehadiran penuh, pengenalan emosi, dan teknik pengelolaan stres.',
                'schedule' => 'Bulanan',
                'image_url' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Seminar & Webinar Psikoedukasi',
                'description' => 'Seminar dan webinar bersama praktisi untuk memperluas literasi kesehatan mental yang mudah diterapkan sehari-hari.',
                'schedule' => 'Bulanan',
                'image_url' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Barre, Yoga, dan Padel Session',
                'description' => 'Aktivitas tubuh yang menyatukan gerak, ritme, dan komunitas lewat barre, yoga, dan padel untuk menjaga keseimbangan tubuh dan pikiran.',
                'schedule' => 'Bulanan',
                'image_url' => 'https://images.unsplash.com/photo-1599901860904-17e6ed7083a0?auto=format&fit=crop&w=900&q=80',
            ],
        ]);
    }

    private function tableReady(string $table): bool
    {
        try {
            return Schema::hasTable($table);
        } catch (Throwable) {
            return false;
        }
    }
}
