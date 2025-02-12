<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_h_s_training_and_awarenesss_grids', function (Blueprint $table) {
            $table->id();
            $table->integer('ehsEvent_id')->nullable();
            $table->text('identifier')->nullable();
            $table->longText('data')->nullable();
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
        Schema::dropIfExists('e_h_s_training_and_awarenesss_grids');
    }
};
