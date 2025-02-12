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
        Schema::create('e_h_s_root_cause_methadology_grids', function (Blueprint $table) {
            $table->id();            
            $table->text('type')->nullable();
            $table->text('ehsEvent_id')->nullable();
            $table->string('identifier')->nullable();
            $table->longText('data1')->nullable();             
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
        Schema::dropIfExists('e_h_s_root_cause_methadology_grids');
    }
};
