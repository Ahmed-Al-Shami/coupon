<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FlagSuspiciousAccount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(): void
    {
        // Simple heuristic: Many purchases from different IPs in short time
        $ipCount = $this->user->purchases()
            ->where('created_at', '>=', now()->subDay())
            ->distinct('ip_address')
            ->count();

        if ($ipCount > 5) {
            $this->user->update([
                'flagged_for_review' => true,
            ]);

            // Log for admin review
            \App\Services\AuditLogService::log('user_flagged_for_review', $this->user, [], ['reason' => 'Multiple IPs detected in short time.']);
        }
    }
}
