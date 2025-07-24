<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequesterConfirmationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
        protected $order;

     public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
       return (new MailMessage)
                    ->subject('Confirmation de votre commande')
                    ->greeting('Bonjour ' . $notifiable->full_name)
                    ->line('Votre commande a été enregistrée avec succès.')
                    // ->line('Description : ' . $this->order->description)
                    // ->line('Quantité : ' . $this->order->quantity)
                    ->line('Merci de votre confiance.');
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
