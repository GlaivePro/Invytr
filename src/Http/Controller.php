<?php

namespace GlaivePro\Invytr\Http;

use Illuminate\Http\Request;
use GlaivePro\Invytr\Helpers\Translator;

class Controller
{
    /**
     * Display the password set view for the given token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showSetForm(Request $request, $token)
    {
        $request->session()->put('invytr', true);

        if (\View::exists('auth.passwords.set')) {
            return \View::make('auth.passwords.set', [
                'token' => $token,
                'email' => $request->email,
            ]);
        }

        (new Translator())->replaceFormLines();

        return \View::make('auth.passwords.reset', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }
}
