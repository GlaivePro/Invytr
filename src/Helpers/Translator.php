<?php

namespace GlaivePro\Invytr\Helpers;

class Translator 
{
    private $passwords = [
        'password' => 'Passwords must be at least six characters and match the confirmation.',
        'reset' => 'Your password has been set!',
        'token' => 'This token is invalid.',
        'user' => "We can't find a user with that e-mail address.",
    ];

    public function replaceFormLines()
    {
        $line = 'Set Password';

        if(app('translator')->has('Set Password'))
            $line = __('Set Password');

        app('translator')->addLines(['*.Reset Password' => $line], app()->getLocale());
    }

    public function replaceResponseLines()
    {
        foreach ($this->passwords as $key => $string) {
            if(app('translator')->has($string))
                $string = __($string);

            app('translator')->addLines(['passwords.'.$key => $string], app()->getLocale());
        }
    }
}
