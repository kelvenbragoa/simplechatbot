<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WhatsApp\Component;
use NotificationChannels\WhatsApp\WhatsAppChannel;
use NotificationChannels\WhatsApp\WhatsAppTemplate;

class WhatsappNotification extends Notification
{
    use Queueable;
    protected $number;


    /**
     * Create a new notification instance.
     */
    public function __construct($number)
    {
        //
        $this->number = $number;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [WhatsAppChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toWhatsapp()
    {


        return WhatsAppTemplate::create()
            ->name('purchase_receipt_1')
            ->header(Component::document('https://backend.mticket.co.mz/storage/tickets/ticket-8.pdf'))
            ->body(Component::text('ticket for Party'))
            ->body(Component::text('Mticket. For support contact: suporte@email.com or mobile: +258 84 264 8618'))
            ->body(Component::text('Ticket'))
            ->to($this->number);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
