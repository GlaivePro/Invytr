<?php

namespace GlaivePro\Invytr\Helpers;

class Translator 
{
    private static $passwords = [
        'password' => 'Passwords must match the confirmation.',
        'reset' => 'Your password has been set!',
        'token' => 'This token is invalid.',
        'user' => "We can't find a user with that e-mail address.",
    ];

    public static function replaceFormLines()
    {
        $line = 'Set Password';

        if(app('translator')->has('Set Password'))
            $line = __('Set Password');

        app('translator')->addLines(['*.Reset Password' => $line], app()->getLocale());
    }

    public static function replaceResponseLines()
    {
        foreach (self::$passwords as $key => $string) {
            if(app('translator')->has($string))
                $string = __($string);

            app('translator')->addLines(['passwords.'.$key => $string], app()->getLocale());
        }
    }
}
