<?php

namespace App\Listeners;

use App\Events\QcmAnswered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class QcmAnsweredListener
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
     * @param  QcmAnswered  $event
     * @return void
     */
    public function handle(QcmAnswered $event)
    {
        //
    }
}
