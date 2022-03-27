<?php

namespace App\Models\Cashier;

use App\Models\Plan;
use App\Models\Site;
use Database\Factories\SubscriptionFactory;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{
    /**
     * Get all of the sites for the Subscription.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sites(): HasMany
    {
        return $this->hasMany(Site::class);
    }

    /**
     * Scope a query to check if it has available sites.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query): Builder
    {
        return $query->has('sites', '<', DB::raw('`quantity`'));
    }

    /**
     * Get the plan that owns the Subscription.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'name', 'name');
    }

    /**
     * Get Plan Period.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function period(): Attribute
    {
        return new Attribute(
            get: function () {
                /* @phpstan-ignore-next-line */
                $plan = $this->plan;
                if ($plan->stripe_yearly_price_id === $this->stripe_price) {
                    return 'yearly';
                }
                if ($plan->stripe_monthly_price_id === $this->stripe_price) {
                    return 'monthly';
                }

                return null;
            }
        );
    }

    /**
     * Get Plan Display Name.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function displayName(): Attribute
    {
        $plan = Plan::where('name', $this->name)->first();

        return new Attribute(
            get: fn () => $plan->display_name,
        );
    }
}
