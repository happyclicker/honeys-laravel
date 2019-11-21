<?php namespace Happyclicker\Honeys;


class Facade extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return Honeys::class;
    }
}