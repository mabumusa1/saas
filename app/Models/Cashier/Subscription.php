<?php

namespace App\Models\Cashier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Paddle\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{
    use HasFactory;
}
