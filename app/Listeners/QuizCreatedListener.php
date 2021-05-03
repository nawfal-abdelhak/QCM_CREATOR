<?php

namespace App\Listeners;

use App\Events\QuizCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class QuizCreatedListener
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
     * @param  QuizCreated  $event
     * @return void
     */
    public function handle(QuizCreated $event)
    {
        //
    }
}
