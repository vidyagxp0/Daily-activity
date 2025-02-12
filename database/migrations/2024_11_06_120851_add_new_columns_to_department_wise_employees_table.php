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
        Schema::table('department_wise_employees', function (Blueprint $table) {
            // $table->boolea('training_effective')->nullable();
            $table->boolean('training_effective')->default(false);
            $table->integer('attempt_count')->default(3); 
            $table->longtext('training_completion')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('department_wise_employees', function (Blueprint $table) {
            //
        });
    }
};
