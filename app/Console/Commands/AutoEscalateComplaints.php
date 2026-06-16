<?php

namespace App\Console\Commands;

use App\Helpers\NotificationHelper;
use App\Models\Complaint;
use Illuminate\Console\Command;

class AutoEscalateComplaints extends Command
{
    protected $signature = 'complaints:auto-escalate';

    protected $description = 'Automatically escalate unresolved complaints to admin';

    public function handle(): int
    {
        $days = 3;

        $complaints = Complaint::with('student')
            ->where('is_escalated', false)
            ->whereIn('status', ['pending', 'in_progress'])
            ->where('created_at', '<=', now()->subDays($days))
            ->get();

        foreach ($complaints as $complaint) {
            $complaint->update([
                'is_escalated' => true,
                'escalated_at' => now(),
                'escalation_reason' => 'Automatically escalated because the complaint remained unresolved for more than ' . $days . ' days.',
                'status' => 'in_progress',
            ]);

            NotificationHelper::sendToRole(
                'admin',
                'Complaint Auto Escalated',
                'A complaint has been automatically escalated: ' . $complaint->subject,
                route('admin.complaints.escalated.show', $complaint),
                'complaint_escalation'
            );

            if ($complaint->student?->user_id) {
                NotificationHelper::sendToUser(
                    $complaint->student->user_id,
                    'Complaint Escalated',
                    'Your complaint has been escalated to Admin because it was not resolved within ' . $days . ' days.',
                    route('student.complaints.show', $complaint),
                    'complaint'
                );
            }
        }

        $this->info($complaints->count() . ' complaints escalated.');

        return Command::SUCCESS;
    }
}
