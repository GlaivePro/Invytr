<?php

namespace GlaivePro\Invytr\Http;
    
use Closure;
use GlaivePro\Invytr\Helpers\Translator;
use Illuminate\Http\Request;

class Middleware
{
    public function handle($request, Closure $next) 
    {
        if($request->route() == 'password.update' && $request->session()->has('invytr')) {
            if(config('auth.passwords.users.invites_expire')) {
                config(['auth.passwords.users.expire' => config('auth.passwords.users.invites_expire')]);
            }

            Translator::replaceResponseLines();

            $request->session()->forget('invytr');
        }
        return $next($request);
    }
}
