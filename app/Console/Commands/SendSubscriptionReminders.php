<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Notifications\SubscriptionExpiringNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendSubscriptionReminders extends Command
{
    protected $signature = 'subscriptions:send-reminders';

    protected $description = 'Kirim notifikasi email ke restoran yang langganannya akan segera atau sudah berakhir';

    /**
     * Day offsets (relative to today) on which a reminder should be sent.
     * Positive: days before expiry. Zero: expires today. Negative: days after expiry.
     */
    private const REMINDER_DAY_OFFSETS = [7, 3, 1, 0, -1, -3, -7];

    public function handle(): int
    {
        $today = now()->startOfDay();
        $sent = 0;

        Subscription::query()
            ->where('status', Subscription::STATUS_ACTIVE)
            ->whereNotNull('ends_at')
            ->with(['restaurant.users', 'package'])
            ->each(function (Subscription $subscription) use ($today, &$sent) {
                $daysRemaining = (int) $today->diffInDays($subscription->ends_at->copy()->startOfDay(), false);

                if (! in_array($daysRemaining, self::REMINDER_DAY_OFFSETS, true)) {
                    return;
                }

                $owners = $subscription->restaurant->users()
                    ->wherePivot('status', 'active')
                    ->wherePivot('role', 'owner')
                    ->get();

                if ($owners->isEmpty()) {
                    return;
                }

                Notification::send($owners, new SubscriptionExpiringNotification($subscription, $daysRemaining));

                $sent += $owners->count();
            });

        $this->info("Reminder dikirim ke {$sent} pemilik restoran.");

        return self::SUCCESS;
    }
}
