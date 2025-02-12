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
        Schema::table('t_n_i_employees', function (Blueprint $table) {

            for($i=1; $i<=5 ; $i++)
            {
             $table->longText("total_minimum_time_$i")->nullable();
             $table->longText("per_screen_run_time_$i")->nullable();
             $table->date("sop_spent_time_$i")->nullable();
 
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_n_i_employees', function (Blueprint $table) {
            //
        });
    }
};
