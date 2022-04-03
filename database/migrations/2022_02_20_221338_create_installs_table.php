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
        Schema::create('installs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id');
            $table->string('name')->unique();
            $table->enum('type', ['prd', 'stg', 'dev']);
            $table->boolean('locked')->default(false);
            $table->enum('status', ['initiated', 'creating', 'created', 'ready', 'down', 'destroying', 'destroyed'])->default('initiated');
            $table->foreign('site_id')->references('id')->on('sites');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('installs');
    }
};
