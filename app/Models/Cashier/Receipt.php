<?php

namespace App\Models\Cashier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Paddle\Receipt as CashierReceipt;

class Receipt extends CashierReceipt
{
    use HasFactory;
}
