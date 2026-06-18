<?php

return [
    'questions' => [
        'main_concern' => [
            'label' => 'Hal yang paling ingin kamu pahami saat ini?',
            'type' => 'choice',
            'options' => [
                'anxiety' => [
                    'label' => 'Rasa cemas atau overthinking',
                    'tags' => ['kecemasan', 'stress', 'regulasi_emosi'],
                ],
                'stress' => [
                    'label' => 'Tekanan, lelah, atau sulit merasa tenang',
                    'tags' => ['stress', 'emosi', 'self_development'],
                ],
                'relationship' => [
                    'label' => 'Relasi, komunikasi, atau hubungan personal',
                    'tags' => ['relationship', 'keluarga', 'regulasi_emosi'],
                ],
                'growth' => [
                    'label' => 'Mengenal diri dan mengembangkan potensi',
                    'tags' => ['self_development', 'self_growth', 'mindfulness'],
                ],
                'child_family' => [
                    'label' => 'Anak, remaja, keluarga, atau parenting',
                    'tags' => ['anak_remaja', 'parenting', 'keluarga'],
                ],
            ],
        ],
        'emotion_intensity' => [
            'label' => 'Seberapa sering emosi terasa sulit dikelola?',
            'type' => 'scale',
            'low_label' => 'Jarang',
            'high_label' => 'Sering',
            'tags' => [
                1 => ['self_development'],
                2 => ['self_development'],
                3 => ['emosi', 'regulasi_emosi'],
                4 => ['emosi', 'regulasi_emosi', 'stress'],
                5 => ['emosi', 'regulasi_emosi', 'kecemasan', 'stress'],
            ],
        ],
        'support_preference' => [
            'label' => 'Format bantuan yang terasa paling nyaman untuk mulai?',
            'type' => 'choice',
            'options' => [
                'personal' => [
                    'label' => 'Sesi personal dengan psikolog',
                    'tags' => ['konseling_individu'],
                ],
                'group' => [
                    'label' => 'Ruang kelompok yang suportif',
                    'tags' => ['support_group', 'group_therapy', 'komunitas'],
                ],
                'creative' => [
                    'label' => 'Aktivitas kreatif dan ekspresif',
                    'tags' => ['art_therapy', 'emosi', 'ekspresi_diri'],
                ],
                'structured' => [
                    'label' => 'Pendekatan terstruktur dan problem solving',
                    'tags' => ['cognitive_behavior_therapy', 'acceptance_commitment_therapy'],
                ],
            ],
        ],
        'topic_area' => [
            'label' => 'Topik mana yang paling dekat dengan kebutuhanmu?',
            'type' => 'choice',
            'options' => [
                'self' => [
                    'label' => 'Diri sendiri, kepercayaan diri, dan arah hidup',
                    'tags' => ['self_development', 'self_growth', 'self_love'],
                ],
                'emotion' => [
                    'label' => 'Emosi, stres, kecemasan, atau depresi',
                    'tags' => ['emosi', 'stress', 'kecemasan', 'depresi'],
                ],
                'relationship' => [
                    'label' => 'Relationship atau hubungan interpersonal',
                    'tags' => ['relationship', 'hubungan_interpersonal'],
                ],
                'family' => [
                    'label' => 'Parenting, keluarga, anak, atau remaja',
                    'tags' => ['parenting', 'keluarga', 'anak_remaja'],
                ],
                'assessment' => [
                    'label' => 'Minat bakat, IQ, atau asesmen psikologi',
                    'tags' => ['assessment', 'minat_bakat', 'iq'],
                ],
            ],
        ],
        'session_style' => [
            'label' => 'Pendekatan seperti apa yang kamu rasa cocok?',
            'type' => 'choice',
            'options' => [
                'cbt' => [
                    'label' => 'Membantu mengurai pola pikir dan perilaku',
                    'tags' => ['cognitive_behavior_therapy', 'kecemasan', 'stress'],
                ],
                'act' => [
                    'label' => 'Reflektif, menerima emosi, dan bergerak sesuai nilai diri',
                    'tags' => ['acceptance_commitment_therapy', 'regulasi_emosi', 'self_development'],
                ],
                'art' => [
                    'label' => 'Ekspresif melalui media kreatif',
                    'tags' => ['art_therapy', 'emosi', 'ekspresi_diri'],
                ],
                'mindfulness' => [
                    'label' => 'Mindfulness, hadir penuh, dan menenangkan diri',
                    'tags' => ['mindfulness', 'stress', 'regulasi_emosi'],
                ],
                'unsure' => [
                    'label' => 'Belum tahu, ingin dibantu diarahkan',
                    'tags' => ['konseling_individu', 'self_development'],
                ],
            ],
        ],
    ],

    'therapy_semantics' => [
        'cbt' => ['cognitive_behavior_therapy', 'kecemasan', 'stress', 'depresi', 'pola_pikir'],
        'cognitive behavior therapy' => ['cognitive_behavior_therapy', 'kecemasan', 'stress', 'depresi', 'pola_pikir'],
        'act' => ['acceptance_commitment_therapy', 'regulasi_emosi', 'self_development', 'acceptance'],
        'acceptance commitment therapy' => ['acceptance_commitment_therapy', 'regulasi_emosi', 'self_development', 'acceptance'],
        'art therapy' => ['art_therapy', 'emosi', 'stress', 'ekspresi_diri'],
        'group therapy' => ['group_therapy', 'support_group', 'komunitas', 'relationship'],
        'mindfulness based cognitive therapy' => ['mindfulness', 'cognitive_behavior_therapy', 'kecemasan', 'regulasi_emosi'],
        'dialectical behavior therapy' => ['regulasi_emosi', 'emosi', 'gangguan_kepribadian'],
        'hypnotherapy' => ['stress', 'emosi', 'trauma'],
        'emphatic love therapy' => ['relationship', 'self_love', 'keluarga'],
        'psikoterapi' => ['anak_remaja', 'emosi', 'keluarga'],
        'behavior modification' => ['anak_remaja', 'parenting', 'perilaku'],
        'terapi keluarga' => ['keluarga', 'parenting', 'relationship'],
    ],

    'tag_aliases' => [
        'kecemasan' => ['kecemasan', 'cemas', 'anxiety', 'overthinking'],
        'stress' => ['stress', 'stres', 'tekanan'],
        'emosi' => ['emosi', 'emotional', 'perasaan'],
        'regulasi_emosi' => ['regulasi emosi', 'mengelola emosi'],
        'self_development' => ['self development', 'pengembangan diri', 'self growth'],
        'relationship' => ['relationship', 'relasi', 'hubungan personal', 'hubungan interpersonal'],
        'keluarga' => ['keluarga', 'family'],
        'parenting' => ['parenting', 'pengasuhan'],
        'anak_remaja' => ['anak', 'remaja', 'anak dan remaja'],
        'depresi' => ['depresi', 'depression'],
        'trauma' => ['trauma'],
        'gangguan_kepribadian' => ['gangguan kepribadian'],
        'self_love' => ['self-love', 'self love'],
        'assessment' => ['assessment', 'asesmen', 'test', 'tes'],
        'minat_bakat' => ['minat bakat', 'minat dan bakat'],
        'iq' => ['iq'],
    ],
];
