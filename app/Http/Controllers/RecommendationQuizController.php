<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Services\PsychologistRecommendationService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class RecommendationQuizController extends Controller
{
    public function show(): View
    {
        return view('pages.recommendation-quiz', $this->viewData());
    }

    public function submit(Request $request, PsychologistRecommendationService $recommendationService): View
    {
        $questions = config('recommendation.questions');
        $rules = [];

        foreach ($questions as $key => $question) {
            $rules["answers.{$key}"] = ($question['type'] ?? 'choice') === 'scale'
                ? ['required', 'integer', 'between:1,5']
                : ['required', 'string', 'in:' . implode(',', array_keys($question['options'] ?? []))];
        }

        $validated = $request->validate($rules);
        $result = $recommendationService->recommend($validated['answers']);

        return view('pages.recommendation-quiz', $this->viewData([
            'answers' => $validated['answers'],
            'result' => $result,
        ]));
    }

    private function viewData(array $extra = []): array
    {
        $settings = HomeController::defaultSettings();

        try {
            $settings = array_merge($settings, SiteSetting::query()->pluck('value', 'key')->all());
        } catch (Throwable) {
            //
        }

        $whatsappNumber = preg_replace('/\D+/', '', $settings['whatsapp_number']);
        $bookingMessage = rawurlencode($settings['booking_whatsapp_message']);

        return array_merge([
            'settings' => $settings,
            'bookingUrl' => "https://wa.me/{$whatsappNumber}?text={$bookingMessage}",
            'eventUrl' => "https://wa.me/{$whatsappNumber}?text=" . rawurlencode($settings['event_whatsapp_message']),
            'activeNav' => 'recommendation',
            'pageTitle' => 'Kuis Rekomendasi',
            'pageBody' => 'Jawab 5 pertanyaan singkat untuk mendapatkan rekomendasi layanan dan psikolog Selaras Diri yang relevan.',
            'questions' => config('recommendation.questions'),
        ], $extra);
    }
}
