<?php

namespace GlaivePro\Invytr;

use Password;
use Illuminate\Foundation\Auth\User;

class Invytr
{
    /**
     * Send a set link to the given user.
     *
     * @param  
     * @return 
     */
    public static function invite(User $user) 
    {
        $response = $this->sendSetLink($user);

        return $response;
    }

    /**
     * Send a password set link to a user.
     *
     * @param  array  $credentials
     * @return string
     */
    public function sendSetLink($email) 
    {
		$credentials = ['email' => $user->email];
		
        $user = $this->broker()->getUser($credentials);

		// Maybe throw an exception for this?
        if (is_null($user))
            return 'Invalid user';

		$token = $this->tokens->create($user);
		
		// User the method if the developer has specified one
        if(is_callable([$user, 'sendPasswordSetNotification']))
            $user->sendPasswordSetNotification($token);
        else
            Notification::send($user, new SetPassword($token));

        return 0;
    }

    public static function resend(User $user) 
    {
		// Send existing token
    }

    public static function revoke(User $user) 
    {
		// Delete sent but unused token
    }

    /**
     * Get the broker to be used during password setting.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }

    /**
     * Get the guard to be used during password setting.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}