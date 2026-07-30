<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionExpiringNotification extends Notification
{
    public function __construct(
        private readonly Subscription $subscription,
        private readonly int $daysRemaining,
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $restaurant = $this->subscription->restaurant;
        $package = $this->subscription->package;
        $endsAt = $this->subscription->ends_at->translatedFormat('d F Y');

        $message = (new MailMessage)
            ->subject($this->subject($restaurant->name))
            ->greeting("Halo {$notifiable->name},");

        if ($this->daysRemaining > 0) {
            $message->line("Langganan paket {$package->name} untuk restoran \"{$restaurant->name}\" akan berakhir dalam {$this->daysRemaining} hari, tepatnya pada {$endsAt}.")
                ->line('Perpanjang sekarang agar layanan menu digital Anda tidak terganggu.');
        } elseif ($this->daysRemaining === 0) {
            $message->line("Langganan paket {$package->name} untuk restoran \"{$restaurant->name}\" berakhir hari ini ({$endsAt}).")
                ->line('Perpanjang sekarang agar layanan menu digital Anda tidak terganggu.');
        } else {
            $daysOverdue = abs($this->daysRemaining);
            $message->line("Langganan paket {$package->name} untuk restoran \"{$restaurant->name}\" sudah berakhir sejak {$endsAt} ({$daysOverdue} hari yang lalu).")
                ->line('Perpanjang segera untuk mengaktifkan kembali fitur paket Anda.');
        }

        return $message
            ->action('Kelola Langganan', route('dashboard.subscription.show'))
            ->line('Abaikan email ini jika Anda sudah melakukan perpanjangan.');
    }

    private function subject(string $restaurantName): string
    {
        if ($this->daysRemaining > 0) {
            return "Langganan {$restaurantName} akan segera berakhir";
        }

        if ($this->daysRemaining === 0) {
            return "Langganan {$restaurantName} berakhir hari ini";
        }

        return "Langganan {$restaurantName} sudah berakhir";
    }
}
