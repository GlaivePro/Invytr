<?php

namespace GlaivePro\Invytr;

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
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response === 0
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * Send a password set link to a user.
     *
     * @param  array  $credentials
     * @return string
     */
    public function sendSetLink(array $credentials) 
    {
        $user = $this->broker()->getUser($credentials);

        if (is_null($user)) {
            return 'invaliduser';
        }

        if(is_callable([$user, 'sendPasswordSetNotification']))
        {
            $user->sendPasswordSetNotification(
                $this->tokens->create($user)
            );
        } else {
            Notification::send($user, new SetPassword($token));
        }

        return 0;
    }

    /**
     * Get the response for a successful password set link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return back()->with('status', trans($response));
    }

    /**
     * Get the response for a failed password set link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans($response)]);
    }

    public static function resend(User $user) 
    {

    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}