<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Welcome to ' . config('app.name') . '!')
                    ->greeting('Hello, ' . $notifiable->name . '!')
                    ->line('Thank you for verifying your email and joining our platform.')
                    ->line('We’ve created default fiat (USD) and crypto (BTC) accounts for you.')
                    ->line('You’ve also received a signup bonus of $' . settings('signup_bonus', 10) . '.')
                    ->action('Visit Dashboard', url('/home'))
                    ->line('We’re excited to have you on board!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Welcome to ' . config('app.name') . '! Your account is set up with a $' . settings('signup_bonus', 10) . ' bonus.',
            'link' => url('/home'),
        ];
    }
}