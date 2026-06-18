<?php

namespace App\Services;

use App\Models\Psychologist;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Throwable;

class PsychologistRecommendationService
{
    public function recommend(array $answers): array
    {
        $userTags = $this->tagsFromAnswers($answers);
        $serviceRecommendation = $this->serviceRecommendation($userTags);
        $psychologists = $this->rankPsychologists($userTags);

        return [
            'tags' => $userTags->keys()->take(6)->values(),
            'service' => $serviceRecommendation,
            'psychologists' => $psychologists->take(3)->values(),
        ];
    }

    private function tagsFromAnswers(array $answers): Collection
    {
        $questions = config('recommendation.questions', []);
        $tags = collect();

        foreach ($answers as $key => $answer) {
            $question = $questions[$key] ?? null;

            if (! $question) {
                continue;
            }

            $answerTags = ($question['type'] ?? 'choice') === 'scale'
                ? ($question['tags'][(int) $answer] ?? [])
                : ($question['options'][$answer]['tags'] ?? []);

            foreach ($answerTags as $tag) {
                $normalized = $this->normalizeTag($tag);
                $tags[$normalized] = ($tags[$normalized] ?? 0) + 1;
            }
        }

        return $tags->sortDesc();
    }

    private function rankPsychologists(Collection $userTags): Collection
    {
        try {
            if (! Schema::hasTable('psychologists')) {
                return collect();
            }

            return Psychologist::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get()
                ->map(fn (Psychologist $psychologist) => $this->scorePsychologist($psychologist, $userTags))
                ->filter(fn (array $item) => $item['score'] > 0)
                ->sortByDesc('score')
                ->values();
        } catch (Throwable) {
            return collect();
        }
    }

    private function scorePsychologist(Psychologist $psychologist, Collection $userTags): array
    {
        $profile = $this->profileTags($psychologist);
        $score = 0;
        $matched = collect();

        foreach ($userTags as $tag => $weight) {
            if ($profile['specialization']->has($tag)) {
                $score += 4 * $weight;
                $matched->push($this->humanizeTag($tag));
            }

            if ($profile['expertise']->has($tag)) {
                $score += 3 * $weight;
                $matched->push($this->humanizeTag($tag));
            }

            if ($profile['focus']->has($tag)) {
                $score += $weight;
                $matched->push($this->humanizeTag($tag));
            }
        }

        return [
            'psychologist' => $psychologist,
            'score' => $score,
            'matched_tags' => $matched->unique()->take(5)->values(),
            'reason' => $this->reason($psychologist, $matched->unique()->take(4)->values()),
        ];
    }

    private function profileTags(Psychologist $psychologist): array
    {
        return [
            'specialization' => $this->tagsFromText((string) $psychologist->specialization),
            'expertise' => $this->tagsFromText((string) $psychologist->expertise, true),
            'focus' => $this->tagsFromText((string) $psychologist->focus),
        ];
    }

    private function tagsFromText(string $text, bool $expandTherapyTerms = false): Collection
    {
        $tags = collect();
        $normalizedText = Str::of($text)->lower()->replace(['/', '&'], ' ')->toString();
        $parts = preg_split('/,|;|\||\R/', $normalizedText) ?: [];

        foreach ($parts as $part) {
            $part = trim($part);

            if ($part === '') {
                continue;
            }

            $tags[$this->normalizeTag($part)] = true;
        }

        foreach (config('recommendation.tag_aliases', []) as $tag => $aliases) {
            foreach ($aliases as $alias) {
                if (str_contains($normalizedText, Str::lower($alias))) {
                    $tags[$this->normalizeTag($tag)] = true;
                }
            }
        }

        if ($expandTherapyTerms) {
            foreach (config('recommendation.therapy_semantics', []) as $term => $semanticTags) {
                if (! str_contains($normalizedText, Str::lower($term))) {
                    continue;
                }

                foreach ($semanticTags as $semanticTag) {
                    $tags[$this->normalizeTag($semanticTag)] = true;
                }
            }
        }

        return $tags;
    }

    private function serviceRecommendation(Collection $tags): array
    {
        if ($tags->has('assessment') || $tags->has('minat_bakat') || $tags->has('iq')) {
            return [
                'title' => 'Assessment Psikologi',
                'description' => 'Kebutuhanmu terlihat dekat dengan eksplorasi minat, bakat, atau kemampuan. Admin dapat membantu memilih format asesmen yang sesuai.',
            ];
        }

        if ($tags->has('support_group') || $tags->has('group_therapy') || $tags->has('komunitas')) {
            return [
                'title' => 'Support Group atau Group Session',
                'description' => 'Jawabanmu menunjukkan kebutuhan untuk ruang berbagi yang suportif dan tidak terasa sendirian.',
            ];
        }

        if ($tags->has('art_therapy') || $tags->has('ekspresi_diri')) {
            return [
                'title' => 'Art Therapy atau Sesi Kreatif',
                'description' => 'Kamu mungkin cocok memulai dari pendekatan yang memberi ruang ekspresi emosi secara kreatif.',
            ];
        }

        return [
            'title' => 'Konseling Individu',
            'description' => 'Kamu mungkin cocok memulai dari sesi personal agar kebutuhanmu bisa dipahami lebih mendalam bersama psikolog.',
        ];
    }

    private function reason(Psychologist $psychologist, Collection $matchedTags): string
    {
        if ($matchedTags->isEmpty()) {
            return "{$psychologist->name} memiliki profil yang cukup relevan dengan kebutuhan awalmu.";
        }

        return "{$psychologist->name} relevan karena profilnya berkaitan dengan " . $matchedTags->implode(', ') . '.';
    }

    private function normalizeTag(string $value): string
    {
        return Str::of($value)
            ->lower()
            ->ascii()
            ->replace(['&', '/', '-'], ' ')
            ->squish()
            ->replace(' ', '_')
            ->toString();
    }

    private function humanizeTag(string $tag): string
    {
        return Str::of($tag)
            ->replace('_', ' ')
            ->title()
            ->toString();
    }
}
