<?php
namespace GlaivePro\Invytr\Tests;

use GlaivePro\Invytr\Facades\Invytr;
use GlaivePro\Invytr\Provider;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider
     * @param  \Illuminate\Foundation\Application $app
     * @return GlaivePro\Invytr\Provider
     */
    protected function getPackageProviders($app)
    {
        return [Provider::class];
    }

    /**
     * Load package alias
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Invytr' => Invytr::class,
        ];
    }
}
