<?php

namespace App\Models\Cashier;

use App\Models\Site;
use DB;
use Laravel\Cashier\Subscription as CashierSubscription;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends CashierSubscription
{
    use HasFactory;

    /**
     * Get all of the Sites for the Subscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Sites(): HasMany
    {
        return $this->hasMany(Site::class);
    }

    public function scopeAvailable($query)
    {
        return $query->has('sites', '<', DB::raw('`quantity`'));
    }
}
