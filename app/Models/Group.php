<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name', 'notes',
    ];

    /**
     * Get all of the sites for the Group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Sites(): BelongsToMany
    {
        return $this->belongsToMany(Site::class);
    }

    public function hasSite($site)
    {
        return $this->Sites->contains($site);
    }

    /**
     * Get the Account that owns the Group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
