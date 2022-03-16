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
            $table->string('name');
            $table->enum('type', ['prd', 'stg', 'dev']);
            $table->enum('owner', ['mine', 'transferable']);
            $table->enum('status', ['initiated', 'creating', 'created', 'ready', 'down', 'destroying', 'destroyed'])->default('initiated');
            $table->string('transfer_key')->nullable();
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
