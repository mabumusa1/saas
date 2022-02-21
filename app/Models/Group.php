<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    use HasFactory;

    /**
     * Get all of the sites for the Group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Sites(): BelongsToMany
    {
        return $this->belongsToMany(Site::class);
    }
}
