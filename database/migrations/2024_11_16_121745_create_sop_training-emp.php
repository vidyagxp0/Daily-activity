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
        Schema::create('training_sop_employee', function (Blueprint $table) {
            $table->id();
            $table->integer('training_id')->nullable();
            $table->text('training_name')->nullable();
            $table->integer('sop_id')->nullable(); 
            $table->text('training_type')->nullable();
            $table->text('emp_id')->nullable();
            $table->date('startDate')->nullable();
            $table->date('endDate')->nullable();
            $table->integer('trainer')->nullable();
            $table->integer('total_minimum_time')->nullable();
            $table->integer('per_screen_run_time')->nullable();
            $table->integer('sop_spent_time')->nullable();
            $table->integer('attempt_count')->nullable();
            $table->integer('quize')->nullable();
            $table->string('status')->default('Pending');
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
        //
    }
};
