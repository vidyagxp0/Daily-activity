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
        Schema::create('change_control_training_datas', function (Blueprint $table) {
            $table->id();
            $table->integer('cc_id')->nullable();
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
        Schema::dropIfExists('change_control_training_datas');
    }
};
