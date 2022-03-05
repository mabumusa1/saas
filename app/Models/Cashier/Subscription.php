<?php

namespace App\Models\Cashier;

use App\Models\Site;
use DB;
use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{
    public function sites()
    {
        return $this->hasMany(Site::class);
    }

    public function scopeAvailable($query)
    {
        return $query->has('sites', '<', DB::raw('`quantity`'));
    }
}
