<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Attributes\Temperature;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Promptable;
use Stringable;

#[Provider('mistral')]
#[Model('mistral-small-latest')]
#[Temperature(0.3)]
class JobAnalyzerAgent implements Agent, HasStructuredOutput
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return 'You are an expert at analyzing freelance job posts. ' .
               'Extract precise, actionable information. Be specific — never generic. ' .
               'Identify the real pain point the client is trying to solve.';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'required_skills' => $schema->array()
                ->items($schema->string('skill', 'A required technical or soft skill'))
                ->required(),

            'experience_level' => $schema->string()
                ->enum(['junior', 'mid', 'senior'])
                ->required(),

            'key_deliverables' => $schema->array()
                ->items($schema->string('deliverable', 'A specific deliverable'))
                ->required(),

            'project_type' => $schema->string()
                ->description('e.g. web app, REST API, mobile app')
                ->required(),

            'client_pain_point' => $schema->string()
                ->description('The core problem in one sentence')
                ->required(),
        ];
    }
}