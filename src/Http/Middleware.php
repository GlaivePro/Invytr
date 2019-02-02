<?php

namespace GlaivePro\Invytr\Http;
    
use Closure;
use GlaivePro\Invytr\Helpers\Translator;
use Illuminate\Http\Request;

class Middleware
{
    public function handle($request, Closure $next) 
    {
        if($request->route() != 'password.update' || !$request->session()->has('invytr')) 
            return $next($request);

        if(config('auth.passwords.users.invites_expire')) 
            config(['auth.passwords.users.expire' => config('auth.passwords.users.invites_expire')]);

        $translator = new Translator();
        $translator->replaceResponseLines();

        $response = $next($request);
        if(!$request->session()->get('errors')) 
            $request->session()->forget('invytr');

        return $response;
    }
}
