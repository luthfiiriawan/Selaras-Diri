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
                'focus' => 'Pendamping untuk berbagai kebutuhan emosi, relasi, dan pemulihan diri dengan pendekatan integratif.',
                'specialization' => 'Kecemasan, Depresi, Stress, Trauma, Regulasi Emosi, Self Development, Relationship, Gangguan Kepribadian',
                'expertise' => 'CBT, ACT, Art Therapy, MBCT, Hypnotherapy, DBT',
                'schedule' => 'Jabarano Laswi',
                'price' => 'Offline Rp300.000 · Video Rp220.000 · Voice Rp170.000',
                'image_url' => '/images/psychologists/sarah-dian.png',
                'sort_order' => 1,
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
                'sort_order' => 2,
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
                'sort_order' => 3,
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
                'sort_order' => 4,
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
                'sort_order' => 5,
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
                'sort_order' => 6,
            ],
        ];

        foreach ($psychologists as $psychologist) {
            Psychologist::query()->create(array_merge($psychologist, ['is_active' => true]));
        }

        $packages = [
            [
                'title' => 'Konseling Offline',
                'description' => 'Sesi tatap muka dengan psikolog di Jabarano Laswi atau Cimahi untuk kebutuhan personal, emosi, relasi, dan pengembangan diri.',
                'duration' => '1 jam',
                'price' => 'Rp300.000',
                'sort_order' => 1,
            ],
            [
                'title' => 'Online Video Call · Sarah, Marina, Cinta',
                'description' => 'Sesi konseling online via video call bersama Sarah Dian, Marina Puspa Ningrum, atau Cinta Retsa Ferdiana.',
                'duration' => '1 jam',
                'price' => 'Rp220.000',
                'sort_order' => 2,
            ],
            [
                'title' => 'Online Video Call · Astrid, Adelia, Alinda',
                'description' => 'Sesi konseling online via video call bersama Astrid Nur Alfaradais, Adelia Octavia, atau Alinda Destiana.',
                'duration' => '1 jam',
                'price' => 'Rp250.000',
                'sort_order' => 3,
            ],
            [
                'title' => 'Online Voice Call · Sarah, Marina, Cinta',
                'description' => 'Konseling via panggilan suara untuk proses yang lebih privat bersama Sarah, Marina, atau Cinta.',
                'duration' => '1 jam',
                'price' => 'Rp170.000',
                'sort_order' => 4,
            ],
            [
                'title' => 'Online Voice Call · Astrid, Adelia, Alinda',
                'description' => 'Konseling via panggilan suara untuk proses yang lebih privat bersama Astrid, Adelia, atau Alinda.',
                'duration' => '1 jam',
                'price' => 'Rp200.000',
                'sort_order' => 5,
            ],
            [
                'title' => 'Bundling Konseling Offline',
                'description' => 'Paket tiga kali pertemuan tatap muka untuk pendampingan yang lebih berkelanjutan.',
                'duration' => '3x pertemuan',
                'price' => 'Rp850.000',
                'sort_order' => 6,
            ],
            [
                'title' => 'Bundling Online Video · Sarah, Marina, Cinta',
                'description' => 'Paket tiga kali konseling online video bersama Sarah, Marina, atau Cinta.',
                'duration' => '3x pertemuan',
                'price' => 'Rp610.000',
                'sort_order' => 7,
            ],
            [
                'title' => 'Bundling Online Video · Astrid, Adelia, Alinda',
                'description' => 'Paket tiga kali konseling online video bersama Astrid, Adelia, atau Alinda.',
                'duration' => '3x pertemuan',
                'price' => 'Rp700.000',
                'sort_order' => 8,
            ],
            [
                'title' => 'Couple Offline · Sarah atau Marina',
                'description' => 'Sesi pasangan secara tatap muka untuk memahami dinamika relasi, konflik, dan komunikasi.',
                'duration' => '2 jam',
                'price' => 'Rp600.000',
                'sort_order' => 9,
            ],
            [
                'title' => 'Couple Offline · Astrid, Adelia, Alinda',
                'description' => 'Sesi pasangan tatap muka bersama Astrid, Adelia, atau Alinda.',
                'duration' => '2 jam',
                'price' => 'Rp700.000',
                'sort_order' => 10,
            ],
            [
                'title' => 'Couple Online Video · Sarah, Marina, Cinta',
                'description' => 'Konseling pasangan online via video call bersama Sarah, Marina, atau Cinta.',
                'duration' => '2 jam',
                'price' => 'Rp440.000',
                'sort_order' => 11,
            ],
            [
                'title' => 'Couple Online Video · Astrid, Adelia, Alinda',
                'description' => 'Konseling pasangan online via video call bersama Astrid, Adelia, atau Alinda.',
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
                'description' => 'Asesmen kemampuan intelektual disertai sesi konsultasi hasil bersama psikolog.',
                'duration' => 'Assessment',
                'price' => 'Rp220.000',
                'sort_order' => 14,
            ],
            [
                'title' => 'Test Minat dan Bakat',
                'description' => 'Asesmen minat bakat: grafis test (WZT, BAUM, DAP), RMIB, Multiple Intelligences, dan gaya belajar.',
                'duration' => 'Assessment',
                'price' => 'Rp450.000',
                'sort_order' => 15,
            ],
            [
                'title' => 'Test IQ & Minat Bakat',
                'description' => 'Paket lengkap: IST (IQ Test), grafis test, RMIB, Multiple Intelligences, dan gaya belajar.',
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
                'description' => 'Ruang aman untuk saling mendengar dan menguatkan. Dipandu fasilitator atau psikolog, peserta dapat berbagi pengalaman dan menemukan perspektif baru. Perjalanan pulih lebih ringan saat ditempuh bersama.',
                'schedule' => 'Awal bulan · kuota terbatas',
                'image_url' => '/images/canva/company/company-profile-04.png',
                'sort_order' => 1,
            ],
            [
                'type' => 'monthly',
                'title' => 'Trekking Meditasi & Coffee Tour',
                'description' => 'Menyegarkan pikiran lewat alam terbuka, mindful walking, dan menikmati momen bersama komunitas positif.',
                'schedule' => 'Bulanan',
                'image_url' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?auto=format&fit=crop&w=900&q=80',
                'sort_order' => 1,
            ],
            [
                'type' => 'monthly',
                'title' => 'Yarn Art & Macrame',
                'description' => 'Ruang ekspresif lewat seni benang dan makrame untuk melepaskan tekanan batin dan memperkuat koneksi dengan diri.',
                'schedule' => 'Bulanan',
                'image_url' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?auto=format&fit=crop&w=900&q=80',
                'sort_order' => 2,
            ],
            [
                'type' => 'monthly',
                'title' => 'Workshop Mindfulness & Self-Awareness',
                'description' => 'Experiential learning untuk melatih kehadiran penuh, pengenalan emosi, dan teknik pengelolaan stres.',
                'schedule' => 'Bulanan',
                'image_url' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=900&q=80',
                'sort_order' => 3,
            ],
            [
                'type' => 'monthly',
                'title' => 'Psikoedukasi & Webinar',
                'description' => 'Diskusi psikologi bersama praktisi untuk memperluas literasi kesehatan mental yang mudah diterapkan.',
                'schedule' => 'Bulanan',
                'image_url' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80',
                'sort_order' => 4,
            ],
            [
                'type' => 'monthly',
                'title' => 'Yoga & Meditasi',
                'description' => 'Aktivitas tubuh dan napas untuk menenangkan pikiran, meningkatkan fokus, dan menjaga koneksi dengan diri.',
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
