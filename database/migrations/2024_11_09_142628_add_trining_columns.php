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
        Schema::table('t_n_i_matrixdatas', function (Blueprint $table) {
            $table->integer('total_minimum_time')->nullable();
            $table->integer('per_screen_run_time')->nullable();
            $table->integer('sop_spent_time')->nullable();
        });
        Schema::table('department_wise_employees', function (Blueprint $table) {
            $table->integer('total_minimum_time')->nullable();
            $table->integer('per_screen_run_time')->nullable();
            $table->integer('sop_spent_time')->nullable();
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
