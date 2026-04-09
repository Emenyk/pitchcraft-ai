<?php

namespace App\Services;

use Laravel\Ai\Contracts\Agent;

class AIService
{
    /**
     * Prompt any agent and return the raw SDK response.
     * For structured agents this is array-accessible.
     */
    public function prompt(Agent $agent, string $message): mixed
    {
        return $agent->prompt($message);
    }
}