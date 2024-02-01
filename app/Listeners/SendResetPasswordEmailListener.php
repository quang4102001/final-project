<?php

namespace App\Listeners;

use App\Events\ResetPasswordEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendResetPasswordEmailListener
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
    public function handle(ResetPasswordEvent $event): void
    {
        Mail::send('home.emails.linkResetPassword', ['token' => $event->token], function ($message) use ($event) {
            $message->to($event->email);
            $message->subject('Reset Password');
        });
    }
}
