<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function dataCenter()
    {
        return $this->belongsTo(DataCenter::class);
    }

    public function Users()
    {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('role');
    }
}
