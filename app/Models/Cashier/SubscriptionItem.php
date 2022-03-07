<?php

namespace App\Models\Cashier;

use Laravel\Cashier\Subscription as CashierSubscriptionItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionItem extends CashierSubscriptionItem
{
    use HasFactory;
}
