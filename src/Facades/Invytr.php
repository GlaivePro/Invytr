<?php

namespace GlaivePro\Invytr\Facades;

use GlaivePro\Invytr\Invytr;
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
        return Invytr::class;
    }
}
