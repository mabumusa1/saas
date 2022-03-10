<?php

use App\Models\Plan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name');
            $table->string('short_description');
            $table->string('stripe_product_id')->charset('utf8')->collate('utf8_cs')->nullable()->unique();
            $table->string('stripe_monthly_price_id')->charset('utf8')->collate('utf8_cs')->nullable()->unique();
            $table->string('stripe_yearly_price_id')->charset('utf8')->collate('utf8_cs')->nullable()->unique();
            $table->string('monthly_price')->nullable()->unique();
            $table->string('yearly_price')->nullable()->unique();
            $table->integer('contacts')->nullable();
            $table->json('features')->nullable();
            $table->json('options')->nullable();
            $table->boolean('archived')->default(false);
            $table->boolean('available')->default(false);
            $table->timestamps();
        });

        $plans = [
            [
                'name' => 's1',
                'display_name' => 'Small - 2,500 Leads',
                'short_description' => 'Small Mautic installation supports up to 2,500 leads',
                'stripe_product_id' => 'prod_LF6rlbuqYaz6k1',
                'stripe_monthly_price_id' => 'price_1KYcdZJJANQIX4AvM2ySzZzb',
                'stripe_yearly_price_id' => 'price_1KYcdZJJANQIX4AvZvUiYVZz',
                'monthly_price' => 50,
                'yearly_price' => 500,
                'features' => ['2,500 Contacts', 'Backups', 'Hosting', 'Security', 'Scalablity'],
                'contacts' => 2500,
                'options' => ['backups', 'hosting'],
                'archived' => false,
                'available' => true
            ],
            [
                'name' => 's2',
                'display_name' => 'Small - 5,000 Leads',
                'short_description' => 'Small Mautic installation supports up to 5,000 leads',
                'stripe_product_id' => 'prod_LF6s7lYCom7rlX',
                'stripe_monthly_price_id' => 'price_1KYcesJJANQIX4Avxz5hB5bE',
                'stripe_yearly_price_id' => 'price_1KYcesJJANQIX4AvzHkRsIJH',
                'monthly_price' => 90,
                'yearly_price' => 900,
                'contacts' => 5000,
                'features' => [
                    '5,000 Contacts',
                    'Backups',
                    'Hosting',
                    'Security',
                    'Scalablity',
                ],
                'options' => [
                    'backups',
                    'hosting',
                ],
                'archived' => false,
                'available' => true

            ],
            [
                'name' => 's3',
                'display_name' => 'Small  - 10,000 Leads',
                'short_description' => 'Small Mautic installation supports up to 10,000 leads',
                'stripe_product_id' => 'prod_LF6tUBa5qTUGXi',
                'stripe_monthly_price_id' => 'price_1KYcfzJJANQIX4AvptH5iG6h',
                'stripe_yearly_price_id' => 'price_1KYcfzJJANQIX4AvQgoUXy6q',
                'monthly_price' => 160,
                'yearly_price' => 1600,
                'contacts' => 10000,
                 'features' => [
                     '10,000 Contacts',
                     'Backups',
                     'Hosting',
                     'Security',
                     'Scalablity',
                 ],
                'options' => [
                    'backups',
                    'hosting',
                ],
                'archived' => false,
                'available' => true

            ],
            [
                'name' => 's4',
                'display_name' => 'Medium  - 25,000 Leads',
                'short_description' => 'Medium Mautic installation supports up to 25,000 leads',
                'stripe_product_id' => 'prod_LF6uwus92kbRIz',
                'stripe_monthly_price_id' => 'price_1KYcgYJJANQIX4AvPPlAS0z3',
                'stripe_yearly_price_id' => 'price_1KYcgYJJANQIX4AvYfnTSVwv',
                'monthly_price' => 420,
                'yearly_price' => 4200,
                'contacts' => 25000,
                 'features' => [
                    '25,000 Contacts',
                    'Backups',
                    'Hosting',
                    'Security',
                    'Scalablity',
                ],
                'options' => [
                    'backups',
                    'hosting',
                ],
                'archived' => false,
                'available' => true
            ],
            [
                'name' => 's5',
                'display_name' => 'Medium  - 50,000 Leads',
                'short_description' => 'Medium Mautic installation supports up to 50,000 leads',
                'stripe_product_id' => 'prod_LF6vLk0UO67X1C',
                'stripe_monthly_price_id' => 'price_1KYchzJJANQIX4AvRPRPJ1rc',
                'stripe_yearly_price_id' => 'price_1KYchzJJANQIX4AvCfLCKqjQ',
                'monthly_price' => 800,
                'yearly_price' => 8000,
                'contacts' => 50000,
                'features' => [
                    '50,000 Contacts',
                    'Backups',
                    'Hosting',
                    'Security',
                    'Scalablity',
                ], 
                'options' => [
                    'backups',
                    'hosting',
                ],
                'archived' => false,
                'available' => true
            ],
            [
                'name' => 'e1',
                'display_name' => 'Medium  - 100,000 Leads',
                'short_description' => 'Medium Mautic installation supports up to 100,000 leads',
                'stripe_product_id' => 'prod_LF6wAwAk4ArHOS',
                'stripe_monthly_price_id' => 'price_1KYcimJJANQIX4Avv75iUzp1',
                'stripe_yearly_price_id' => 'price_1KYcimJJANQIX4Av3MAHwrgy',
                'monthly_price' => 1250,
                'yearly_price' => 15000,
                'contacts' => 100000,
                'features' => [
                    '100,000 Contacts',
                    'Backups',
                    'Hosting',
                    'Security',
                    'Scalablity',
                ], 
                'options' => [
                    'backups',
                    'hosting',
                ],
                'archived' => false,
                'available' => false
            ],
            [
                'name' => 'e2',
                'display_name' => 'Large  - 500,000 Leads',
                'short_description' => 'Large Mautic installation supports up to 500,000 leads',
                'stripe_product_id' => 'prod_LF6x69Hid575eB',
                'stripe_monthly_price_id' => 'price_1KYcjqJJANQIX4AvvUdeqRg5',
                'stripe_yearly_price_id' => 'price_1KYcjqJJANQIX4Av6PJzUZDc',
                'monthly_price' => 5417,
                'yearly_price' => 65000,
                'contacts' => 500000,
                 'features' => [
                    '500,000 Contacts',
                    'Backups',
                    'Hosting',
                    'Security',
                    'Scalablity',
                ],
                'options' => [
                    'backups',
                    'hosting',
                ],
                'archived' => false,
            ],
            [
                'name' => 'e3',
                'display_name' => 'Large  - 1 Million Leads',
                'short_description' => 'Large Mautic installation supports up to 1 Million leads',
                'stripe_product_id' => 'prod_LF6ysK1apCBoV4',
                'stripe_monthly_price_id' => 'price_1KYckmJJANQIX4Av1pIg6bmI',
                'stripe_yearly_price_id' => 'price_1KYckmJJANQIX4Avc3dSSjXH',
                'monthly_price' => 10833,
                'yearly_price' => 130000,
                'contacts' => 1000000,
                'features' => [
                    '1 Million Contacts',
                    'Backups',
                    'Hosting',
                    'Security',
                    'Scalablity',
                ], 
                'options' => [
                    'backups',
                    'hosting',
                ],
                'archived' => false,
            ],
            [
                'name' => 'e4',
                'display_name' => 'Large  - 1.5 Million Leads',
                'short_description' => 'Large Mautic installation supports up to 1.5 Million leads',
                'stripe_product_id' => 'prod_LF6zckLODLIHi3',
                'stripe_monthly_price_id' => 'price_1KYcleJJANQIX4AvAQ9YDNng',
                'stripe_yearly_price_id' => 'price_1KYcleJJANQIX4AvQmpUq5L5',
                'monthly_price' => 15833,
                'yearly_price' => 190000,
                'contacts' => 1500000,
                 'features' => [
                    '1.5 Million Contacts',
                    'Backups',
                    'Hosting',
                    'Security',
                    'Scalablity',
                ],
                'options' => [
                    'backups',
                    'hosting',
                ],
                'archived' => false,
            ],

        ];

        foreach ($plans as $plan) {
            $m = new Plan($plan);
            $m->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
};
