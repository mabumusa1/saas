<?php

namespace App\Models;

use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Environment extends Model
{
    use HasFactory;

    /**
     * Get the Site that owns the Environment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * Get the Environment type.
     *
     * @param  string  $value
     * @return string
     */
    public function getTypeAttribute($value)
    {
        return  Str::upper($value);
    }
}
