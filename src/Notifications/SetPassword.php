<?php

namespace GlaivePro\Invytr\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SetPassword extends Notification
{
    /**
     * The password set token.
     *
     * @var string
     */
    public $token;

    /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        $email = '';
        if (is_string($notifiable)) {
            $email = $notifiable;
        }

        if (is_object($notifiable) && isset($notifiable->email)) {
            $email = $notifiable->email;
        }

        return (new MailMessage)
            ->subject(__('Account created'))
            ->line(__('An account for you has been created! Please set a password for your account!'))
            ->action(__('Set Password'), url(config('app.url').route('password.set', [
                'token' => $this->token,
                'email' => $email,
            ], false)));
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}
