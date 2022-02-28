<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataCenter extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'label',
        'region',
    ];
}
