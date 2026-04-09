<?php

namespace App\Services;

use App\AI\Agents\JobAnalysisAgent;
use App\AI\Agents\ProposalWriterAgent;

class ProposalAgent
{
    public function __construct(protected AIService $aiService) {}

    /**
     * Run the full multi-step agent workflow.
     *
     * Step 1: Analyze the job post (with tool calling for skill matching)
     * Step 2: MatchSkillsTool is called automatically by the SDK inside step 1
     * Step 3: Write the tailored proposal using the analysis + tone
     * Step 4: Return structured JSON output
     *
     * @return array{opening: string, understanding: string, fit: string, approach: string, closing: string}
     */
    public function run(string $jobDescription, string $tone): array
    {
        // ─── STEP 1 + 2: Job Analysis & Tool Calling ─────────────────────────
        // The JobAnalysisAgent has MatchSkillsTool registered.
        // The SDK will automatically invoke the tool when the model calls for it.
        // #[MaxSteps(5)] allows the agent to iterate: think → call tool → reflect → respond.

        $analysisResponse = $this->aiService->prompt(
            agent: new JobAnalysisAgent,
            message: "Analyze this job post and match it against the freelancer's skills:\n\n{$jobDescription}",
        );

        // The SDK returns an array-accessible StructuredAgentResponse for HasStructuredOutput agents.
        $analysis = [
            'required_skills'     => $analysisResponse['required_skills'] ?? [],
            'experience_level'    => $analysisResponse['experience_level'] ?? 'mid',
            'key_deliverables'    => $analysisResponse['key_deliverables'] ?? [],
            'matched_skills'      => $analysisResponse['matched_skills'] ?? [],
            'relevant_experience' => $analysisResponse['relevant_experience'] ?? [],
        ];

        // ─── STEP 3 + 4: Proposal Generation with Structured Output ──────────
        // Feed the enriched analysis + tone into the ProposalWriterAgent.
        // The agent returns a StructuredAgentResponse matching our 5-field schema.

        $analysisContext = $this->buildAnalysisContext($analysis, $tone);

        $proposalResponse = $this->aiService->prompt(
            agent: new ProposalWriterAgent,
            message: $analysisContext,
        );

        return [
            'opening'       => $proposalResponse['opening'],
            'understanding' => $proposalResponse['understanding'],
            'fit'           => $proposalResponse['fit'],
            'approach'      => $proposalResponse['approach'],
            'closing'       => $proposalResponse['closing'],
        ];
    }

    private function buildAnalysisContext(array $analysis, string $tone): string
    {
        $skills      = implode(', ', $analysis['required_skills']);
        $matched     = implode(', ', $analysis['matched_skills']);
        $deliverables = implode("\n- ", $analysis['key_deliverables']);
        $experience  = implode("\n- ", $analysis['relevant_experience']);

        return <<<CONTEXT
        Write a freelance proposal using the following job analysis.

        TONE: {$tone}

        JOB ANALYSIS:
        - Required Skills: {$skills}
        - Experience Level: {$analysis['experience_level']}
        - Key Deliverables:
          - {$deliverables}

        FREELANCER MATCH (from MatchSkillsTool):
        - Matched Skills: {$matched}
        - Relevant Experience:
          - {$experience}

        Use the analysis to write a specific, tailored proposal in the {$tone} tone.
        CONTEXT;
    }
}