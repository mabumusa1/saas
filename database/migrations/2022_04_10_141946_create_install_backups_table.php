<?php

use App\Models\Install;
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
        Schema::create('install_backups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('install_id')->references('id')->on('installs');
            $table->text('description')->nullable();
            $table->string('s3_url');
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
        Schema::dropIfExists('install_backups');
    }
};
