<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Models\Activity as SpatieActivity;

class Activity extends SpatieActivity
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
