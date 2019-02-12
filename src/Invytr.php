<?php

namespace GlaivePro\Invytr;

use Password;
use Notification;
use Illuminate\Foundation\Auth\User;
use GlaivePro\Invytr\Notifications\SetPassword;

class Invytr
{
    /**
     * Send a set link to the given user.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @return bool
     */
    public function invite(User $user)
    {
        $token = $this->broker()->createToken($user);
        
        // Use the method if the developer has specified one
        if (method_exists($user, 'sendPasswordSetNotification')) {
            $user->sendPasswordSetNotification($token);
        } else {
            Notification::send($user, new SetPassword($token));
        }

        return true;
    }

    /**
     * Delete a token record by user.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @return void
     */
    public function revokeInvitation(User $user)
    {
        $this->broker()->deleteToken($user);
    }

    /**
     * Get the broker to be used during password setting.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    protected function broker()
    {
        return Password::broker();
    }
}
