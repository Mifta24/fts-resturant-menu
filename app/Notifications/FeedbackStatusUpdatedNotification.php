<?php

namespace App\Notifications;

use App\Models\Feedback;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FeedbackStatusUpdatedNotification extends Notification
{
    public function __construct(private readonly Feedback $feedback) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $statusLabels = [
            Feedback::STATUS_NEW => 'Baru',
            Feedback::STATUS_REVIEWED => 'Ditinjau',
            Feedback::STATUS_RESOLVED => 'Selesai',
        ];

        $message = (new MailMessage)
            ->subject('Feedback Anda mendapat tanggapan')
            ->greeting("Halo {$notifiable->name},")
            ->line("Feedback yang Anda kirim untuk restoran \"{$this->feedback->restaurant->name}\" telah diperbarui menjadi status: ".($statusLabels[$this->feedback->status] ?? $this->feedback->status).'.')
            ->line("Pesan Anda: \"{$this->feedback->message}\"");

        if ($this->feedback->admin_note) {
            $message->line("Catatan dari tim kami: \"{$this->feedback->admin_note}\"");
        }

        return $message
            ->action('Lihat Feedback', route('dashboard.feedback.index'))
            ->line('Terima kasih sudah membantu kami meningkatkan layanan.');
    }
}
