<?php

namespace App\Services;

use App\Ai\Agents\ProposalWriterAgent;
use App\Ai\Tools\MatchSkillsTool;
use App\Models\Proposal;
use Illuminate\Support\Facades\Log;

class ProposalService
{
    public function generate(Proposal $proposal): array
    {
        $proposal->update(['status' => 'processing']);

        try {
            Log::info('[PitchCraft] Starting proposal generation', ['id' => $proposal->id]);

            // ── STEP 1: Extract skills from job description using simple parsing
            // We pass the full job description to the agent with all context
            // No separate analysis agent needed — one call does everything

            // ── STEP 2: Run MatchSkillsTool directly in PHP (no LLM needed)
            // Parse basic skills from the job description text
            $jobText = $proposal->job_description;
            $detectedSkills = $this->detectSkills($jobText);

            $tool = new MatchSkillsTool();
            $matchResult = json_decode(
                $tool->handle(new \Laravel\Ai\Tools\Request(['required_skills' => $detectedSkills])),
                true
            );

            $proposal->update(['matched_skills' => $matchResult]);

            Log::info('[PitchCraft] Skills matched', [
                'score'   => $matchResult['match_score'],
                'matched' => $matchResult['matched_skills'],
            ]);

            // ── STEP 3: Build rich context and generate proposal in one structured call
            $context = implode("\n", [
                "JOB POST:",
                $jobText,
                "",
                "MATCHED SKILLS FROM PROFILE:",
                "Matched: " . implode(', ', $matchResult['matched_skills']),
                "Match Score: " . $matchResult['match_score'] . "%",
                "Experience: " . $matchResult['experience_years'] . " years",
                "",
                "KEY HIGHLIGHTS:",
                implode("\n", $matchResult['relevant_highlights']),
            ]);

            $response = (new ProposalWriterAgent($proposal->tone))->prompt(
                "Write a winning freelance proposal using this context:\n\n{$context}"
            );

            Log::info('[PitchCraft] Raw response', ['response' => json_encode($response)]);

            // ── STEP 4: Extract and validate structured output
            $formatted = [
                'opening'       => $this->extractField($response, 'opening'),
                'understanding' => $this->extractField($response, 'understanding'),
                'fit'           => $this->extractField($response, 'fit'),
                'approach'      => $this->extractField($response, 'approach'),
                'closing'       => $this->extractField($response, 'closing'),
            ];

            foreach ($formatted as $key => $value) {
                if (empty($value)) {
                    throw new \Exception("Missing field [{$key}]. Raw: " . json_encode($response));
                }
            }

            $proposal->update([
                'proposal' => $formatted,
                'status'   => 'done',
            ]);

            Log::info('[PitchCraft] Complete', ['id' => $proposal->id]);

            return $formatted;

        } catch (\Throwable $e) {
            $proposal->update(['status' => 'failed']);
            Log::error('[PitchCraft] Failed', ['error' => $e->getMessage(), 'id' => $proposal->id]);
            throw $e;
        }
    }

    /**
     * Detect skills mentioned in the job description.
     * Simple keyword matching — no LLM call needed.
     */
    private function detectSkills(string $jobText): array
    {
        $knownSkills = [
            'Laravel', 'PHP', 'Vue.js', 'Vue', 'React', 'Node.js',
            'MySQL', 'PostgreSQL', 'REST API', 'APIs', 'Docker',
            'AWS', 'TailwindCSS', 'Redis', 'Python', 'JavaScript',
            'TypeScript', 'Stripe', 'GraphQL', 'MongoDB', 'Linux',
        ];

        $found = [];
        foreach ($knownSkills as $skill) {
            if (stripos($jobText, $skill) !== false) {
                $found[] = $skill;
            }
        }

        // Always return at least something
        return !empty($found) ? $found : ['PHP', 'Laravel'];
    }

    /**
     * Safely extract a field from the structured agent response.
     */
    private function extractField(mixed $response, string $key): string
    {
        if (is_array($response) && isset($response[$key])) {
            return (string) $response[$key];
        }

        if ($response instanceof \ArrayAccess && isset($response[$key])) {
            return (string) $response[$key];
        }

        if (is_object($response) && isset($response->$key)) {
            return (string) $response->$key;
        }

        if (is_object($response)) {
            $arr = (array) $response;
            if (isset($arr[$key])) {
                return (string) $arr[$key];
            }
        }

        return '';
    }
}