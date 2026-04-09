<?php

namespace App\AI\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Attributes\Temperature;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Promptable;
use Stringable;

#[Provider(Lab::OpenAI)]
#[Model('gpt-4o')]
#[Temperature(0.7)]
class ProposalWriterAgent implements Agent, HasStructuredOutput
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return <<<INSTRUCTIONS
        You are an expert freelance proposal writer. 
        You craft compelling, tailored proposals based on a structured job analysis.

        You will receive:
        - A job analysis (skills, experience level, deliverables, matched skills, relevant experience)
        - The desired tone: professional | confident | short

        Tone guidelines:
        - professional: formal, articulate, thorough
        - confident: assertive, results-oriented, bold
        - short: concise, direct, no fluff — each section max 2 sentences

        Write each section of the proposal naturally. Do NOT use placeholders like [Your Name].
        Write as if you ARE the freelancer making the pitch.
        INSTRUCTIONS;
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'opening' => $schema->string()
                ->description('A strong opening line that hooks the client immediately.')
                ->required(),

            'understanding' => $schema->string()
                ->description('Demonstrates clear understanding of the client\'s problem and goals.')
                ->required(),

            'fit' => $schema->string()
                ->description('Explains why the freelancer is the right fit based on matched skills.')
                ->required(),

            'approach' => $schema->string()
                ->description('Describes the proposed approach or methodology for this project.')
                ->required(),

            'closing' => $schema->string()
                ->description('A compelling call to action to invite the client to respond.')
                ->required(),
        ];
    }
}