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
        Schema::create('data_centers', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('region');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('data_centers')->insert(
            [
                'label' => 'us-east-1',
                'region' => 'us-east-1',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_centers');
    }
};
