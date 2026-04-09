<?php

namespace App\AI\Agents;

use App\AI\Tools\MatchSkillsTool;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Attributes\MaxSteps;
use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Promptable;
use Stringable;

#[Provider(Lab::OpenAI)]
#[Model('gpt-4o')]
#[MaxSteps(5)]   // Allow the agent up to 5 reasoning steps (tool calls count as steps)
class JobAnalysisAgent implements Agent, HasTools, HasStructuredOutput
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return <<<INSTRUCTIONS
        You are an expert freelance proposal analyst.

        Your job is to:
        1. Carefully read the provided job description.
        2. Extract the required skills as a list.
        3. Use the MatchSkillsTool to compare those skills against the freelancer's profile.
        4. Identify the experience level required (junior | mid | senior).
        5. List the key deliverables the client wants.

        IMPORTANT: You MUST call the MatchSkillsTool with the skills you extracted. Do not skip this step.

        Return your final structured analysis including the tool results.
        INSTRUCTIONS;
    }

    public function tools(): iterable
    {
        return [
            new MatchSkillsTool,
        ];
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'required_skills' => $schema->array()
                ->items($schema->string())
                ->required(),

            'experience_level' => $schema->string()
                ->enum(['junior', 'mid', 'senior'])
                ->required(),

            'key_deliverables' => $schema->array()
                ->items($schema->string())
                ->required(),

            'matched_skills' => $schema->array()
                ->items($schema->string())
                ->required(),

            'relevant_experience' => $schema->array()
                ->items($schema->string())
                ->required(),
        ];
    }
}