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
        Schema::create('meeting_grids', function (Blueprint $table) {
            $table->id();
            $table->integer('meeting_id')->nullable();
            $table->text('identifier')->nullable();
            $table->longText('data')->nullable();
            $table->text('grid_date')->nullable();
            $table->longText('topic')->nullable();
            $table->longText('responsible')->nullable();
            $table->longText('scheduled_start_time_grid')->nullable();
            $table->longText('scheduled_end_time_grid')->nullable();
            $table->longText('remarks')->nullable();
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
        Schema::dropIfExists('meeting_grids');
    }
};
