<?php

namespace Tests\Feature;

use Tests\TestCase;

class RecommendationQuizTest extends TestCase
{
    public function test_recommendation_quiz_page_returns_successful_response(): void
    {
        $this->get('/kuis-rekomendasi')
            ->assertStatus(200)
            ->assertSee('Cek Kebutuhan')
            ->assertSee('Lihat Rekomendasi');
    }

    public function test_recommendation_quiz_requires_all_answers(): void
    {
        $this->post('/kuis-rekomendasi', [
            'answers' => [],
        ])->assertSessionHasErrors([
            'answers.main_concern',
            'answers.emotion_intensity',
            'answers.support_preference',
            'answers.topic_area',
            'answers.session_style',
        ]);
    }

    public function test_recommendation_quiz_can_return_a_recommendation(): void
    {
        $this->post('/kuis-rekomendasi', [
            'answers' => [
                'main_concern' => 'anxiety',
                'emotion_intensity' => 4,
                'support_preference' => 'structured',
                'topic_area' => 'emotion',
                'session_style' => 'cbt',
            ],
        ])
            ->assertStatus(200)
            ->assertSee('Hasil Rekomendasi')
            ->assertSee('Konseling Individu');
    }
}
