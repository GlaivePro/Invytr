<?php

namespace GlaivePro\Invytr\Http;
    
use Closure;
use Illuminate\Http\Request;

class Middleware
{
    public function handle($request, Closure $next) 
    {
        return $next($request);
    }
}
