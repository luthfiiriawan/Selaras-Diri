<?php

namespace Database\Seeders;

use App\Http\Controllers\HomeController;
use App\Models\CounselingPackage;
use App\Models\Event;
use App\Models\Psychologist;
use App\Models\SiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        foreach (HomeController::defaultSettings() as $key => $value) {
            SiteSetting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => str_contains($key, 'whatsapp') ? 'contact' : 'content']
            );
        }

        Psychologist::query()->delete();
        CounselingPackage::query()->delete();
        Event::query()->delete();

        $psychologists = [
            [
                'name' => 'Sarah Dian S.Psi., M.Psi., Psikolog',
                'role' => 'Psikolog Klinis',
                'focus' => 'Kecemasan, depresi, stres, trauma, regulasi emosi, self development, relationship, dan gangguan kepribadian. Keahlian: CBT, ACT, Art Therapy, MBCT, Hypnotherapy, DBT.',
                'schedule' => 'Lokasi: Jabarano Laswi',
                'price' => 'Offline Rp300.000, online video Rp220.000, voice call Rp170.000',
                'image_url' => '/images/canva/psychologists/psychologist-02.png',
                'sort_order' => 1,
            ],
            [
                'name' => 'Marina Puspa Ningrum S.Psi., M.Psi., Psikolog',
                'role' => 'Psikolog Klinis',
                'focus' => 'Konseling klinis untuk kebutuhan emosi, relasi, dan pengembangan diri.',
                'schedule' => 'Lokasi: Cimahi',
                'price' => 'Offline Rp300.000, online video Rp220.000, voice call Rp170.000',
                'image_url' => '/images/canva/psychologists/psychologist-03.png',
                'sort_order' => 2,
            ],
            [
                'name' => 'Astrid Nur Alfaradais, S.Psi. M.Psi., Psikolog',
                'role' => 'Psikolog Klinis',
                'focus' => 'Kecemasan, emosi, stres, self development, relationship, dan gangguan kepribadian. Keahlian: CBT, ACT, Art Therapy, Group Therapy.',
                'schedule' => 'Lokasi: Jabarano Laswi',
                'price' => 'Offline Rp300.000, online video Rp250.000, voice call Rp200.000',
                'image_url' => '/images/canva/psychologists/psychologist-04.png',
                'sort_order' => 3,
            ],
            [
                'name' => 'Adelia Octavia, S.Psi. M.Psi., Psikolog',
                'role' => 'Psikolog Klinis',
                'focus' => 'Konseling individual dan couple untuk kebutuhan emosi, relasi, serta pengembangan diri.',
                'schedule' => 'Lokasi: Jabarano Laswi',
                'price' => 'Offline Rp300.000, online video Rp250.000, voice call Rp200.000',
                'image_url' => '/images/canva/psychologists/psychologist-05.png',
                'sort_order' => 4,
            ],
            [
                'name' => 'Alinda Destiana S.Psi., M.Psi., Psikolog',
                'role' => 'Psikolog Anak dan Remaja',
                'focus' => 'Permasalahan emosi, sosial, relasi anak-orang tua, asesmen kesiapan sekolah, permasalahan klinis anak, dan pola pengasuhan. Keahlian: psikoterapi, pendekatan Montessori, terapi keluarga, behavior modification.',
                'schedule' => 'Lokasi: Jabarano Laswi',
                'price' => 'Offline Rp300.000, online video Rp250.000, voice call Rp200.000',
                'image_url' => '/images/canva/psychologists/psychologist-06.png',
                'sort_order' => 5,
            ],
            [
                'name' => 'Cinta Retsa Ferdiana, S.Psi. M.Psi., Psikolog',
                'role' => 'Psikolog Klinis',
                'focus' => 'Relationship, hubungan personal/interpersonal, kecemasan, depresi, regulasi emosi, self growth, self development, self-love, self-harm, parenting, dan keluarga. Keahlian: CBT, ELT, Art Therapy, MBCT, DBT.',
                'schedule' => 'Online',
                'price' => 'Online video Rp220.000, voice call Rp170.000',
                'image_url' => '/images/canva/psychologists/psychologist-07.png',
                'sort_order' => 6,
            ],
        ];

        foreach ($psychologists as $psychologist) {
            Psychologist::query()->create(array_merge($psychologist, ['is_active' => true]));
        }

        $packages = [
            [
                'title' => 'Konseling Offline',
                'description' => 'Sesi tatap muka dengan psikolog di lokasi Selaras Diri untuk kebutuhan personal, emosi, relasi, dan pengembangan diri.',
                'duration' => '1 jam',
                'price' => 'Rp300.000',
                'sort_order' => 1,
            ],
            [
                'title' => 'Online Video Call - Sarah, Marina, Cinta',
                'description' => 'Sesi konseling online melalui video call bersama Sarah Dian, Marina Puspa Ningrum, atau Cinta Retsa Ferdiana.',
                'duration' => '1 jam',
                'price' => 'Rp220.000',
                'sort_order' => 2,
            ],
            [
                'title' => 'Online Video Call - Astrid, Adelia, Alinda',
                'description' => 'Sesi konseling online melalui video call bersama Astrid Nur Alfaradais, Adelia Octavia, atau Alinda Destiana.',
                'duration' => '1 jam',
                'price' => 'Rp250.000',
                'sort_order' => 3,
            ],
            [
                'title' => 'Online Voice Call - Sarah, Marina, Cinta',
                'description' => 'Konseling via panggilan suara untuk proses yang lebih ringan dan privat bersama Sarah, Marina, atau Cinta.',
                'duration' => '1 jam',
                'price' => 'Rp170.000',
                'sort_order' => 4,
            ],
            [
                'title' => 'Online Voice Call - Astrid, Adelia, Alinda',
                'description' => 'Konseling via panggilan suara untuk proses yang lebih ringan dan privat bersama Astrid, Adelia, atau Alinda.',
                'duration' => '1 jam',
                'price' => 'Rp200.000',
                'sort_order' => 5,
            ],
            [
                'title' => 'Bundling Offline',
                'description' => 'Paket tiga kali konseling tatap muka untuk proses pendampingan yang lebih berkelanjutan.',
                'duration' => '3x pertemuan',
                'price' => 'Rp850.000',
                'sort_order' => 6,
            ],
            [
                'title' => 'Bundling Online Video Call - Sarah, Marina, Cinta',
                'description' => 'Paket tiga kali konseling online melalui video call bersama Sarah, Marina, atau Cinta.',
                'duration' => '3x pertemuan',
                'price' => 'Rp610.000',
                'sort_order' => 7,
            ],
            [
                'title' => 'Bundling Online Video Call - Astrid, Adelia, Alinda',
                'description' => 'Paket tiga kali konseling online melalui video call bersama Astrid, Adelia, atau Alinda.',
                'duration' => '3x pertemuan',
                'price' => 'Rp700.000',
                'sort_order' => 8,
            ],
            [
                'title' => 'Couple Offline - Sarah atau Marina',
                'description' => 'Sesi pasangan secara tatap muka untuk memahami dinamika relasi, konflik, dan komunikasi.',
                'duration' => '2 jam',
                'price' => 'Rp600.000',
                'sort_order' => 9,
            ],
            [
                'title' => 'Couple Offline - Astrid, Adelia, Alinda',
                'description' => 'Sesi pasangan secara tatap muka untuk memahami dinamika relasi, konflik, dan komunikasi.',
                'duration' => '2 jam',
                'price' => 'Rp700.000',
                'sort_order' => 10,
            ],
            [
                'title' => 'Couple Online Video Call - Sarah, Marina, Cinta',
                'description' => 'Konseling pasangan secara online melalui video call bersama Sarah, Marina, atau Cinta.',
                'duration' => '2 jam',
                'price' => 'Rp440.000',
                'sort_order' => 11,
            ],
            [
                'title' => 'Couple Online Video Call - Astrid, Adelia, Alinda',
                'description' => 'Konseling pasangan secara online melalui video call bersama Astrid, Adelia, atau Alinda.',
                'duration' => '2 jam',
                'price' => 'Rp500.000',
                'sort_order' => 12,
            ],
            [
                'title' => 'Test IQ Tanpa Konsultasi',
                'description' => 'Asesmen kemampuan intelektual tanpa sesi konsultasi lanjutan.',
                'duration' => 'Assessment',
                'price' => 'Rp120.000',
                'sort_order' => 13,
            ],
            [
                'title' => 'Test IQ Dengan Konsultasi',
                'description' => 'Asesmen kemampuan intelektual disertai sesi konsultasi hasil.',
                'duration' => 'Assessment',
                'price' => 'Rp220.000',
                'sort_order' => 14,
            ],
            [
                'title' => 'Test Minat dan Bakat',
                'description' => 'Asesmen minat bakat menggunakan grafis test, RMIB, multiple intelligences, dan gaya belajar.',
                'duration' => 'Assessment',
                'price' => 'Rp450.000',
                'sort_order' => 15,
            ],
            [
                'title' => 'Test IQ dan Minat Bakat',
                'description' => 'Paket asesmen lengkap untuk memahami kemampuan intelektual, minat, bakat, dan gaya belajar.',
                'duration' => 'Assessment',
                'price' => 'Rp850.000',
                'sort_order' => 16,
            ],
        ];

        foreach ($packages as $package) {
            CounselingPackage::query()->create(array_merge($package, ['is_active' => true]));
        }

        $events = [
            [
                'type' => 'support_group',
                'title' => 'Support Group Bulanan',
                'description' => 'Sebuah ruang aman untuk saling mendengar dan menguatkan. Dipandu fasilitator atau psikolog, peserta dapat berbagi pengalaman dan menemukan perspektif baru.',
                'schedule' => 'Awal bulan, kuota terbatas',
                'image_url' => '/images/canva/company/company-profile-04.png',
                'sort_order' => 1,
            ],
            [
                'type' => 'monthly',
                'title' => 'Trekking Meditasi & Coffee Tour',
                'description' => 'Menyegarkan pikiran lewat alam terbuka, latihan mindful walking, meditasi, dan menikmati momen bersama komunitas positif.',
                'schedule' => 'Bulanan',
                'image_url' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?auto=format&fit=crop&w=900&q=80',
                'sort_order' => 1,
            ],
            [
                'type' => 'monthly',
                'title' => 'Art Therapy',
                'description' => 'Mengekspresikan diri lewat karya seni, melepas stres, dan menenangkan pikiran bersama fasilitator.',
                'schedule' => 'Bulanan',
                'image_url' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?auto=format&fit=crop&w=900&q=80',
                'sort_order' => 2,
            ],
            [
                'type' => 'monthly',
                'title' => 'Workshop Mindfulness dan Self-Awareness',
                'description' => 'Pelatihan experiential learning untuk melatih kehadiran penuh, pengenalan emosi, dan teknik pengelolaan stres.',
                'schedule' => 'Bulanan',
                'image_url' => '/images/canva/company/company-profile-05.png',
                'sort_order' => 3,
            ],
            [
                'type' => 'monthly',
                'title' => 'Seminar dan Webinar Psikoedukasi',
                'description' => 'Diskusi psikologi bersama praktisi untuk memperluas literasi kesehatan mental yang mudah diterapkan sehari-hari.',
                'schedule' => 'Bulanan',
                'image_url' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80',
                'sort_order' => 4,
            ],
            [
                'type' => 'monthly',
                'title' => 'Yoga, Meditasi, Barre, dan Padel Session',
                'description' => 'Aktivitas tubuh dan napas yang membantu menenangkan pikiran, meningkatkan fokus, dan menjaga koneksi sosial.',
                'schedule' => 'Bulanan',
                'image_url' => 'https://images.unsplash.com/photo-1599901860904-17e6ed7083a0?auto=format&fit=crop&w=900&q=80',
                'sort_order' => 5,
            ],
        ];

        foreach ($events as $event) {
            Event::query()->create(array_merge($event, ['is_active' => true]));
        }
    }
}
