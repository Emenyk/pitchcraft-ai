<?php
// app/Ai/Tools/MatchSkillsTool.php

namespace App\Ai\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class MatchSkillsTool implements Tool
{
    /**
     * Hardcoded user profile — swap this for a DB query per user later.
     */
    private array $profile = [
        'skills' => [
            'Laravel', 'PHP', 'Vue.js', 'REST APIs', 'MySQL',
            'TailwindCSS', 'Docker', 'AWS', 'React', 'Node.js',
            'Python', 'AI/LLM Integration', 'PostgreSQL', 'Redis',
        ],
        'experience_years' => 5,
        'highlights' => [
            'Built and deployed 10+ Laravel applications to production',
            'Integrated OpenAI and Anthropic APIs into live SaaS products',
            'Led backend architecture for a platform serving 50k+ users',
        ],
    ];

    public function description(): Stringable|string
    {
        return 'Matches a list of required job skills against the freelancer\'s profile. ' .
               'Returns matched skills, unmatched skills, a match score (0-100), ' .
               'and relevant experience highlights.';
    }

    public function handle(Request $request): Stringable|string
    {
        $required    = $request['required_skills'] ?? [];
        $profileSkills = array_map('strtolower', $this->profile['skills']);

        $matched   = [];
        $unmatched = [];

        foreach ($required as $skill) {
            if (in_array(strtolower($skill), $profileSkills)) {
                $matched[] = $skill;
            } else {
                $unmatched[] = $skill;
            }
        }

        $score = count($required) > 0
            ? round((count($matched) / count($required)) * 100)
            : 0;

        $result = [
            'matched_skills'      => $matched,
            'unmatched_skills'    => $unmatched,
            'match_score'         => $score,
            'experience_years'    => $this->profile['experience_years'],
            'relevant_highlights' => $this->profile['highlights'],
        ];

        // Tool must return a string — SDK passes it back to the LLM as context
        return json_encode($result);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'required_skills' => $schema->array()
                ->items($schema->string('skill', 'A required skill from the job post'))
                ->required(),
        ];
    }
}