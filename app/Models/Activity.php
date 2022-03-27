<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Contracts\Activity as ActivityContract;
use Spatie\Activitylog\Models\Activity as SpatieActivity;

class Activity extends SpatieActivity implements ActivityContract
{
    use HasFactory;

    /**
     * Get the account for this activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Scope a query to only include activity for a specific account.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @param  int  $accountId
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnAccount(Builder $query, int $accountId): Builder
    {
        return $query->where('account_id', $accountId);
    }
}
