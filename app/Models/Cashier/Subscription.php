<?php

namespace App\Models\Cashier;

use App\Models\Site;
use Illuminate\Database\Eloquent\Casts\Attribute;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Cashier\Subscription as CashierSubscription;
use App\Models\Plan;

class Subscription extends CashierSubscription
{
    use HasFactory;

    public function sites()
    {
        return $this->hasMany(Site::class);
    }

    public function scopeAvailable($query)
    {
        return $query->has('sites', '<', DB::raw('`quantity`'));
    }

    /**
     * Get User Full Name.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function displayName(): Attribute
    {

        $plan = Plan::where('name', $this->name)->firstOrFail();

        return new Attribute(
            get: fn ($value) => $plan->display_name,
        );
    }    
}
