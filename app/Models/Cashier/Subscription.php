<?php

namespace App\Models\Cashier;

use App\Models\Plan;
use App\Models\Site;
use DB;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Cashier\Subscription as CashierSubscription;

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

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'name', 'name');
    }

    public function period(): Attribute
    {
        return new Attribute(
            get: function () {
                if ($this->plan->stripe_yearly_price_id === $this->stripe_price) {
                    return 'yearly';
                } elseif ($this->plan->stripe_monthly_price_id === $this->stripe_price) {
                    return 'monthly';
                }

                return null;
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
