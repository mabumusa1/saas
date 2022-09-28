<?php

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
