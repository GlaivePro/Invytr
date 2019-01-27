<?php

namespace GlaivePro\Invytr;

class Translator {

    public static function replaceResetLines()
    {
        $line = 'Set password';

        if(app('translator')->has('Set password'))
            $line = __('Set password');

        app('translator')->addLines(['*.Reset password' => $line], app()->getLocale());
    }
}
