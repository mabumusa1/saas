<?php

use Illuminate\Support\Facades\Facade;

class Kub8 extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'kub8';
    }
}
