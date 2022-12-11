<?php

namespace App\Listeners;

use App\Events\Ship;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ShipNotification;

class SendNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
      
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Ship  $event
     * @return void
     */
    public function handle(Ship $event)
    {
        Notification::route('mail', 'hungminhha751998@gmail.com')
            ->notify(new ShipNotification($event->phoneNumber, $event->shipAddress));
        
    }
}