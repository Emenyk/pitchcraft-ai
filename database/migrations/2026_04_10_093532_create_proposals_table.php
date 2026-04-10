<?php
// database/migrations/xxxx_xx_xx_create_proposals_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();

            // Input
            $table->text('job_description');
            $table->string('tone')->default('professional');

            // Agent step outputs (stored for debugging + history)
            $table->json('job_analysis')->nullable();   // Step 1 output
            $table->json('matched_skills')->nullable(); // Step 2 tool output
            $table->json('proposal')->nullable();       // Final structured output

            // Workflow state
            $table->string('status')->default('pending');
            // pending → processing → done | failed

            // Ready for auth later — nullable so guests still work
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};