<?php

namespace App\Models;

use App\Models\AccountUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Cashier\Billable;

class Account extends Model
{
    use HasFactory, SoftDeletes, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the Data Center that owns the Account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dataCenter(): BelongsTo
    {
        return $this->belongsTo(DataCenter::class);
    }

    /**
     * The Users that belong to the Account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(AccountUser::class)->withTimestamps()->withPivot('role');
    }

    /**
     * Get all of the sites for the Account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Sites(): HasMany
    {
        return $this->hasMany(Site::class);
    }

    /**
     * Get all of the Groups for the Account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }
}
