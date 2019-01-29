<?php

namespace GlaivePro\Invytr\Helpers;

class Translator 
{
    public static function replaceResetLines()
    {
        $line = 'Set Password';

        if(app('translator')->has('Set Password'))
            $line = __('Set Password');

        app('translator')->addLines(['*.Reset Password' => $line], app()->getLocale());
    }
}
