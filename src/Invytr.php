<?php

namespace GlaivePro\Invytr;

use Password;
use Notification;
use Illuminate\Foundation\Auth\User;
//use Illuminate\Auth\Passwords\TokenRepositoryInterface;

class Invytr
{   
    /**
     * The password token repository.
     *
     * @var \Illuminate\Auth\Passwords\TokenRepositoryInterface
     */
    //protected $tokens;

    /**
     * Create a new invytr instance.
     *
     * @param  \Illuminate\Auth\Passwords\TokenRepositoryInterface  $tokens
     * @return void
     */
    public function __construct()  //TokenRepositoryInterface $tokens
    {
        //$this->tokens = $tokens;
    }

    /**
     * Send a set link to the given user.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user 
     * @return bool
     */
    public function invite(User $user) 
    {
        $response = $this->sendInvitation($user);

        return $response;
    }

    /**
     * Send a password set link to a user.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @return bool
     */
    protected function sendInvitation(User $user)
    {
        $token = $this->broker()->createToken($user);
		
		// Use the method if the developer has specified one
        if(method_exists($user, 'sendPasswordSetNotification'))
            $user->sendPasswordSetNotification($token);
        else
            Notification::send($user, new SetPassword($token));

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