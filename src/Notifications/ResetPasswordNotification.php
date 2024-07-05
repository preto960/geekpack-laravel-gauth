<?php

namespace Geekpack\Gauth\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url('resetpassword/'.$this->token);

        return (new MailMessage)
            ->subject('Reset Password Notification')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', $url)
            ->line('If you did not request a password reset, no further action is required.');
    }

    public function toLog($notifiable)
    {
        $url = url('resetpassword/'.$this->token);

        Log::info('Forgot password details', [
            'to' => $notifiable->email,
            'url' => $url,
        ]);
    }
}
