<?php

namespace App\Listeners;

use App\Models\SuccessfulLoginLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $log = SuccessfulLoginLog::create([
            'create_user_id' => $event->user->id,
            'username' => $event->user->username,
        ]);
    }
}
