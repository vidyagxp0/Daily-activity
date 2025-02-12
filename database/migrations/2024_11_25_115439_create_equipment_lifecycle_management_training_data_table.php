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
        Schema::create('equipment_lifecycle_management_training_data', function (Blueprint $table) {
            $table->id();
            $table->integer('equipmentInfo_id')->nullable();
            $table->text('trainingTopic')->nullable();
            $table->integer('documentNumber')->nullable(); 
            $table->text('documentName')->nullable();
            $table->text('sopType')->nullable();
            $table->text('trainingType')->nullable();
            $table->text('trainees')->nullable();
            $table->date('startDate')->nullable();
            $table->date('endDate')->nullable();
            $table->integer('trainer')->nullable();
            $table->integer('trainingAttempt')->nullable();
            $table->integer('total_minimum_time')->default(0);
            $table->integer('per_screen_run_time')->default(0);
            $table->integer('sop_spent_time')->default(0);
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
        Schema::dropIfExists('equipment_lifecycle_management_training_data');
    }
};
