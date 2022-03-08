<?php

namespace App\Models\Cashier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Cashier\Subscription as CashierSubscriptionItem;

class SubscriptionItem extends CashierSubscriptionItem
{
    use HasFactory;
}
