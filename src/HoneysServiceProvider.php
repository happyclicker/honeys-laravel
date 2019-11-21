<?php namespace Happyclicker\Honeys;

class HoneysServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public function boot()
    {

    }

    public function register($options = [])
    {
        $this->app->singleton(Honeys::class, function() use ($options) {
              return new Honeys($options);
        });

        $this->app->alias(Honeys::class, 'honeys');
    }
}