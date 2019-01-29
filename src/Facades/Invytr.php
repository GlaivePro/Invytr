<?php

namespace GlaivePro\Invytr\Facades;

use Illuminate\Support\Facades\Facade;

class Invytr extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \GlaivePro\Invytr\Invytr::class;
    }
}
