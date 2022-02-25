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
            $table->string('name');
            $table->string('short_description');
            $table->unsignedInteger('monthly_id')->nullable()->unique();
            $table->unsignedInteger('yearly_id')->nullable()->unique();
            $table->unsignedInteger('monthly_price')->nullable()->unique();
            $table->unsignedInteger('yearly_price')->nullable()->unique();
            $table->json('features')->nullable();
            $table->json('options')->nullable();
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
