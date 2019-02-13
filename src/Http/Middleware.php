<?php

namespace GlaivePro\Invytr\Http;

use Closure;
use GlaivePro\Invytr\Helpers\Translator;
use Illuminate\Http\Request;

class Middleware
{
    public function handle($request, Closure $next)
    {
        // This is set on 302 that's still after the password set
        if ($request->session()->has('invytr_done')) {
            return $this->handleAfterRedirect($request, $next);
        }
        
        // We only continue if it's the update route and Invytr is working
        if (! ($request->route()->getName() == 'password.update' && $request->session()->has('invytr'))) {
            return $next($request);
        }
            
        // Update config if the expire value is specified
        if (config('auth.passwords.users.invites_expire')) {
            config(['auth.passwords.users.expire' => config('auth.passwords.users.invites_expire')]);
        }

        // Let the responses use setting strings instead of resetting strings
        $this->replaceLanguageStrings();
        
        $response = $next($request);
        
        // If there were no errors, password setting is done
        if (! $request->session()->get('errors')) {
            $request->session()->forget('invytr');
            
            // In case of redirect after the setting we have to remember to fix language strings again
            if (302 == $response->status()) {
                $request->session()->put('invytr_done', true);
            }
        }
        
        return $response;
    }
    
    protected function handleAfterRedirect($request, Closure $next)
    {
        $this->replaceLanguageStrings();
        
        $response = $next($request);
        
        // If this is no more a redirect -> we are done
        if (302 != $response->status()) {
            $request->session()->forget('invytr_done');
        }

        return $response;
    }
    
    protected function replaceLanguageStrings()
    {
        $translator = new Translator();
        $translator->replaceResponseLines();
    }
}
