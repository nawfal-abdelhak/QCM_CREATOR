<?php

namespace App\Listeners;

use App\Events\NotifAnswer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifAnswerListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NotifAnswer  $event
     * @return void
     */
    public function handle(NotifAnswer $event)
    {
        //
    }
}
