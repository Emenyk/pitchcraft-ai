<?php
// app/Http/Controllers/ProposalController.php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Services\ProposalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProposalController extends Controller
{
    public function __construct(
        private readonly ProposalService $service
    ) {}

    public function generate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'job_description' => ['required', 'string', 'min:20', 'max:5000'],
            'tone'            => ['sometimes', Rule::in(['professional', 'confident', 'short'])],
        ]);

        $proposal = Proposal::create([
            'job_description' => $validated['job_description'],
            'tone'            => $validated['tone'] ?? 'professional',
        ]);

        try {
            $result = $this->service->generate($proposal);

            return response()->json([
                'success'       => true,
                'id'            => $proposal->id,
                'opening'       => $result['opening'],
                'understanding' => $result['understanding'],
                'fit'           => $result['fit'],
                'approach'      => $result['approach'],
                'closing'       => $result['closing'],
            ]);

        } catch (\Throwable $e) {
            // Tell the frontend the specific reason
            $isRateLimit = str_contains($e->getMessage(), 'rate limit') ||
                           str_contains($e->getMessage(), 'rate limited');

            return response()->json([
                'success' => false,
                'message' => $isRateLimit
                    ? 'AI provider is busy. Please wait 10 seconds and try again.'
                    : 'Proposal generation failed. Please try again.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], $isRateLimit ? 429 : 500);
        }
    }
}