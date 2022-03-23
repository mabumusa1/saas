<?php

namespace App\Facades;

use App\Resolvers\AccountResolver as ActivitylogCauserResolver;
use Illuminate\Support\Facades\Facade;

class AccountResolver extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ActivitylogCauserResolver::class;
    }
}
