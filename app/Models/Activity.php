<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Contracts\Activity as ActivityContract;
use Spatie\Activitylog\Models\Activity as SpatieActivity;

class Activity extends SpatieActivity implements ActivityContract
{
    use HasFactory;

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function scopeOnAccount(Builder $query, $accountId)
    {
        return $query->where('account_id', $accountId);
    }
}
