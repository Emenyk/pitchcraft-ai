<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProposalController extends Controller
{
    public function index()
    {
        return view('pitchcraft');
    }

    public function generate(Request $request): JsonResponse
    {
        $request->validate([
            'job_description' => 'required|string',
            'tone' => 'required|in:professional,confident,short'
        ]);

        // Here you would integrate with your AI service
        // For now, returning mock responses
        $tone = $request->input('tone');
        $jobDesc = $request->input('job_description');
        
        $responses = [
            'professional' => [
                'opening' => "Thank you for sharing this detailed project opportunity. After carefully reviewing your requirements, I'm confident I can deliver exceptional results.",
                'understanding' => "I understand you need a comprehensive solution that balances functionality, aesthetics, and performance. Your emphasis on user experience and scalability aligns perfectly with my expertise.",
                'fit' => "With over 8 years of experience in full-stack development and having successfully delivered 50+ similar projects, I bring proven methodologies and technical excellence to your initiative.",
                'approach' => "My approach follows agile best practices: discovery phase, iterative development with weekly demos, rigorous QA testing, and seamless deployment with post-launch support.",
                'closing' => "I look forward to discussing how we can bring your vision to life. Let's schedule a call to align on specific deliverables and timelines."
            ],
            'confident' => [
                'opening' => "I've got exactly what you need for this project. No fluff, just results.",
                'understanding' => "You need this done right, on time, and with zero headaches. I've been building solutions like this for top-tier clients.",
                'fit' => "I'm the expert you're looking for. My portfolio includes Fortune 500 projects and I consistently exceed expectations.",
                'approach' => "I'll handle everything from architecture to deployment. You get weekly updates, full transparency, and a product that works flawlessly.",
                'closing' => "Ready to start immediately. Let me know when you want to kick this off."
            ],
            'short' => [
                'opening' => "Perfect fit for your project. Let me show you why.",
                'understanding' => "I get exactly what you need - quality delivery without the usual agency overhead.",
                'fit' => "5+ years experience. Dozens of happy clients. Clean code. Fast delivery.",
                'approach' => "Simple process: Discuss → Build → Test → Launch → Support.",
                'closing' => "Available to start tomorrow. Let's make this happen."
            ]
        ];
        
        return response()->json($responses[$tone]);
    }
}