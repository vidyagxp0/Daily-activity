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
            
            $table->longText("employee_names")->nullable();
            $table->text('stage')->nullable();
            $table->text('status')->nullable();

            for($i=1; $i<=5 ; $i++)
            {
            
             $table->longText("document_number_$i")->nullable();
             $table->longText("document_title_$i")->nullable();

             $table->date("startdate_$i")->nullable();
             $table->date("enddate_$i")->nullable();
             
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
