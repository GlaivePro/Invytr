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

        if(view()->exists('auth.passwords.set')) {
            return view('auth.passwords.set')->with(
                ['token' => $token, 'email' => $request->email]
            );
        }

        $translator = new Translator();
        $translator->replaceFormLines();

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
