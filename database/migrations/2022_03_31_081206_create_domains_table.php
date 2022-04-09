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
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('install_id')->constrained()->references('id')->on('installs');
            $table->string('name')->unique();
            $table->string('redirect_to')->nullable();
            $table->boolean('primary')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->boolean('verification_failed')->default(false);
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
        Schema::dropIfExists('domains');
    }
};
