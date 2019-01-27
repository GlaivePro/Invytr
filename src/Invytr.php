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
    public function sendSetLink($email)   //TODO: šeit reāli nevajag getuser un isnull, jo var šim padot jau gatavu useri
    {
		$credentials = ['email' => $user->email];
		
        $user = $this->broker()->getUser($credentials);

		// Maybe throw an exception for this?
        if (is_null($user))
            return 'Invalid user';

		$token = $this->tokens->create($user);  // TODO: vajag $this->tokens būt pieejamam
		
		// Use the method if the developer has specified one
        if(is_callable([$user, 'sendPasswordSetNotification']))
            $user->sendPasswordSetNotification($token);
        else
            Notification::send($user, new SetPassword($token));

        return true;
    }

    public static function resendInvitation(User $user) 
    {
		// TODO: send existing token... refactor sending out of this and sendSet aftwerwards?
    }

    public static function revokeInvitation(User $user) 
    {
		// TODO: delete sent but unused token, return true if fine
    }

	// LIKELY we can drop the following two
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