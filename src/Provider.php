<?php

namespace GlaivePro\Invytr;

use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
		// $this->publishes([
		// 		__DIR__.'/config.php' => config_path('hidevara.php'),
		// ], 'config');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
		//$this->mergeConfigFrom(__DIR__.'/config.php', 'hidevara');
    }
}