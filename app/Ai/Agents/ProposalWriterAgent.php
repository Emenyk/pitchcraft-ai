<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Attributes\MaxTokens;
use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Attributes\Temperature;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Promptable;
use Stringable;

#[Provider('mistral')]
#[Model('mistral-small-latest')]
#[Temperature(0.7)]
#[MaxTokens(1024)]
class ProposalWriterAgent implements Agent, HasStructuredOutput
{
    use Promptable;

    public function __construct(private string $tone = 'professional') {}

    public function instructions(): Stringable|string
    {
        $toneGuide = match ($this->tone) {
            'confident' => 'Write with bold confidence and directness. Assert expertise. Zero hedging.',
            'short'     => 'Be extremely concise — every sentence earns its place. No padding.',
            default     => 'Write in a polished, professional tone that naturally builds trust.',
        };

        return "You are an expert freelance proposal writer who wins contracts. {$toneGuide} " .
               "Be specific — reference actual job details and matched skills provided to you. " .
               "Never use filler phrases like 'I am excited to apply'.";
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'opening' => $schema->string()
                ->description('1-2 sentences. A compelling hook showing you understand the job immediately.')
                ->required(),

            'understanding' => $schema->string()
                ->description('2-3 sentences showing you understand the client\'s real problem.')
                ->required(),

            'fit' => $schema->string()
                ->description('2-3 sentences on why YOU specifically — reference matched skills and experience.')
                ->required(),

            'approach' => $schema->string()
                ->description('2-4 sentences on how you would tackle this project step by step.')
                ->required(),

            'closing' => $schema->string()
                ->description('1-2 sentences. Confident, specific call to action.')
                ->required(),
        ];
    }
}