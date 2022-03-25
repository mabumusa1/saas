<?php

namespace App\Models\Cashier;

use App\Models\Plan;
use App\Models\Site;
use DB;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'name', 'name');
    }

    public function period(): Attribute
    {
        return new Attribute(
            get: function () {
                /* @phpstan-ignore-next-line */
                $plan = $this->plan;
                if ($plan->stripe_yearly_price_id === $this->stripe_price) {
                    return 'yearly';
                } elseif ($plan->stripe_monthly_price_id === $this->stripe_price) {
                    return 'monthly';
                } else {
                    return null;
                }
            }
        );
    }

    /**
     * Get User Full Name.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function displayName(): Attribute
    {
        $plan = Plan::where('name', $this->name)->first();

        return new Attribute(
            get: fn ($value) => $plan->display_name,
        );
    }
}
