<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Site extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the Account that owns the Site.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get all of the Installs for the Site.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Installs(): HasMany
    {
        return $this->hasMany(Install::class);
    }

    /**
     * Get all of the Groups for the Site.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }
}
