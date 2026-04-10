<?php
// app/Models/Proposal.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proposal extends Model
{
    protected $fillable = [
        'job_description',
        'tone',
        'job_analysis',
        'matched_skills',
        'proposal',
        'status',
        'user_id',
    ];

    protected $casts = [
        'job_analysis'   => 'array',
        'matched_skills' => 'array',
        'proposal'       => 'array',
    ];

    // ── Relationships ─────────────────────────────────────────────────

    /**
     * Ready for Path B (auth) — nullable so it works without auth now.
     */
    // public function user(): BelongsTo
    // {
    //     return $this->belongsTo(User::class);
    // }

    // ── Scopes ────────────────────────────────────────────────────────

    public function scopeDone($query)
    {
        return $query->where('status', 'done');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    // ── Helpers ───────────────────────────────────────────────────────

    public function isComplete(): bool
    {
        return $this->status === 'done';
    }

    public function hasFailed(): bool
    {
        return $this->status === 'failed';
    }
}
