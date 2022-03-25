<?php

namespace Tests\Feature\Listeners;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutEventListner extends TestCase
{
    use RefreshDatabase;
}
