<?php

namespace App\AI\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class MatchSkillsTool implements Tool
{
    /**
     * Freelancer's skills profile.
     * In a real app, pull this from the database or config.
     */
    private array $freelancerSkills = [
        'Laravel',
        'PHP',
        'REST API',
        'MySQL',
        'Vue.js',
        'React',
        'Docker',
        'Redis',
        'AWS',
        'TDD',
        'Git',
    ];

    private array $experienceSummaries = [
        'Laravel'   => '5 years building production Laravel APIs and SaaS platforms.',
        'PHP'       => '7 years of professional PHP development.',
        'REST API'  => 'Designed and maintained RESTful APIs consumed by mobile and web clients.',
        'MySQL'     => 'Database design, query optimization, and migrations at scale.',
        'Vue.js'    => '3 years building reactive frontends with Vue 2 and 3.',
        'React'     => '2 years of React development for client dashboards.',
        'Docker'    => 'Containerized applications for CI/CD pipelines.',
        'Redis'     => 'Used for caching, queues, and pub/sub in high-traffic apps.',
        'AWS'       => 'Deployed and managed EC2, S3, RDS, and Lambda workloads.',
        'TDD'       => 'PHPUnit and Pest test suites with >80% coverage on major projects.',
        'Git'       => 'Git flow, code reviews, and monorepo experience.',
    ];

    public function description(): Stringable|string
    {
        return 'Match the job\'s required skills against the freelancer\'s skill profile. '
            . 'Returns matched skills and relevant experience summaries for each matched skill.';
    }

    public function handle(Request $request): Stringable|string
    {
        $requiredSkills = $request['skills'] ?? [];

        $matched = [];
        $experience = [];

        foreach ($requiredSkills as $skill) {
            // Case-insensitive partial match
            foreach ($this->freelancerSkills as $mySkill) {
                if (stripos($mySkill, $skill) !== false || stripos($skill, $mySkill) !== false) {
                    $matched[] = $mySkill;
                    if (isset($this->experienceSummaries[$mySkill])) {
                        $experience[] = $this->experienceSummaries[$mySkill];
                    }
                    break;
                }
            }
        }

        $matched    = array_unique($matched);
        $experience = array_unique($experience);

        return json_encode([
            'matched_skills'      => $matched,
            'relevant_experience' => $experience,
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'skills' => $schema->array()
                ->items($schema->string())
                ->required(),
        ];
    }
}