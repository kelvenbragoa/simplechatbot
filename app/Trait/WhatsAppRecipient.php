<?php
namespace App\Trait;
use Illuminate\Notifications\Notifiable;

class WhatsAppRecipient
{
    use Notifiable;

    protected $phone;

    public function __construct($phone)
    {
        $this->phone = $phone;
    }

    public function routeNotificationForWhatsApp()
    {
        return $this->phone;
    }
}