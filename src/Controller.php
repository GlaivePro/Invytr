<?php

namespace GlaivePro\Invytr;
    
use Illuminate\Http\Request;
//use Illuminate\Foundation\Auth\User;

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
        if(view()->exists('auth.passwords.set')) {
            return view('auth.passwords.set')->with(
                ['token' => $token, 'email' => $request->email]
            );
        }

        Translator::replaceResetLines();

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
