<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ShipNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $phoneNumber;
    public $shipAddress;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($phoneNumber, $shipAddress)
    {
        $this->phoneNumber = $phoneNumber;
        $this->shipAddress = $shipAddress;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Notification!')
                    ->line('You ordered successfully and we are shipping to your address, please wait for our shipper.')
                    ->line('Customer phone number : '.$this->phoneNumber.' and address : '.$this->shipAddress)
                    ->action('View Pizzahot website', url('/'))
                    ->line('Thanks you for coming Pizza Hot!');
                    
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'phone_number' => $this->phoneNumber,
            'ship_address' => $this->shipAddress,
         
        ];
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    // public function toArray($notifiable)
    // {
    //     return [
    //         //
    //     ];
    // }
}