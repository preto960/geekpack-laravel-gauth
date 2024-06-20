<?php

namespace Geekpack\Gauth\Listeners;

use Geekpack\Gauth\Events\Registered;
use Geekpack\Gauth\Notifications\VerifyEmailNotification;
use Illuminate\Support\Facades\Log;

class SendEmailVerificationNotification
{
    public function handle(Registered $event)
    {
        Log::info('Handle method in SendEmailVerificationNotification called', ['user' => $event->user->email]);

        $event->user->notify(new VerifyEmailNotification());

        Log::info('Verification email notification sent', ['user' => $event->user->email]);
    }
}
