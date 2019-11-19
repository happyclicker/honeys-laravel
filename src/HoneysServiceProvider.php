<?php namespace Happyclicker\Honeys;

use Illuminate\Support\ServiceProvider;

class HoneysServiceProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register($options = [])
    {
        $this->app->singleton(Honeys::class, function() use ($options) {
              return new Honeys($options);
        });
    }
}
